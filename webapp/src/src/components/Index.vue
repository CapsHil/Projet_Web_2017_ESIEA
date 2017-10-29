<template>
  <div class="index">
    <div v-bind:class="{ 'mac': isNavigatorMac, 'windows': isNavigatorWindows}">
      <div class="future-cop">
        <h3 class="future">Blind</h3>
        <h1 class="cop">TEST</h1>
      </div>
    </div>
    <menu-component></menu-component>
  </div>
</template>

<script>
  import MenuComponent from './MenuComponent.vue'
  import 'font-awesome/css/font-awesome.css'

  export default {
    name: 'index',
    data () {
      return {
        isNavigatorWindows: false,
        isNavigatorMac: false
      }
    },
    components: {
      MenuComponent
    },
    mounted: function () {
      if (navigator.platform.indexOf('Win') !== -1) {
        this.isNavigatorWindows = true
      } else if (navigator.platform.indexOf('Mac') !== -1) {
        this.isNavigatorMac = true
      }
    }
  }
</script>

<style>
  @import url(https://fonts.googleapis.com/css?family=Mr+Dafoe);
  @import url(https://fonts.googleapis.com/css?family=Titillium+Web:900);
  @import url(https://fonts.googleapis.com/css?family=Righteous);
  @import url(https://fonts.googleapis.com/css?family=Candal);

  @import url(https://fonts.googleapis.com/css?family=Permanent+Marker);

  @import url(https://fonts.googleapis.com/css?family=Monoton);


  h1{
    color: #efefef
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }

  .future-cop {
    position: relative;
    margin-top: 300px;
  }

  .future {
    position: absolute;
    left: 0;
    top: -310px;
    font-family: 'Mr Dafoe', cursive;
    font-size: 200px;
    margin-top: 160px;
    margin-bottom: 0;
    color: #EB219B;
    -webkit-text-fill-color: rgba(253, 90, 250, 1);
    text-shadow: -2px -2px 0 #FFBAF2;
    -webkit-filter: drop-shadow(3px 3px 1px #441F62);
    -webkit-transform: skew(-5deg,-5deg);
    font-weight: normal;
    z-index: 2;
    margin-left: 60px;
    padding-left: 50px;
    padding-right: 70px;
  }

  .cop {
    position: relative;
    font-family: 'Monoton', cursive;
    font-size: 200px;
    line-height: 1;
    margin: 0;
    margin-top: -95px;
    padding-left: 80px;
    /* font-weight: normal; */
    background-image: -webkit-linear-gradient(#022486 0%, #0AD0FD 30%, #BDFCFC 40%, #D8FFFF 44%, #00081C 44%, #00081C 50%, #074A67 52%, #1CD8FE 60%, #7FEDFE 62%, #96F5FC 70%, #0FD8FA 73%, #0BD2FD 88%, #AFFDFF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-text-stroke: 1px #fff;
  }

  .mac .cop {
    font-weight: 400;
  }

  .cop:before {
    position: absolute;
    content: '';
    left: 51px;
    top: 74px;
    width: 80px;
    height: 3px;
    background-image: -webkit-radial-gradient(#fff 0%, transparent 85%);
    z-index: 4;
    -webkit-animation-name: cop_before_effect;
    -webkit-animation-duration: 5s;
    -webkit-animation-delay: 2s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
  }

  .cop:after {
    position: absolute;
    content: '';
    left: 90px;
    top: 32px;
    width: 3px;
    height: 80px;
    background-image: -webkit-radial-gradient(#fff 0%, transparent 85%);
    z-index: 4;
    -webkit-animation-name: cop_after_effect;
    -webkit-animation-duration: 5s;
    -webkit-animation-delay: 2s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
  }

  @-webkit-keyframes chrome_effect {
    0% {background-position:-680px 0;}
    10% {background-position:420px 0;}
    100% {background-position:420px 0;}
  }

  @-webkit-keyframes cop_before_effect {
    0% {
      left: 51px;
      top: 74px;
      opacity: 0;}

    15% {
      left: 51px;
      top: 74px;
      opacity: 1;}

    30% {
      left: 51px;
      top: 74px;
      opacity: 0;}

    35% {
      left: 370px;
      top: 45px;
      opacity: 0;}

    50% {
      left: 370px;
      top: 45px;
      opacity: 1;}

    65% {
      left: 370px;
      top: 45px;
      opacity: 0;}

    70% {
      left: 564px;
      top: 74px;
      opacity: 0;}

    85% {
      left: 564px;
      top: 74px;
      opacity: 1;}

    100% {
      left: 564px;
      top: 74px;
      opacity: 0;}
  }

  @-webkit-keyframes cop_after_effect {
    0% {
      left: 90px;
      top: 32px;
      opacity: 0;}

    15% {
      left: 90px;
      top: 32px;
      opacity: 1;}

    30% {
      left: 90px;
      top: 32px;
      opacity: 0;}

    35% {
      left: 413px;
      top: 11px;
      opacity: 0;}

    50% {
      left: 413px;
      top: 11px;
      opacity: 1;}

    65% {
      left: 413px;
      top: 11px;
      opacity: 0;}

    70% {
      left: 603px;
      top: 32px;
      opacity: 0;}

    85% {
      left: 603px;
      top: 32px;
      opacity: 1;}

    100% {
      left: 603px;
      top: 32px;
      opacity: 0;}
  }
</style>
