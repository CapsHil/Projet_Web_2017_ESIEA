<template>
  <div class="quizz-game">
    <div>for dev purpose: {{ correctAnswerButton }}</div>
    <i v-on:click="returnToMenu()" class="return-button fa fa-arrow-left"></i>
    <div class="row game-header">
      <div class="play-button fa fa-play fa-5x" v-bind:class="{ 'playing': playing, 'not-playing': !playing }" v-on:click="startNewExtract()" :disabled="playing == 1"><!--{{ msg }}--></div>
      <div class="timer" v-bind:class="{ 'show-timer': playing }">Time remaining: {{ timer }}</div>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:style="{ 'background-color': colors[0] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(0)" :disabled="playing == 0">{{ answers[0] }}</button>
      <button class="answer-button" v-bind:style="{ 'background-color': colors[1] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(1)" :disabled="playing == 0">{{ answers[1] }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:style="{ 'background-color': colors[2] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(2)" :disabled="playing == 0">{{ answers[2] }}</button>
      <button class="answer-button" v-bind:style="{ 'background-color': colors[3] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(3)" :disabled="playing == 0">{{ answers[3] }}</button>
    </div>
    <h1 v-bind:class="{ 'hide': !displayAnswer }">{{displayedAnswer}}</h1>
    <div v-on:click="skipTrack()" v-bind:class="{ 'hide': !skipEnabled }" class="button">{{ skip }}</div>
  </div>

</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'
  // import blockly from 'node-blockly'

  export default {
    name: 'quizz-game',
    props: {
      displayPropositions: {
        type: Boolean,
        default: true
      }
    },
    data () {
      return {
        workspace: null,
        msg: 'Play',
        timer: '00:10',
        timerBuffer: null,
        correctAnswer: 'NaN',
        correctAnswerButton: 'NaN',
        axios: axios,
        sound: null,
        answers: [],
        isCorrectAnswer: 'NàN',
        playing: false,
        suggestions: [],
        remainingQuestions: 4,
        skip: 'Skip this track',
        skipEnabled: false,
        buttonColor: '',
        colors: ['#5eaeb8', '#5eaeb8', '#5eaeb8', '#5eaeb8'],
        displayedAnswer: '',
        displayAnswer: false
      }
    },
    methods: {
      returnToMenu () {
        if (this.sound !== null) {
          this.sound.stop()
        }
        this.msg = 'Play'
        this.playing = 0
        this.answers = []
        this.remainingQuestions = 4
        this.$emit('return')
        this.skipEnabled = false
      },
      skipTrack () {
        this.sound.stop()
        if (this.remainingQuestions !== 0) {
          this.remainingQuestions -= 1
          this.startNewExtract()
        } else {
          this.remainingQuestions = 4
          this.playing = 0
          this.skipEnabled = false
        }
      },
      startNewExtract () {
        this.buttonColor = ''
        if (this.displayPropositions === false) {
          this.skipEnabled = true
        }
        this.playing = 1
        this.axios.get('http://localhost:8082/api/test.php', {headers:
        {
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
          'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
        }})
          .then((response) => {
            console.log(response.data)
            // eslint-disable-next-line new-cap
            this.sound = new buzz.sound(require('../assets/' + response.data.filename))
            this.correctAnswer = response.data.songID
            this.answers = []
            this.suggestions = []
            this.suggestions.push(response.data.suggestions[0].songID)
            this.suggestions.push(response.data.suggestions[1].songID)
            this.suggestions.push(response.data.suggestions[2].songID)
            this.suggestions.push(response.data.suggestions[3].songID)
            this.correctAnswerButton = this.suggestions.indexOf(this.correctAnswer)
            this.answers.push(response.data.suggestions[0].trackName)
            this.answers.push(response.data.suggestions[1].trackName)
            this.answers.push(response.data.suggestions[2].trackName)
            this.answers.push(response.data.suggestions[3].trackName)
            this.displayedAnswer = this.answers[this.suggestions.indexOf(this.correctAnswer)]
            this.sound.play()
            this.msg = 'Playing'
            this.sound.bind('timeupdate', () => {
              this.timerBuffer = buzz.toTimer(this.sound.getTime())
              if (10 - (this.timerBuffer[3] + this.timerBuffer[4]) !== 10) {
                this.timer = '00:0' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
                // eslint-disable-next-line
              }
              else {
                this.timer = '00:' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
              }
              // console.log(this.timer)
              if (this.timer === '00:00') {
                this.displayAnswer = true
              }

              if (this.timer === '00:0-3') {
                this.displayAnswer = false
                this.sound.stop()
                this.playing = 0
                this.msg = 'Play'
                this.correctAnswer = 'NaN'
                this.answers = []
                if (this.remainingQuestions !== 0) {
                  this.remainingQuestions -= 1
                  this.startNewExtract()
                } else {
                  this.remainingQuestions = 4
                }
              }
            })
          })
          .catch(function (error) {
            console.log(error)
          })
      },
      displayToggle (buttonId) {
        var givenAnswer = this.suggestions[buttonId]
        this.sound.stop()
        this.msg = 'Play'
        this.playing = 0
        if (this.correctAnswer === givenAnswer) {
          this.colors[buttonId] = '#409900'
        } else {
          this.colors[buttonId] = '#de603b'
          this.colors[this.suggestions.indexOf(this.correctAnswer)] = '#409900'
        }
        if (this.remainingQuestions !== 0) {
          this.remainingQuestions -= 1
          this.startNewExtract()
        } else {
          this.remainingQuestions = 4
        }
      }
    }
  }
</script>

<style>
  body{
    background-color: #1b7397;
  }

  .game-header{
    /*padding: 0 40% 0 40%;*/
    /*display: flex;*/
    /*flex-direction: row;*/
  }


  .play-button{
    position:relative;
    height:500px;
    width:500px;
    cursor:pointer;
    line-height:500px;
    background-color:#f1f1f1;
    text-align:center;
    font-size:150px;
    display:inline-block;
    text-shadow:0px -1px 1px rgba(255,255,255,0.5);
    color:#cfcfcf;
    /* Transitions */

    transition:.1s linear;
    /* Shadows */
    box-shadow:inset 0 0 5px 0 rgba(255,255,255,0.5), 0 4px 5px #232323;
    /* Borders */
    border-width:1px;
    border-style:solid;
    border-left-color:#777;
    border-right-color:#777;
    border-top-color:#999;
    border-bottom:4px solid #555;
    /* {{ No selectable }} */
    user-select:none;


    border-radius:250px;

    /* Gradient */

    background-image:linear-gradient(top,transparent,rgba(0,0,0,0.2));
    background-color:#82C43A;
    border-color:#578720;
    }
    .play-button:hover{
      color:#efefef;
      box-shadow:  2px 8px 5px #232323;
      /*{Gradient}*/

      background-image:linear-gradient(top,transparent,rgba(0,0,0,0.5));
      transform: translateY(-4px);
    }
    .play-button:active{
      margin-top:4px;
      color:#cecece;
      border:1px solid #232323;
      /*{Shadow}*/
      box-shadow:inset 0 2px 50px 1px #333, 0 4px 5px #232323;
    }


  /**/
  .timer{
    color: #efefef;
    padding:40px;
    line-height: 20px;
    font-size: 50px;
    position: absolute;
    top: 0%;
    right: 0%;
    display: none;
  }

  .show-timer{
    display: inline;
  }

  .playing{
    display: none;
    transform: translateY(-4px);
    box-shadow: 2px 8px 5px #232323;
    background-color: #232323;
    transition: color 0.2s;
  }

  .answer-button {
    display: inline;
    padding: 0px;
    width: 300px;
    background-color: #5eaeb8;
    height: 200px;
    margin: 20px;
    border: hidden;
    border-radius: 5px;
    transition: transform 0.2s;
    transition: box-shadow 0.2s;
    overflow: hidden;
    font-size: 25px;
    display: none;
  }

  .active-button{
    display: inline;
  }

  .active-button:hover{
    transform: translateY(-2px);
    box-shadow: 2px 8px 5px #232323;
    visibility: visible;
  }

  .hide{
    display: none
  }

  .return-button{
    width: 60px;
    height: 60px;
    border-radius: 30px;
    line-height: 60px;
    background-color: #de603b;
    color: #efefef;
    position: absolute;
    left: 20px;
    transition: all 0.2s;
    cursor: pointer;
    box-shadow: 1px 4px 5px #232323;
  }

  .return-button:hover {
    background-color: #dec05b;
    color: #232323;
    transform: translateY(-4px);
    box-shadow: 2px 8px 5px #232323;
  }

  .return-button:active{
    transform: translateY(0px);
    box-shadow: 1px 4px 5px #232323;
  }

  .red{
    background-color: red;
  }

  .green{
    background-color: green;
  }

</style>
