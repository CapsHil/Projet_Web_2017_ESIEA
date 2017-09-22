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
        timer: null,
        correctAnswer: null,
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
          this.timer = buzz.toTimer(this.sound.getTime())
          console.log(this.timer)
          if (this.timer === '00:10') {
            this.msg = 'Play'
            this.sound.stop()
          }
        })
      }
    }
  }
</script>
