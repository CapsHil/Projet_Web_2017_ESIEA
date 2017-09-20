<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
    <play-button></play-button>
    <div class="row">
      <answer-button></answer-button>
      <answer-button></answer-button>
    </div>
    <div class="row">
      <answer-button></answer-button>
      <answer-button></answer-button>
    </div>
  </div>
</template>

<script>
  import AnswerButton from './AnswerButton.vue'
  import PlayButton from './PlayButton.vue'
  export default {
    name: 'index',
    data () {
      return {
        welcome: 'Welcome to Blind test'
      }
    },
    components: {
      AnswerButton,
      PlayButton
    }
  }
</script>

<style>
  .row {
    padding: 10px;
  }
</style>

