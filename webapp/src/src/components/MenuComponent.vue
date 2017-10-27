<template>
  <div class="menu-component">
    <div v-bind:class="{ 'show': !playing, 'hide': playing }">
      <h1>{{menu}}</h1>
      <div class="options-list">
        <div class="options-element">
          <span>{{hintLabel}}</span>
          <div class="options-button" v-bind:class="{ 'disabled': !displayHints }" v-on:click="toggleHints()">{{hintStatus}}</div>
        </div>
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

  .options-list{
    margin: auto;
    margin-bottom: 20px;
    width: 50%;
  }
  .options-element{
    font-size: 20px;
    background-color: #efefef;
    border-radius: 5px;
    width: 50%;
    margin: auto;
    }

  .options-button{
    padding: 5px;
    width: 100px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    border-radius: 5px;
    box-shadow: 1px 4px 5px #232323;
    margin: 20px;
    cursor: pointer;
    background-color: #409900;
    display: inline-block;
    transition: all 0.2s;
    color: #efefef;
  }

  .options-button:hover{
    background-color: #90ff00;
    box-shadow: 2px 8px 5px #232323;
    color: #555555;
    transform: translateY(-4px);
  }

  .options-button:active{
    transform: translateY(0px);
    box-shadow: 1px 4px 5px #232323;
  }

  .disabled{
    background-color: #992020;
    color: #efefef;
  }

  .disabled:hover{
    background-color: #F05020;
    color: #efefef
  }

</style>
