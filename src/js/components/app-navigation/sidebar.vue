<template>
  <aside class="col-md-2 sm-12 text-center">
        <ul>
            <a href="./"><img src="images/logo.png"></a>
            <router-link to='/'><li>Profile</li></router-link>
            <router-link to='/goals'><li>Goals</li></router-link>
            <router-link to='/tasks'><li>Tasks</li></router-link>
            <router-link to='/callendar'><li>Callendar</li></router-link>
            <router-link to='/groups'><li>Public Groups</li></router-link>
            
        </ul>
        <a href="php/logout.php" class="btn btn-danger logout">Logout</a>
  </aside>
</template>

<script>
export default {
  name: 'sidebar',
  data () {
    return {
      imagesrc: "",
      importantgoals:[]
        
    }
  }
}
</script>