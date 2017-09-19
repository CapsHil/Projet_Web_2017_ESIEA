<template>
  <div class="play-button">
    <button v-on:click="">{{msg}}</button>
  </div>
</template>

<script>
  export default {
    name: 'play-button',
    data () {
      return {
        msg: 'Play'
        /* sound: new buzz.sound("/sounds/sound", {formats: [ "ogg", "mp3", "aac" ]}) */
      }
    },
    methods: {

    }
  }
</script>
