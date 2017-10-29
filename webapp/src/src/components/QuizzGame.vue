<template>
  <div class="quizz-game">
     <div class="score" v-bind:class="{ 'hide': !ranked }">
       <h1>Score: {{ playerScore }} </h1>
     </div>
    <el-row gutter="10" class="game-header">
      <el-col :xs="24" :sm="24" :md="1" :lg="1":xl="1">
        <i v-on:click="returnToMenu()" class="return-button fa fa-arrow-left"></i>
      </el-col>
      <!-- <el-col :xs="24" :sm="24" :md="23" :lg="23":xl="23">
        <div class="timer" v-bind:class="{ 'show-timer': playing }">Time remaining: {{ timer }}</div>
      </el-col> -->
    </el-row>
    <div class="play-button fa fa-play fa-5x" v-bind:class="{ 'playing': playing, 'not-playing': !playing }" v-on:click="startNewExtract()"><!--{{ msg }}--></div>
      <el-row gutter="50">
        <el-col :xs="24" :sm="24" :md="{span: 11, offset: 1}" :lg="{span: 11, offset: 1}" :xl="{span: 11, offset: 1}">
          <button class="answer-button" v-bind:style="{ 'background-color': colors[0] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(0)" :disabled="answersEnabled == false">{{ answers[0] }}</button>
        </el-col>
        <el-col :xs="24" :sm="24" :md="{span: 11, offset: 0}" :lg="{span: 11, offset: 0}" :xl="{span: 11, offset: 0}">
          <button class="answer-button" v-bind:style="{ 'background-color': colors[1] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(1)" :disabled="answersEnabled == false">{{ answers[1] }}</button>
        </el-col>
      </el-row>
    <el-row gutter="50">
      <el-col :xs="24" :sm="24" :md="{span: 11, offset: 1}" :lg="{span: 11, offset: 1}" :xl="{span: 11, offset: 1}">
          <button class="answer-button" v-bind:style="{ 'background-color': colors[2] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(2)" :disabled="answersEnabled == false">{{ answers[2] }}</button>
        </el-col>
      <el-col :xs="24" :sm="24" :md="{span: 11, offset: 0}" :lg="{span: 11, offset: 0}" :xl="{span: 11, offset: 0}">
          <button class="answer-button" v-bind:style="{ 'background-color': colors[3] }" v-bind:class="{ 'active-button': playing, 'hide': !displayPropositions }" v-on:click="displayToggle(3)" :disabled="answersEnabled == false">{{ answers[3] }}</button>
        </el-col>
      </el-row>
    <h1 v-bind:class="{ 'hide': !displayAnswer }">{{displayedAnswer}}</h1>
    <div v-on:click="skipTrack()" v-bind:class="{ 'hide': !skipEnabled }" class="menu-button menu-start-button">{{ skip }}</div>

    <div class="score-modal-shade" v-bind:class="{ 'hide-modal': !displaySubmitScore }">
      <div class="score-modal">
        <div class="score-modal-dismiss fa fa-close" v-on:click="dismissModal()"></div>
        <h1>Your Score: </h1><div>{{playerScore}}</div>
        <h1>Enter your username to submit score: </h1><input v-model="playerName" placeholder="loser"><br>
        <div class="menu-button menu-start-button" v-on:click="submitScore()">Submit</div>
      </div>
    </div>
    <vue-progress-bar></vue-progress-bar>
  </div>

</template>

<script>
  import buzz from 'buzz'
  import axios from 'axios'
  import VueProgressBar from 'vue-progressbar'
  import Vue from 'vue'

  const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '20px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
  Vue.use(VueProgressBar, options)

  export default {
    name: 'quizz-game',
    props: {
      displayPropositions: {
        type: Boolean,
        default: true
      },
      arrowButtonTop: {
        type: Boolean,
        default: false
      },
      numberOfQuestions: {
        default: 10
      },
      genres: {
        default: 2
      },
      ranked: {
        type: Boolean,
        default: false
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
        remainingQuestions: 'NàN',
        skip: 'Skip this track',
        skipEnabled: false,
        buttonColor: '',
        colors: ['#5eaeb8', '#5eaeb8', '#5eaeb8', '#5eaeb8'],
        displayedAnswer: '',
        displayAnswer: false,
        timeStamp: null,
        answersEnabled: false,
        flag: false,
        wasFirstQuestion: true,
        playerScore: 0,
        playerName: '',
        displaySubmitScore: false
      }
    },
    methods: {
      returnToMenu () {
        if (this.sound !== null) {
          this.sound.stop()
        }
        this.colors = ['#5eaeb8', '#5eaeb8', '#5eaeb8', '#5eaeb8']
        this.msg = 'Play'
        this.playing = 0
        this.answers = []
        this.$emit('return')
        this.skipEnabled = false
        this.displayAnswer = false
        this.wasFirstQuestion = true
      },
      skipTrack () {
        this.sound.stop()
        if (this.remainingQuestions !== 0) {
          this.remainingQuestions -= 1
          this.startNewExtract()
        } else {
          this.remainingQuestions = this.numberOfQuestions - 1
          this.playing = 0
          this.skipEnabled = false
        }
      },
      startNewExtract () {
        this.setTimerPosition()
        if (this.wasFirstQuestion) {
          this.wasFirstQuestion = false
          this.remainingQuestions = this.numberOfQuestions - 1
        }
        this.timeStamp = null
        this.$Progress.setColor('#bffaf3')
        this.buttonColor = ''
        if (this.displayPropositions === false) {
          this.skipEnabled = true
        }
        this.playing = 1
        this.axios.post('http://localhost:8082/api/test.php', {headers:
        {
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
          'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
        },
          genre: this.genres
        })
          .then((response) => {
            this.answersEnabled = true
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
            var tmp
            tmp = response.data.suggestions[0].trackName
            if (response.data.suggestions[0].trackName !== response.data.suggestions[0].artistName) {
              tmp += '\n' + response.data.suggestions[0].artistName
            }
            this.answers.push(tmp)
            tmp = response.data.suggestions[1].trackName
            if (response.data.suggestions[1].trackName !== response.data.suggestions[1].artistName) {
              tmp += '\n' + response.data.suggestions[1].artistName
            }
            this.answers.push(tmp)
            tmp = response.data.suggestions[2].trackName
            if (response.data.suggestions[2].trackName !== response.data.suggestions[2].artistName) {
              tmp += '\n' + response.data.suggestions[2].artistName
            }
            this.answers.push(tmp)
            tmp = response.data.suggestions[3].trackName
            if (response.data.suggestions[3].trackName !== response.data.suggestions[3].artistName) {
              tmp += '\n' + response.data.suggestions[3].artistName
            }
            this.answers.push(tmp)
            this.displayedAnswer = this.answers[this.suggestions.indexOf(this.correctAnswer)]
            this.sound.play()
            this.msg = 'Playing'
            this.sound.bind('timeupdate', () => {
              this.timerBuffer = buzz.toTimer(this.sound.getTime())
              if (10 - (this.timerBuffer[3] + this.timerBuffer[4]) !== 10) {
                this.timer = '00:0' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
                if (!this.flag) {
                  if (10 - (this.timerBuffer[3] + this.timerBuffer[4]) >= 0) {
                    this.$Progress.set((10 - (this.timerBuffer[3] + this.timerBuffer[4])) * 10)
                  } else {
                    this.$Progress.setColor('#375372')
                    this.$Progress.set(Math.abs(100 - (this.timerBuffer[3] + this.timerBuffer[4] * 33)))
                  }
                } else {
                  this.$Progress.setColor('#375372')
                  this.$Progress.set(Math.abs(this.timer[4] - this.timeStamp[4] - 3) * 33)
                }
                // eslint-disable-next-line
              }
              else {
                this.timer = '00:' + (10 - (this.timerBuffer[3] + this.timerBuffer[4]))
                this.$Progress.set(100)
              }
              if (this.timer === '00:00') {
                this.answersEnabled = false
                this.displayAnswer = true
              }

              if (this.timer === '00:0-3' || this.timer === this.timeStamp) {
                this.flag = false
                this.resetQuestion()
              }
            })
          })
          .catch(function (error) {
            console.log(error)
          })
      },
      displayToggle (buttonId) {
        this.displayAnswer = true
        this.answersEnabled = false
        var givenAnswer = this.suggestions[buttonId]
        if (this.correctAnswer === givenAnswer) {
          this.colors[buttonId] = '#409900'
          if (this.ranked) {
            this.playerScore += (Math.trunc((10 - this.sound.getTime()) * 100))
          }
        } else {
          this.colors[buttonId] = '#de603b'
          this.colors[this.suggestions.indexOf(this.correctAnswer)] = '#409900'
          if (this.ranked) {
            this.playerScore -= 500
          }
        }
        this.timeStamp = buzz.toTimer(this.sound.getTime())
        this.timeStamp = '00:0' + ((10 - (this.timeStamp[3] + this.timeStamp[4])) - 3)
        this.flag = true
        this.$Progress.set(0)
      },
      resetQuestion () {
        this.displayAnswer = false
        this.sound.stop()
        this.playing = 0
        this.msg = 'Play'
        this.correctAnswer = 'NaN'
        this.answers = []
        this.buttonClicked = false
        this.colors = ['#5eaeb8', '#5eaeb8', '#5eaeb8', '#5eaeb8']
        if (this.remainingQuestions !== 0) {
          this.remainingQuestions -= 1
          this.startNewExtract()
        } else {
          this.wasFirstQuestion = true
          if (this.ranked) {
            this.displaySubmitScore = true
          }
        }
      },
      setTimerPosition () {
        if (this.arrowButtonTop) {
          this.$Progress.setLocation('top')
        } else {
          this.$Progress.setLocation('right')
        }
      },
      dismissModal () {
        this.displaySubmitScore = false
      },
      submitScore () {
        axios.post('http://localhost:8082/api/topScores.php', {headers:
        {
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Methods': 'POST,GET,OPTIONS,PUT,DELETE',
          'Access-Control-Allow-Headers': 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'
        },
          username: this.playerName,
          strike: this.playerScore
        })
          .then((response) => {
            this.dismissModal()
          })
      .catch(function (error) {
        console.log(error)
      })
      }
    }
  }
</script>

<style>
  body{
    background-color: #1b7397;
  }

  .game-header{
    min-height: 100px;
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
    line-height: 50px;
    font-size: 50px;
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
    width: 100%;
    display: inline;
    padding: 0px;
    background-color: #5eaeb8;
    min-height: 200px;
    margin: 20px 0 20px 0;
    border: hidden;
    border-radius: 5px;
    box-shadow: 1px 4px 5px #232323;

    transition: transform 0.2s;
    transition: box-shadow 0.2s;
    overflow: hidden;
    font-size: 25px;
    display: none;
    white-space: pre-line;
  }

  .answer-button:disabled{
    color: #232323;
    transform: translateY(0px);
  }

  .answer-button:disabled:hover{
    transform: translateY(0px);
    box-shadow: 1px 4px 5px #232323;


  }

  .active-button{
    display: inline;
  }

  .active-button:hover{
    transform: translateY(-4px);
    box-shadow: 2px 8px 5px #232323;
    visibility: visible;
  }

  .active-button:active{
    transform: translateY(0px);

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
    transition: all 0.2s;
    cursor: pointer;
    box-shadow: 1px 4px 5px #232323;
    margin-bottom: 40px;
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

  .score-modal-shade{
    position: absolute;
    top:0;
    left: 0;
    z-index: 10;
    width:100%;
    height:100%;
    background-color: rgba(0, 0, 0, 0.6);
  }

  .score-modal{
    color: #232323;
    border-radius: 10px;
    background-color: #efefef;
    width: 50%;
    height:50%;
    margin:auto;
    margin-top: 12%;
    padding: 5px;
    box-shadow: 1px 4px 50px 1px black;
  }

  .score-modal-dismiss{
    padding: 5px;
    margin: 5px;
    float: right;
    border-radius: 5px;
    background-color: #232323;
    color: #efefef;
    cursor: pointer;
  }

  .score-modal-dismiss:hover{
    transform: translateY(-4px);
    background-color: #555555

  }

  .score{
    float: right;
    padding: 10px;
    margin-right: 20px;
    width: 300px;
    border-radius: 5px;
    background-color: #ecf5ff;
  }

  .hide-modal{
    display: none;
  }

  input{
    margin-bottom: 20px;
  }

</style>
