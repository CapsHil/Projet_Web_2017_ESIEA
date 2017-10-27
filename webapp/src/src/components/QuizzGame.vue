<template>
  <div class="quizz-game">
    <div>for dev purpose: {{ correctAnswer }}</div>
    <button v-on:click="returnToMenu()">return to menu</button>
    <div class="row game-header">
      <button class="play-button" v-bind:class="{ 'playing': playing, 'not-playing': !playing }" v-on:click="startNewExtract()" :disabled="playing == 1">{{ msg }}</button>
      <div class="timer" v-bind:class="{ 'show-timer': playing }">Time remaining: {{ timer }}</div>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(0)" :disabled="playing == 0">{{ answers[0] }}</button>
      <button class="answer-button" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(1)" :disabled="playing == 0">{{ answers[1] }}</button>
    </div>
    <div class="row">
      <button class="answer-button" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(2)" :disabled="playing == 0">{{ answers[2] }}</button>
      <button class="answer-button" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(3)" :disabled="playing == 0">{{ answers[3] }}</button>
    </div>
  </div>

</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'

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
        msg: 'Play',
        timer: '00:10',
        timerBuffer: null,
        correctAnswer: 'NaN',
        axios: axios,
        sound: null,
        answers: [],
        isCorrectAnswer: 3,
        playing: false,
        remainingQuestions: 4
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
      },
      startNewExtract () {
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
            this.answers.push(response.data.suggestions[0].trackName)
            this.answers.push(response.data.suggestions[0].trackName)
            this.answers.push(response.data.suggestions[0].trackName)
            this.answers.push(response.data.suggestions[0].trackName)
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
              console.log(this.timer)

              if (this.timer === '00:00') {
                this.sound.stop()
                alert('NOOB! The correct answer was: ' + this.answers[this.correctAnswer])
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
        this.sound.stop()
        this.msg = 'Play'
        this.playing = 0
        this.answers = []
        if (this.correctAnswer === buttonId) {
          alert('Yay! You got it! ')
        } else {
          alert('Noob!')
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
    line-height:47px;
    background-color:#f1f1f1;
    text-align:center;
    font-size:30px;
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
    visibility: hidden;
  }

  .show-timer{
    visibility: visible;
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
    visibility: hidden;
  }

  .active-button{
    visibility: visible;
  }

  .active-button:hover{
    transform: translateY(-2px);
    box-shadow: 2px 8px 5px #232323;
    visibility: visible;
  }

  .hide{
    display: none
  }
</style>
