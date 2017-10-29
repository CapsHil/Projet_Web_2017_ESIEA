<template>
  <div class="menu-component">
    <div v-bind:class="{ 'show': !playing, 'hide': playing }">
      <div class="options-list">
        <div class="options-element">
          <span>{{hintLabel}}</span>
          <div class="menu-button options-button" v-bind:class="{ 'button-disabled': !displayHints }" v-on:click="toggleHints()">{{hintStatus}}</div>
        </div>
        <div class="options-element">
          <el-popover ref="popover4" placement="right" width="400" trigger="click">
            <el-table :data="rankingData">
              <el-table-column width="150" property="rank" label="Rank"></el-table-column>
              <el-table-column width="100" property="user" label="Username"></el-table-column>
              <el-table-column width="300" property="score" label="Score"></el-table-column>
            </el-table>
          </el-popover>

          <el-button class="menu-button score-button" v-popover:popover4>See top scores</el-button>
        </div>
        <div class="options-element">
          <span>{{progressbarLabel}}</span>
          <div class="menu-button" v-bind:class="{ 'fa fa-arrow-circle-right fa-2x': !arrowButtonTop, 'fa fa-arrow-circle-up fa-2x': arrowButtonTop }" v-on:click="switchTimerPosition()"></div>
        </div>
        <div class="options-element">
          <span>{{rankedLabel}}</span>
          <div class="menu-button options-button" v-bind:class="{ 'button-disabled': !isRankedEnabled }" v-on:click="toggleRanked()">{{isRankedEnabledText}}</div>
        </div>
        <div class="options-element">
          <span>{{numberOfQuestionsLabel}}</span>
          <el-slider class="slider" :min="1" :max="20" v-model="numberOfQuestions" :disabled="isRankedEnabled"></el-slider>
        </div>
        <div class="options-element">
          <span>Genres (default Série/Film): </span>
          <div class="flex-container">
            <el-checkbox :border="true" class=" checkbox" v-for="genre in genres" :label="genre.ID" v-model="checkedGenres" :key="genre.ID">{{ genre.name }}</el-checkbox>
          </div>
        </div>
      </div>
      <div v-on:click="startGame()" class="menu-button menu-start-button" :disabled="playing == 1">{{ start }}</div>
    </div>
    <quizz-game v-bind:class="{ 'show': playing, 'hide': !playing }" v-bind:ranked="isRankedEnabled" v-bind:displayPropositions="displayHints" v-bind:genres="checkedGenres" v-bind:arrowButtonTop="arrowButtonTop" v-bind:numberOfQuestions="numberOfQuestions" v-on:return="endGame()"></quizz-game>
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
        numberOfQuestions: 10,
        checkedGenres: [],
        genres: [],
        rankedLabel: 'Ranked mode: ',
        isRankedEnabled: false,
        isRankedEnabledText: 'Disabled',
        rankingData: []
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

      toggleRanked () {
        if (this.isRankedEnabledText === 'Enabled') {
          this.isRankedEnabledText = 'Disabled'
          this.isRankedEnabled = false
        } else {
          this.isRankedEnabledText = 'Enabled'
          this.isRankedEnabled = true
          this.numberOfQuestions = 10
        }
      },

      switchTimerPosition () {
        this.arrowButtonTop = !this.arrowButtonTop
      },

      startGame () {
        this.playing = true
      },

      endGame () {
        axios.get('http://localhost:8082/api/topScores.php', {headers:
        {
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
          'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
        }})
          .then((response) => {
            this.rankingData = response.data.scores.slice(0, 10)
          })
        .catch(function (error) {
          console.log(error)
        })
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
      axios.get('http://localhost:8082/api/topScores.php', {headers:
      {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
        'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
      }})
        .then((response) => {
          this.rankingData = response.data.scores.slice(0, 10)
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
    overflow: hidden;
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
    /*background-color: #8e8e8e;
    color: #efefef;*/
    color: #409EFF;
    background-color: #ecf5ff;
  }

  .menu-button:hover{
    box-shadow: 2px 8px 5px #232323;
    transform: translateY(-4px);
    /*background-color: #76d100;
    color: #555555;*/
    background-color: #409EFF;
    color: #ecf5ff;
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
    background-color: #76d100;
    color: #555555;
  }

  .button-disabled{
    background-color: #992020;
    color: #efefef;
  }

  .button-disabled:hover{
    background-color: #F05020;
    color: #efefef
  }

  .score-button{
    height: inherit;
    border: none;
    width: 100%;
    float: none;
    margin: auto;
    font-size: 20px;
    color: #409EFF;
    background-color: #ecf5ff;
  }

  .score-button:hover{
    background-color: #409EFF;
    color: #ecf5ff;
  }

  .slider{
    line-height: normal;
    padding: 5px;
  }

  .checkbox{
    background-color: #efefef;
    line-height: 40px;
    width: 100px;
    margin-left: 0px;
    margin-bottom: 5px;
  }

  .flex-container{
    display: flex;
    flex-direction: column;
    float: right;
  }

  .el-checkbox.is-bordered + .el-checkbox.is-bordered{
    margin-left: 0;
  }

</style>
