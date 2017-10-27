<template>
  <div class="index">
    <h1>{{ welcome }}</h1>
    <menu-component></menu-component>
  </div>
</template>

<script>
  import MenuComponent from './MenuComponent.vue'

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
</style>
