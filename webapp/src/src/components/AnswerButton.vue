<template>
  <div class="answer-button">
    <button v-on:click="displayToggle()">toggle</button>
    <h1 v-if="toggle">{{ msg }}</h1>
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
