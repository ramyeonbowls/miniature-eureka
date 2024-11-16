<template>
	<div id="game-content" class="card w-100 full-screen-card">
	  <!-- Modal -->
	  <div id="modal">
		<div id="modalContent">
		  <h4 :class="(currentScore >= 8 ? 'text-success' : (currentScore <= 7 && currentScore >= 5 ? 'text-warning' : 'text-danger'))">Skor Anda : {{ currentScore }}</h4>
		  <h2>Apakah Anda ingin bermain lagi?</h2>
		  <button id="playAgainBtn">Ya</button>
		  <button id="exitBtn">Tidak</button>
		</div>
	  </div>
  
	  <!-- Game UI -->
	  <div v-if="!gameOver">
		<h2>Susun huruf untuk membentuk kata dalam Bahasa Indonesia!</h2>
		<p class="text-start">
			<h4 class="text-muted">Skor: {{ currentScore }}</h4>
		</p>
		<div id="scrambled-word">
		  <h2>{{ scrambledWord }}</h2>
		</div>
		<div v-if="feedback" class="feedback">
			<h4 :class="isCorrectAnswer ? 'text-success' : 'text-danger'">{{ feedback }}</h4>
		</div>
		<input 
		  type="text" 
		  v-model="userGuess" 
		  placeholder="Masukkan jawaban" 
		  @keyup.enter="checkAnswer"
		/>
		<button @click="checkAnswer">Periksa Jawaban</button>

		<div v-if="feedback" class="feedback">
			<img 
				v-if="isCorrectAnswer" 
				src="game/scramble/correct.webp" 
				alt="Correct" 
				class="feedback-image"
			/>
			<img
				v-if="isIncorrectAnswer" 
				src="game/scramble/incorrect.webp" 
				alt="Incorrect" 
				class="feedback-image"
			/>
		</div>
	  </div>
	</div>
  </template>
  
  
<script>
  	import { ref, onMounted, onBeforeUnmount } from 'vue';
	import Swal from 'sweetalert2';

export default {
  setup() {
    const words = ref([]);
    const correctAnswer = ref('');
    const scrambledWord = ref('');
    const score = ref(0);
    const userGuess = ref('');
    const feedback = ref('');
    const currentScore = ref('0');
    const questionCount = ref(0); // To track number of questions answered
    const gameOver = ref(false);
    const isCorrectAnswer = ref(false);
    const isIncorrectAnswer = ref(false);

	const fetchData = async () => {
		try {
			const response = await axios.get('/getParam');
			return response.data.additional_features;
		} catch (error) {
			console.error('Error fetching data:', error);
			return null;
		}
	};

	const fetchBaca = async () => {
		try {
			const response = await axios.get('/getInfoBaca');
			return response.data;
		} catch (error) {
			console.error('Error fetching data:', error);
			return null;
		}
	};

	// Fetch words from API
	const fetchWords = async () => {
        try {
          const response = await axios.get('/getWords');  // Your API endpoint to get words
          words.value = response.data;  // Assume response contains { words: [...] }
          generateWord();  // Generate a word as soon as the words are fetched
        } catch (error) {
          console.error('Error fetching words:', error);
        }
    };

    // Function to scramble the word
    const scrambleWord = (word) => {
		const scrambled = word.split('').sort(() => Math.random() - 0.5).join('');
		return scrambled;
    };

    // Function to generate a random word and scramble it
    const generateWord = () => {
		const randomWord = words.value[Math.floor(Math.random() * words.value.length)];
		correctAnswer.value = randomWord;
		scrambledWord.value = scrambleWord(randomWord);
		isCorrectAnswer.value = false;
		isIncorrectAnswer.value = false;
    };

    // Function to check the player's answer
    const checkAnswer = () => {
		if(userGuess.value != ''){
			if (userGuess.value.toLowerCase() === correctAnswer.value.toLowerCase()) {
				const correctSound = new Audio('game/scramble/yay.mp3'); // Path to your sound file
				correctSound.play(); // Play the sound immediately

				// Stop the sound after 5 seconds
				setTimeout(() => {
					correctSound.pause(); // Pause the sound after 5 seconds
					correctSound.currentTime = 0; // Reset to the start of the sound
				}, 5000);

				feedback.value = 'Benar! Selamat!';
				score.value++;
				isCorrectAnswer.value = true;
				isIncorrectAnswer.value = false;
			} else {
				const incorrectSound = new Audio('game/scramble/boo.mp3'); // Path to your sound file
				incorrectSound.play(); // Play the sound immediately

				// Stop the sound after 5 seconds
				setTimeout(() => {
					incorrectSound.pause(); // Pause the sound after 5 seconds
					incorrectSound.currentTime = 0; // Reset to the start of the sound
				}, 5000);

				feedback.value = 'Salah, coba lagi!';
				isCorrectAnswer.value = false;
				isIncorrectAnswer.value = true;
			}
	  
			// Update the score display
			currentScore.value = `${score.value} / 10`;
	  
			questionCount.value++;
	  
			if (questionCount.value >= 10) {
			  	showModal();
			} else {
			  	setTimeout(() => generateWord(), 3000); // Generate a new word after a short delay
			}
	  
			// Hide feedback after 3 seconds
			setTimeout(() => {
				feedback.value = ''; 
				isCorrectAnswer.value = false;
				isIncorrectAnswer.value = false;
			}, 3000); // 3 seconds delay
			userGuess.value = ''; // Clear the input
		}
    };

    // Function to reset the game and continue
    const resetGame = () => {
		score.value = 0;
		questionCount.value = 0;
		currentScore.value = '0';
		feedback.value = '';
		generateWord();
    };

    // Show modal after 10 correct answers
    const showModal = () => {
		document.getElementById('modal').style.display = 'flex';
		document.getElementById('playAgainBtn').onclick = () => {
			document.getElementById('modal').style.display = 'none';
			resetGame();
		};
		document.getElementById('exitBtn').onclick = () => {
			window.location.href = '/'; // Redirect to home page
		};
    };

    // Start the game
	onMounted(async () => {
		const parameter = await fetchData();

		if (parameter==1 || parameter==3) {
			const baca = await fetchBaca();

				if(baca.code==1){
					fetchWords();
				}else{
					Swal.fire({
						icon: 'warning',
						text: baca.message,
						allowOutsideClick: false,
						allowEscapeKey: false,
						showCloseButton: false,
						showCancelButton: false
					}).then((result) => {
						window.location.href = '/';
					});
				}
		}else{
			Swal.fire({
				title: "Access Denied!",
				icon: 'error',
				allowOutsideClick: false,
				allowEscapeKey: false,
				showCloseButton: false,
				showCancelButton: false
			}).then((result) => {
				window.location.href = '/';
			});
		}
    });

    onBeforeUnmount(() => {
      // Cleanup
    });

    return {
		scrambledWord,
		userGuess,
		checkAnswer,
		feedback,
		currentScore,
		gameOver,
		showModal,
		isCorrectAnswer,
		isIncorrectAnswer,
    };
  },
};

  </script>
  
  <style scoped>
  .full-screen-card {
	height: 75vh; /* Adjust the 100px as needed for additional height */
	overflow-y: auto;
	}
  .game-container {
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	}

	.card {
	width: 350px;
	padding: 20px;
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	background-color: #fff;
	text-align: center;
	}

	.card-header {
	margin-bottom: 20px;
	}

	.card-body {
	margin-bottom: 20px;
	}

	.card-footer {
	margin-top: 20px;
	}

	input {
	font-size: 18px;
	padding: 10px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	}

	button {
	padding: 10px 20px;
	font-size: 16px;
	cursor: pointer;
	margin: 5px;
	background-color: #007bff;
	color: white;
	border: none;
	border-radius: 5px;
	}

	button:hover {
	background-color: #0056b3;
	}

	.feedback {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	}

	.feedback-image {
	width: 200px;
	height: 200px;
	object-fit: contain;
	margin-bottom: 10px;
	}

	#modal {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0, 0, 0, 0.5);
	justify-content: center;
	align-items: center;
	z-index: 1000;
	}

	#modalContent {
	background: white;
	padding: 20px;
	border-radius: 10px;
	text-align: center;
	}

	#modalContent button {
	margin: 10px;
	}
  </style>
  