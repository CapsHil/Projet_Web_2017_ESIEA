<template>
  <div class="menu-component">
    <div v-bind:class="{ 'show': !playing, 'hide': playing }">
      <h1>{{menu}}</h1>
      <div class="row">
        <span>{{hintLabel}}</span>
        <button v-on:click="toggleHints()">{{hintStatus}}</button>
      </div>
      <button v-on:click="startGame()" :disabled="playing == 1">{{ start }}</button>
    </div>
    <quizz-game v-bind:class="{ 'show': playing, 'hide': !playing }" v-bind:displayPropositions="displayHints" v-on:return="endGame()"></quizz-game>
  </div>
</template>

<script>
  import QuizzGame from './QuizzGame.vue'

  export default {
    name: 'menu-component',
    data () {
      return {
        menu: 'Menu',
        playing: false,
        start: 'Start Playing',
        hintLabel: 'Display 4 answer propositions: ',
        hintStatus: 'Enabled',
        displayHints: true
      }
    },
    methods: {
      toggleHints () {
        if (this.hintStatus === 'Enabled') {
          this.hintStatus = 'Disabled'
          this.displayHints = false
        } else {
          this.hintStatus = 'Enabled'
          this.displayHints = true
        }
      },

      startGame () {
        this.playing = true
      },

      endGame () {
        this.playing = false
      }
    },
    components: {
      QuizzGame
    }
  }
</script>

<style>
  h1{
    color: #232323
  }
  .show{
    display: inline;
  }
  .hide{
    display: none;
  }

</style>
