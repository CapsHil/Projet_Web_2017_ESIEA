<template>
  <div class="play-button">
    <div class="timer">{{ timer }}</div>
    <button v-on:click="startNewExtract()">{{ msg }}</button>
  </div>
</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'

// eslint-disable-next-line new-cap
  let sound = new buzz.sound(require('../assets/sound.mp3'))
  let timerValue = '00:00'

  export default {
    name: 'play-button',
    data () {
      return {
        msg: 'Play',
        timer: timerValue
      }
    },
    methods: {
      startNewExtract () {
        axios.get('http://localhost:8081/extract')
          .then(function (response) {
            console.log(response)
          })
          .catch(function (error) {
            console.log(error)
          })
        sound.play()
        this.msg = 'Playing'
        sound.bind('timeupdate', function () {
          timerValue = buzz.toTimer(this.getTime())
          if (timerValue === '00:10') {
            this.msg = 'Play'
            sound.stop()
          }
        })
      }
    }
  }
</script>
