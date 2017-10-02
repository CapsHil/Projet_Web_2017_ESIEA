<template>
  <div class="quizz-game">
    <div class="timer">{{ timer }}</div>
    <div>{{ correctAnswer }}</div>
    <button v-on:click="startNewExtract()">{{ msg }}</button>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(0)">{{ answers[0] }}</button>
      <button class="answer-button" v-on:click="displayToggle(1)">{{ answers[1] }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(2)">{{ answers[2] }}</button>
      <button class="answer-button" v-on:click="displayToggle(3)">{{ answers[3] }}</button>
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
        isCorrectAnswer: 3
      }
    },
    methods: {
      startNewExtract () {
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
  .answer-button {
    display: inline;
    padding: 10px;
    width: 300px;
    height: 200px;
    margin: 20px;
  }
</style>

