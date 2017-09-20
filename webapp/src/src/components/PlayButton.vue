<template>
  <div class="play-button">
    <button v-on:click="playSound()">{{msg}}</button>
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
        msg: 'Play'
      }
    },
    methods: {
      playSound () {
        sound.play()
      }
    }
  }
</script>
