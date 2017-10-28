<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
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
        welcome: 'Welcome to Blind test'
      }
    },
    components: {
      MenuComponent
    }
  }
</script>

<style>
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
</style>
