<template>
  <div class="menu-component">
    <div v-bind:class="{ 'show': !playing, 'hide': playing }">
      <h1>{{menu}}</h1>
      <div class="options-list">
        <div class="options-element">
          <span>{{hintLabel}}</span>
          <div class="menu-button options-button" v-bind:class="{ 'disabled': !displayHints }" v-on:click="toggleHints()">{{hintStatus}}</div>
        </div>
        <div class="options-element">
          <span>{{progressbarLabel}}</span>
          <div class="menu-button" v-bind:class="{ 'fa fa-arrow-circle-right fa-2x': !arrowButtonTop, 'fa fa-arrow-circle-up fa-2x': arrowButtonTop }" v-on:click="switchTimerPosition()"></div>
        </div>
      </div>
      <div v-on:click="startGame()" class="menu-button" :disabled="playing == 1">{{ start }}</div>
    </div>
    <quizz-game v-bind:class="{ 'show': playing, 'hide': !playing }" v-bind:displayPropositions="displayHints" v-bind:arrowButtonTop="arrowButtonTop" v-on:return="endGame()"></quizz-game>
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
        displayHints: true,
        progressbarLabel: 'Timer position: ',
        arrowButtonTop: true

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

      switchTimerPosition () {
        this.arrowButtonTop = !this.arrowButtonTop
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
    margin-bottom: 20px;
    padding: 5px;
    text-align: left;
    }

  .menu-button{
    padding: 5px;
    width: 100px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    border-radius: 5px;
    box-shadow: 1px 4px 5px #232323;
    margin: 20px;
    cursor: pointer;
    display: inline-block;
    transition: all 0.2s;
    background-color: #8e8e8e;
    color: #efefef;
  }

  .menu-button:hover{
    box-shadow: 2px 8px 5px #232323;
    transform: translateY(-4px);
    background-color: #90ff00;
    color: #555555;
  }

  .menu-button:active{
    transform: translateY(0px);
    box-shadow: 1px 4px 5px #232323;
  }

  .options-button{
    background-color: #409900;
    color: #efefef;
  }

  .options-button:hover{
    background-color: #90ff00;
    color: #555555;
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
