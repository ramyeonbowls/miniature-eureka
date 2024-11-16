<template>
	<div id="game-content" class="game-container-wrapper">
	  <!-- The PixiJS canvas will be inserted here -->
	  
	  <!-- Game Over Screen -->
	  <div v-if="gameOver" class="game-over">
		<h1>Permainan Berakhir!</h1>
		<p>Skor Anda: {{ score }}</p>
		<button @click="restartGame">Mulai Ulang Game</button>
	  </div>
	  
	  <!-- Score Display -->
	  <div v-if="!gameOver" class="score">
		<h2>Skor: {{ score }}</h2>
	  </div>
	</div>
  </template>
  
  <script>
  import * as PIXI from 'pixi.js';
  
  export default {
	name: 'Game',
	data() {
	  return {
		app: null,
		bird: null,
		pipes: [],
		score: 0,
		birdVelocity: 0,
		gravity: 0.2,
		pipeSpeed: 4,
		pipeGap: 150,
		pipeWidth: 50,
		pipeInterval: null,
		gameOver: false,
		gameStarted: false,
		groundHeight: 50,
		speedIncreaseInterval: null,
		speedIncreaseRate: 0.1,
		maxPipeSpeed: 6,
		birdWidth: 50,
		birdHeight: 50,
	  };
	},
	methods: {
	  initGame() {
		// Initialize PixiJS application
		this.app = new PIXI.Application({
		  resizeTo: window,
		  backgroundColor: 0x87CEEB,
		});
  
		const gameContainer = document.getElementById('game-content');
		gameContainer.appendChild(this.app.view);
  
		this.app.view.style.width = '100%';
		this.app.view.style.height = `${this.getCanvasHeight()}px`;
  
		// Create bird sprite
		const birdTexture = PIXI.Texture.from('game/flyingbird/bird.png');
		this.bird = new PIXI.Sprite(birdTexture);
		this.updateBirdSize();
		this.bird.anchor.set(0.5);
		this.bird.x = this.app.screen.width / 4;
		this.bird.y = this.app.screen.height / 2;
		this.app.stage.addChild(this.bird);
  
		window.addEventListener('click', this.flapBird);
		this.pipeInterval = setInterval(this.createPipe, 1500);
		this.speedIncreaseInterval = setInterval(this.increaseDifficulty, 5000);
		this.addGround();
		this.app.ticker.add(this.gameLoop);
		window.addEventListener('resize', this.onResize);
	  },
  
	  increaseDifficulty() {
		if (this.pipeSpeed < this.maxPipeSpeed) {
		  this.pipeSpeed += this.speedIncreaseRate;
		}
	  },
  
	  gameLoop(delta) {
		if (this.gameOver) return;
  
		this.birdVelocity += this.gravity;
		this.bird.y += this.birdVelocity;
  
		const birdBottom = this.bird.y + this.bird.height / 2;
		const groundLevel = this.app.screen.height - this.groundHeight;
  
		if (birdBottom >= groundLevel) {
		  this.bird.y = groundLevel - this.bird.height / 2;
		  this.endGame();
		}
  
		if (this.bird.y < 0) {
		  this.bird.y = 0;
		}
  
		this.pipes.forEach((pipe) => {
		  pipe.top.x -= this.pipeSpeed;
		  pipe.bottom.x -= this.pipeSpeed;
		});
  
		this.pipes = this.pipes.filter((pipe) => pipe.top.x + pipe.top.width > 0);
  
		this.pipes.forEach((pipe) => {
		  if (
			this.bird.x + this.bird.width / 2 > pipe.top.x &&
			this.bird.x - this.bird.width / 2 < pipe.top.x + pipe.top.width
		  ) {
			if (
			  this.bird.y - this.bird.height / 2 < pipe.top.height ||
			  this.bird.y + this.bird.height / 2 > pipe.bottom.y
			) {
			  this.endGame();
			}
		  }
		});
  
		this.pipes.forEach((pipe) => {
		  if (pipe.top.x + pipe.top.width < this.bird.x && !pipe.scored) {
			pipe.scored = true;
			this.score++;
		  }
		});
	  },
  
	  flapBird() {
		if (this.gameOver) return;
		this.birdVelocity = -5;
		if (!this.gameStarted) {
		  this.gameStarted = true;
		}
	  },
  
	  createPipe() {
		const pipeHeight = Math.floor(Math.random() * (this.app.screen.height / 2)) + 100;
  
		const topPipe = new PIXI.Graphics();
		topPipe.beginFill(0x008000);
		topPipe.drawRect(0, 0, this.pipeWidth, pipeHeight);
		topPipe.endFill();
		topPipe.x = this.app.screen.width;
		topPipe.y = 0;
  
		const bottomPipe = new PIXI.Graphics();
		bottomPipe.beginFill(0x008000);
		bottomPipe.drawRect(0, 0, this.pipeWidth, this.app.screen.height - pipeHeight - this.pipeGap);
		bottomPipe.endFill();
		bottomPipe.x = this.app.screen.width;
		bottomPipe.y = pipeHeight + this.pipeGap;
  
		this.pipes.push({ top: topPipe, bottom: bottomPipe, scored: false });
  
		this.app.stage.addChild(topPipe);
		this.app.stage.addChild(bottomPipe);
	  },
  
	  addGround() {
		const ground = new PIXI.Graphics();
		ground.beginFill(0x8B4513);
		ground.drawRect(0, this.app.screen.height - this.groundHeight, this.app.screen.width, this.groundHeight);
		ground.endFill();
  
		this.app.stage.addChild(ground);
	  },
  
	  endGame() {
		this.gameOver = true;
		clearInterval(this.pipeInterval);
		clearInterval(this.speedIncreaseInterval);
	  },
  
	  restartGame() {
		this.app.destroy(true, { children: true, texture: true, baseTexture: true });
		this.pipes = [];
		this.score = 0;
		this.gameOver = false;
		this.gameStarted = false;
  
		this.initGame();
	  },
  
	  onResize() {
		this.app.renderer.resize(window.innerWidth, window.innerHeight);
		this.app.view.style.height = `${this.getCanvasHeight()}px`;
  
		this.bird.x = this.app.screen.width / 4;
		this.bird.y = this.app.screen.height / 2;
  
		this.updateBirdSize();
		this.groundHeight = 50;
	  },
  
	  updateBirdSize() {
		const windowWidth = window.innerWidth;
		const windowHeight = window.innerHeight;
  
		if (windowWidth < 600) {
		  this.birdWidth = windowHeight * 0.08;  // Bird width is 8% of the screen height
		  this.birdHeight = windowHeight * 0.08; // Bird height is 8% of the screen height
		} else {
		  this.birdWidth = 50;
		  this.birdHeight = 50;
		}
  
		this.bird.width = this.birdWidth;
		this.bird.height = this.birdHeight;
	  },
  
	  getCanvasHeight() {
		return window.innerHeight * 0.8;  // Set canvas height to 80% of the window height
	  },
	},
  
	mounted() {
	  this.initGame();
	},
  };
  </script>
  
  <style scoped>
  #game-content {
	width: 100%;
	position: relative;
  }
  
  .game-over {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	background-color: rgba(0, 0, 0, 0.7);
	padding: 20px;
	border-radius: 10px;
	color: white;
	text-align: center;
  }
  
  .score {
	position: absolute;
	top: 20px;
	left: 20px;
	font-size: 20px;
	color: white;
  }
  
  @media (max-width: 600px) {
	.score h2 {
	  font-size: 16px;
	}
  
	.game-over h1 {
	  font-size: 24px;
	}
  
	.game-over p {
	  font-size: 18px;
	}
  }
  </style>  