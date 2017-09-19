<template>
  <div class="answer-button">
    <h1 v-if="toggle">{{ msg }}</h1>
    <button v-on:click="displayToggle()">toggle</button>
  </div>
</template>

<script>
  export default {
    name: 'answer-button',
    data () {
      return {
        msg: 'Welcome to Your Vue.js App',
        toggle: true
      }
    },
    methods: {
      displayToggle () {
        this.toggle = !this.toggle
      }
    }
  }
</script>
