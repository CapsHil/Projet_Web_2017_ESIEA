<template>
  <div class="play-button">
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
        msg: 'Play'
      }
    },
    methods: {
      startNewExtract () {
        sound.play()
// eslint-disable-next-line spaced-comment
        //TODO: Load next 2 songs from backend. EDIT : DEGAGE CA AU DESSUS FDP !
      }
    }
  }
</script>
