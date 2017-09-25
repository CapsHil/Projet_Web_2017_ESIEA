<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
    <quizz-game></quizz-game>
  </div>
</template>

<script>
  import QuizzGame from './QuizzGame.vue'

  export default {
    name: 'index',
    data () {
      return {
        welcome: 'Welcome to Blind test'
      }
    },
    components: {
      QuizzGame
    }
  }
</script>

