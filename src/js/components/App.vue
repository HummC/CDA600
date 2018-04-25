<template>
  <div id="app">
   <div class="row app-container">
    <sidebar></sidebar>
    <div class="page">
    <keep-alive>
    <router-view></router-view>
    </keep-alive>
    </div>
    </div>
    </div>
</template>

<script>   
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
// GET GOALS AND STORE IN IMPORTANT GOALS
// PASS GOALS AS PROPS
</script>