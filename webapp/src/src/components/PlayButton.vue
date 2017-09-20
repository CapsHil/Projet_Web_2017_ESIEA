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

  export default {
    name: 'play-button',
    data () {
      return {
        msg: 'Play',
        timer: '00:00'
      }
    },
    methods: {
      startNewExtract () {
        sound.play()
        sound.bind('timeupdate', function () {
          this.timer = buzz.toTimer(this.getTime())
          console.log(this.timer)
        })
// eslint-disable-next-line spaced-comment
        //TODO: Load next 2 songs from backend. EDIT : DEGAGE CA AU DESSUS FDP !
      }
    }
  }
</script>
