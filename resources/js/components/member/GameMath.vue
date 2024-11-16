<template>
    <div id="game-content">
      <!-- Modal -->
      <div id="modal">
        <div id="modalContent">
            <h2>Apakah Anda ingin bermain lagi?</h2>
            <button id="playAgainBtn">Ya</button>
            <button id="exitBtn">Tidak</button>
        </div>
    </div>
    </div>
  </template>
  
  <script>
  import { onMounted, onBeforeUnmount } from 'vue';
  import Swal from 'sweetalert2'
  import * as PIXI from 'pixi.js';
  
  export default {
    setup() {
		let app = null;

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

		onMounted(async () => {
			const parameter = await fetchData();
			
			// Only proceed with PixiJS if data is available (or based on your conditions)
			if (parameter==1 || parameter==3) {
				const baca = await fetchBaca();

				if(baca.code==1){
					// Membuat aplikasi PixiJS dengan ukuran penuh
					const gameContainer = document.getElementById('game-content');
	
					app = new PIXI.Application({ resizeTo: window, backgroundColor: 0xffffff });
					gameContainer.appendChild(app.view);
					app.view.style.width = '100%';
					app.view.style.height = '100%';
	
					// Menambahkan latar belakang
					const backgroundTexture = PIXI.Texture.from('game/math/background.png');
					const backgroundSprite = new PIXI.Sprite(backgroundTexture);
					backgroundSprite.anchor.set(0.5);
					backgroundSprite.width = app.screen.width;
					backgroundSprite.height = app.screen.height;
					backgroundSprite.x = app.screen.width / 2;
					backgroundSprite.y = app.screen.height / 2;
					app.stage.addChild(backgroundSprite);
	
					// Latar belakang untuk teks soal
					const questionTextBackgroundTexture = PIXI.Texture.from('game/math/board.png');
					const questionTextBackground = new PIXI.Sprite(questionTextBackgroundTexture);
					questionTextBackground.anchor.set(0.5);
					questionTextBackground.width = 650;
					questionTextBackground.height = 300;
					questionTextBackground.x = app.screen.width / 2;
					questionTextBackground.y = app.screen.height / 2 - 150;
					app.stage.addChild(questionTextBackground);
	
					// Elemen teks untuk soal
					const questionText = new PIXI.Text('', { fontSize: 40, fill: '#fff' });
					questionText.anchor.set(0.5);
					questionText.x = questionTextBackground.x;
					questionText.y = questionTextBackground.y;
					app.stage.addChild(questionText);
	
					// Elemen skor
					let score = 0;
					const scoreText = new PIXI.Text('Score: 0', { fontSize: 30, fill: '#fff' });
					scoreText.x = 20;
					scoreText.y = 20;
					app.stage.addChild(scoreText);
	
					// Variabel soal saat ini
					let currentQuestion = { question: '', answer: 0, options: [] };
					let optionTexts = [];
					let questionCount = 0;
					let results = []; // Array untuk menyimpan hasil pertanyaan
	
					// Fungsi untuk menghasilkan soal baru dengan pilihan ganda
					function generateQuestion() {
						const num1 = Math.floor(Math.random() * 10) + 1;
						const num2 = Math.floor(Math.random() * 10) + 1;
						currentQuestion.answer = num1 + num2;
						currentQuestion.question = `${num1} + ${num2} = ?`;
	
						currentQuestion.options = [currentQuestion.answer];
						while (currentQuestion.options.length < 4) {
							const option = Math.floor(Math.random() * 20) + 1;
							if (!currentQuestion.options.includes(option)) {
								currentQuestion.options.push(option);
							}
						}
						currentQuestion.options.sort(() => Math.random() - 0.5);
	
						questionText.text = currentQuestion.question;
						renderOptions();
					}
	
					// Fungsi untuk menampilkan pilihan ganda di dalam kanvas
					function renderOptions() {
						optionTexts.forEach(text => app.stage.removeChild(text));
						optionTexts = [];
	
						currentQuestion.options.forEach((option, index) => {
							const optionText = new PIXI.Text(option, {
								fontSize: 30,
								fill: '#fff',
							});
							optionText.anchor.set(0.5);
							optionText.x = app.screen.width / 2 - 150 + (index * 100);
							optionText.y = app.screen.height / 2 - 80;
	
							optionText.interactive = true;
							optionText.buttonMode = true;
	
							optionText.on('pointerdown', () => checkAnswer(option));
							app.stage.addChild(optionText);
							optionTexts.push(optionText);
						});
					}
	
					function checkAnswer(selectedOption) {
						const isCorrect = selectedOption === currentQuestion.answer;
						if (isCorrect) {
							score++;
							scoreText.text = `Score: ${score}`;
							showCorrectAnimation();
						} else {
							showIncorrectAnimation();
						}
	
						// Simpan hasil pertanyaan
						results.push({
							question: currentQuestion.question,
							answer: currentQuestion.answer,
							selected: selectedOption,
							correct: isCorrect
						});
	
						questionCount++;
						if (questionCount < 10) {
							generateQuestion();
						} else {
							showScoreReview();
						}
					}
	
					let activeCrosses = [];
	
					function showCorrectAnimation() {
						const correctAnimation = new PIXI.Text('Horeee Benar!', { fontSize: 36, fill: '#00FF00' });
						correctAnimation.anchor.set(0.5);
						correctAnimation.x = app.screen.width / 2;
						correctAnimation.y = app.screen.height / 2 - 200;
						app.stage.addChild(correctAnimation);
	
						setTimeout(() => app.stage.removeChild(correctAnimation), 1000);
	
						const crossTexture = PIXI.Texture.from('game/math/happy.png');
						const crossSprite = new PIXI.Sprite(crossTexture);
						crossSprite.anchor.set(0.5);
						crossSprite.x = app.screen.width + 50; // Mulai di luar layar di sebelah kanan
						crossSprite.y = app.screen.height / 2 + 100;
						crossSprite.scale.set(0.5);
						app.stage.addChild(crossSprite);
	
						// Tambahkan crossSprite ke array activeCrosses
						activeCrosses.push(crossSprite);
	
						// Kecepatan untuk animasi bergerak ke kiri
						const speed = 5;
	
						// Tambahkan animasi bergerak ke kiri menggunakan app.ticker
						const moveLeft = delta => {
							crossSprite.x -= speed * delta;
	
							// Jika sprite keluar dari layar kiri
							if (crossSprite.x < -50) {
								// Hapus sprite dari stage dan array
								app.stage.removeChild(crossSprite);
								activeCrosses = activeCrosses.filter(sprite => sprite !== crossSprite);
								app.ticker.remove(moveLeft); // Hentikan animasi ini
							}
						};
	
						app.ticker.add(moveLeft);
					}
	
					function showIncorrectAnimation() {
						const incorrectAnimation = new PIXI.Text('Aduh Salah!', { fontSize: 36, fill: '#FF0000' });
						incorrectAnimation.anchor.set(0.5);
						incorrectAnimation.x = app.screen.width / 2;
						incorrectAnimation.y = app.screen.height / 2 - 200;
						app.stage.addChild(incorrectAnimation);
	
						setTimeout(() => app.stage.removeChild(incorrectAnimation), 1000);
	
						const crossTexture = PIXI.Texture.from('game/math/sad.png');
						const crossSprite = new PIXI.Sprite(crossTexture);
						crossSprite.anchor.set(0.5);
						crossSprite.x = app.screen.width + 50; // Mulai di luar layar di sebelah kanan
						crossSprite.y = app.screen.height / 2 + 100;
						crossSprite.scale.set(0.5);
						app.stage.addChild(crossSprite);
	
						// Tambahkan crossSprite ke array activeCrosses
						activeCrosses.push(crossSprite);
	
						// Kecepatan untuk animasi bergerak ke kiri
						const speed = 5;
	
						// Tambahkan animasi bergerak ke kiri menggunakan app.ticker
						const moveLeft = delta => {
							crossSprite.x -= speed * delta;
	
							// Jika sprite keluar dari layar kiri
							if (crossSprite.x < -50) {
								// Hapus sprite dari stage dan array
								app.stage.removeChild(crossSprite);
								activeCrosses = activeCrosses.filter(sprite => sprite !== crossSprite);
								app.ticker.remove(moveLeft); // Hentikan animasi ini
							}
						};
	
						app.ticker.add(moveLeft);
					}
	
					function showScoreReview() {
						// Tampilkan hasil setiap pertanyaan
						const resultsText = new PIXI.Text('', { fontSize: 24, fill: '#fff', wordWrap: true, wordWrapWidth: 600 });
						resultsText.anchor.set(0.5);
						resultsText.x = app.screen.width / 2;
						resultsText.y = app.screen.height / 2 - 50;
	
						const finalScoreText = new PIXI.Text(`Skor Akhir: ${score} / 10`, { fontSize: 36, fill: '#fff' });
						finalScoreText.anchor.set(0.5);
						finalScoreText.x = app.screen.width / 2;
						finalScoreText.y = app.screen.height / 2 + 100;
						app.stage.addChild(finalScoreText);
	
						// Tampilkan modal setelah 5 detik
						setTimeout(() => {
							showModal();
							app.stage.removeChild(finalScoreText);
						}, 1000);
					}
	
					function showModal() {
						document.getElementById('modal').style.display = 'flex';
	
						document.getElementById('playAgainBtn').onclick = () => {
							document.getElementById('modal').style.display = 'none';
							resetGame();
						};
						document.getElementById('exitBtn').onclick = () => {
							window.location.href = '/';
						};
					}
	
					function resetGame() {
						score = 0;
						questionCount = 0;
						results = []; // Reset hasil
						scoreText.text = 'Score: 0';
						generateQuestion();
					}
	
					function resizeElements() {
						backgroundSprite.width = app.screen.width;
						backgroundSprite.height = app.screen.height;
	
						questionTextBackground.x = app.screen.width / 2;
						questionTextBackground.y = app.screen.height / 2 - 150;
	
						questionText.x = questionTextBackground.x;
						questionText.y = questionTextBackground.y;
	
						scoreText.x = 20;
						scoreText.y = 20;
	
						currentQuestion.options.forEach((option, index) => {
							if (optionTexts[index]) {
								optionTexts[index].x = app.screen.width / 2 - 150 + (index * 100);
								optionTexts[index].y = app.screen.height / 2 - 80;
							}
						});
					}
	
					generateQuestion();
					window.addEventListener('resize', resizeElements);
					resizeElements();
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
			app.destroy(true, { children: true, texture: true, baseTexture: true });
		});
    }
  }
  </script>
  
  <style scoped>
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
  