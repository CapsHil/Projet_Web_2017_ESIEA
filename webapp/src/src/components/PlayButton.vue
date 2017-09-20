<template>
  <div class="play-button">
    <button v-on:click="">{{msg}}</button>
  </div>
</template>

<script>
  import buzz from 'buzz'
  export default {
    name: 'play-button',
    data () {
      return {
        msg: 'Play',
        sound: buzz.sound('/sound.mp3')
      }
    },
    methods: {

    }
  }
</script>
