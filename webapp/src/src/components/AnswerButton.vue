<template>
  <div>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(1)">{{ answer1 }}</button>
      <button class="answer-button" v-on:click="displayToggle(2)">{{ answer2 }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-on:click="displayToggle(3)">{{ answer3 }}</button>
      <button class="answer-button" v-on:click="displayToggle(4)">{{ answer4 }}</button>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'answer-button',
    data () {
      return {
        answer1: 'Answer 1',
        answer2: 'Answer 2',
        answer3: 'Answer 3',
        answer4: 'Answer 4',
        isCorrectAnswer: 3
      }
    },
    methods: {
      displayToggle (buttonId) {
        if (this.isCorrectAnswer === buttonId) {
          alert('Yay! You got it! ')
        } else {
          alert('Noob!')
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
