<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
    <h1>{{ welcome }}</h1>
    <answer-button></answer-button>
  </div>
</template>

<script>
  import AnswerButton from './AnswerButton.vue'
  export default {
    name: 'index',
    data () {
      return {
        welcome: 'Welcome to Blind test'
      }
    },
    components: {
      AnswerButton
    }
  }
</script>

