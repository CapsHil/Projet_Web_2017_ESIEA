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
        <div class="options-element">
          <span>{{numberOfQuestionsLabel}}</span>
          <el-slider class="slider" :min="1" :max="20" v-model="numberOfQuestions"></el-slider>
        </div>
        <div class="options-element">
          <div>
            <div id='example-3'>
              <el-checkbox v-for="genre in genres" :label="genre.ID" v-model="checkedGenres" :key="genre.ID">{{ genre.name }}</el-checkbox>
              <br>
              <span>Checked names: {{ checkedGenres }}</span>
            </div>
          </div>
        </div>
      </div>
      <div v-on:click="startGame()" class="menu-button menu-start-button" :disabled="playing == 1">{{ start }}</div>
    </div>
    <quizz-game v-bind:class="{ 'show': playing, 'hide': !playing }" v-bind:displayPropositions="displayHints" v-bind:genres="checkedGenres" v-bind:arrowButtonTop="arrowButtonTop" v-bind:numberOfQuestions="numberOfQuestions" v-on:return="endGame()"></quizz-game>
  </div>
</template>

<script>
  import QuizzGame from './QuizzGame.vue'
  import axios from 'axios'

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
        arrowButtonTop: true,
        numberOfQuestionsLabel: 'Number of questions: ',
        numberOfQuestions: 5,
        checkedGenres: [],
        genres: []
      }
    },
    methods: {
      toggleHints () {
        console.log(this.checkedGenres)
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
    },
    mounted: function () {
      axios.get('http://localhost:8082/api/genre.php', {headers:
      {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
        'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
      }})
        .then((response) => {
          this.genres = response.data.genres
        })
      .catch(function (error) {
        console.log(error)
      })
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
    min-height: 60px;
    line-height: 60px;
    font-size: 20px;
    background-color: #efefef;
    border-radius: 5px;
    width: 50%;
    margin: auto;
    margin-bottom: 20px;
    padding: 10px;
    text-align: left;
    }

  .menu-button{
    float: right;
    padding: 5px;
    width: 100px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    border-radius: 5px;
    box-shadow: 1px 4px 5px #232323;
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

  .menu-start-button{
    float: none;
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

  .slider{
    line-height: normal;
  }

</style>
