<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
    <play-button></play-button>
  </div>
</template>

<script>
  import PlayButton from './PlayButton.vue'

  export default {
    name: 'index',
    data () {
      return {
        welcome: 'Welcome to Blind test'
      }
    },
    components: {
      PlayButton
    }
  }
</script>

