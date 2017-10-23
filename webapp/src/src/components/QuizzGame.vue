<template>
  <div class="quizz-game">
    <div>for dev purpose: {{ correctAnswer }}</div>

    <div class="row game-header">
      <button class="play-button" v-bind:class="{ 'playing': playing, 'not-playing': !playing }" v-on:click="startNewExtract()" :disabled="playing == 1">{{ msg }}</button>
      <div class="timer" v-bind:class="{ 'show-timer': playing }">Time remaining: {{ timer }}</div>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:class="{ 'active-button': playing }" v-on:click="displayToggle(0)" :disabled="playing == 0">{{ answers[0] }}</button>
      <button class="answer-button" v-bind:class="{ 'active-button': playing }" v-on:click="displayToggle(1)" :disabled="playing == 0">{{ answers[1] }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:class="{ 'active-button': playing }" v-on:click="displayToggle(2)" :disabled="playing == 0">{{ answers[2] }}</button>
      <button class="answer-button" v-bind:class="{ 'active-button': playing }" v-on:click="displayToggle(3)" :disabled="playing == 0">{{ answers[3] }}</button>
    </div>
  </div>

</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'

  export default {
    name: 'quizz-game',
    data () {
      return {
        msg: 'Play',
        timer: '00:10',
        timerBuffer: null,
        correctAnswer: 'NaN',
        axios: axios,
        sound: null,
        answers: [],
        isCorrectAnswer: 3,
        playing: false
      }
    },
    methods: {
      startNewExtract () {
        this.playing = 1
        this.axios.get('http://localhost:8081/extract')
          .then((response) => {
            console.log(response.data)
            // eslint-disable-next-line new-cap
            this.sound = new buzz.sound(require('../assets/' + response.data.extractFilename))
            this.correctAnswer = response.data.correctAnswer
            this.answers = []
            this.answers.push(response.data.answerLabels[0])
            this.answers.push(response.data.answerLabels[1])
            this.answers.push(response.data.answerLabels[2])
            this.answers.push(response.data.answerLabels[3])
            this.sound.play()
            this.msg = 'Playing'
            this.sound.bind('timeupdate', () => {
              this.timerBuffer = buzz.toTimer(this.sound.getTime())
              if (10 - (this.timerBuffer[3] + this.timerBuffer[4]) !== 10) {
                this.timer = '00:0' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
                // eslint-disable-next-line
              }
              else {
                this.timer = '00:' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
              }
              console.log(this.timer)

              if (this.timer === '00:00') {
                this.sound.stop()
                alert('NOOB! The correct answer was: ' + this.answers[this.correctAnswer])
                this.playing = 0
                this.msg = 'Play'
                this.correctAnswer = 'NaN'
                this.answers = []
              }
            })
          })
          .catch(function (error) {
            console.log(error)
          })
      },
      displayToggle (buttonId) {
        this.sound.stop()
        this.msg = 'Play'
        this.playing = 0
        this.answers = []
        if (this.correctAnswer === buttonId) {
          alert('Yay! You got it! ')
        } else {
          alert('Noob!')
        }
      }
    }
  }
</script>

<style>
  body{
    background-color: #1b7397;
  }

  .game-header{
    /*padding: 0 40% 0 40%;*/
    /*display: flex;*/
    /*flex-direction: row;*/
  }

  .play-button{

    margin: auto;
    width: 100px;
    height: 100px;
    border-radius: 50px;
    background-color: #329f5b;
    border-style: double;
    border-color: #0c8346;
    color: #efefef;
    transition: transform 0.2s;
    transition: box-shadow 0.2s;
  }

  .timer{
    color: #efefef;
    padding:40px;
    line-height: 20px;
    font-size: 50px;
    position: absolute;
    top: 0%;
    right: 0%;
    visibility: hidden;
  }

  .show-timer{
    visibility: visible;
  }

  .not-playing:hover{
    transform: translateY(-4px);
    box-shadow: 2px 8px 5px #232323;
  }

  .not-playing:active{
    transform: translateY(0px);
    box-shadow: 0 0 0 #000000;
  }

  .playing{
    transform: translateY(-4px);
    box-shadow: 2px 8px 5px #232323;
    background-color: #232323;
    transition: color 0.2s;
  }

  .answer-button {
    display: inline;
    padding: 0px;
    width: 300px;
    background-color: #5eaeb8;
    height: 200px;
    margin: 20px;
    border: hidden;
    border-radius: 5px;
    transition: transform 0.2s;
    transition: box-shadow 0.2s;
    overflow: hidden;
    font-size: 25px;
  }

  .active-button:hover{
    transform: translateY(-2px);
    box-shadow: 2px 8px 5px #232323;
  }
</style>

