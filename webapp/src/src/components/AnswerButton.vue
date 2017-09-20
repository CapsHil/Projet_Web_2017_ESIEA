<template>
    <button class="answer-button" v-on:click="displayToggle()">{{ answer }}</button>
</template>

<script>
  export default {
    name: 'answer-button',
    data () {
      return {
        answer: 'Answer',
        isCorrectAnswer: true
      }
    },
    methods: {
      displayToggle () {
        if (this.isCorrectAnswer) {
          alert('Yay! You got it!')
        }
      }
    }
  }
</script>

<style>
  .answer-button {
    display: inline;
    padding: 10px;
    width: 300px;
    height: 200px;
    margin: 20px;
  }
</style>
