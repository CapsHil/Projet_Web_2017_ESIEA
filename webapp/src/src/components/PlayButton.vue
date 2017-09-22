<template>
  <div class="play-button">
    <div class="timer">{{ timer }}</div>
    <div>{{ correctAnswer }}</div>
    <button v-on:click="startNewExtract()">{{ msg }}</button>
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
        // eslint-disable-next-line new-cap
        sound: new buzz.sound(require('../assets/sound.mp3'))
      }
    },
    methods: {
      startNewExtract () {
        this.axios.get('http://localhost:8081/extract')
          .then((response) => {
            console.log(response.data)
            this.correctAnswer = response.data.correctAnswer
          })
          .catch(function (error) {
            console.log(error)
          })
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
            this.sound.stop()
          }
        })
      }
    }
  }
</script>
