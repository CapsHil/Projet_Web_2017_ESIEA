<template>
  <div class="play-button">
    <div class="timer">{{ timer }}</div>
    <div>{{ correctAnswer }}</div>
    <button v-on:click="startNewExtract()">{{ msg }}</button>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(1)">{{ answer1 }}</button>
      <button class="answer-button" v-on:click="displayToggle(2)">{{ answer2 }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(3)">{{ answer3 }}</button>
      <button class="answer-button" v-on:click="displayToggle(4)">{{ answer4 }}</button>
    </div>
  </div>

</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'

  export default {
    name: 'play-button',
    data () {
      return {
        msg: 'Play',
        timer: '00:10',
        timerBuffer: null,
        correctAnswer: 'NàN',
        axios: axios,
        sound: null,
        answer1: null,
        answer2: null,
        answer3: null,
        answer4: null,
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
            this.answer1 = response.data.answerLabels.one
            this.answer2 = response.data.answerLabels.two
            this.answer3 = response.data.answerLabels.three
            this.answer4 = response.data.answerLabels.four
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
                this.msg = 'Play'
                this.answer1 = null
                this.answer2 = null
                this.answer3 = null
                this.answer4 = null
                this.sound.stop()
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

