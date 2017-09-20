<template>
  <div class="play-button">
    <div class="timer">{{timer}}</div>
    <button v-on:click="startNewExtract()">{{msg}}</button>
  </div>
</template>

<script>
  import buzz from 'buzz'

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
        sound.play()
        sound.bind('timeupdate', function () {
          timerValue = buzz.toTimer(this.getTime())
          console.log(timerValue)
        })
      }
    }
  }
</script>
