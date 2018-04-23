<template>
  <aside class="col-2 text-center">
        <ul>
            <a href="#"><img src="images/logo.png"></a>
            <a href="#"><li>Profile</li></a>
            <a href="#"><li>Goals</li></a>
            <a href="#"><li>Tasks</li></a>
            <a href="#"><li>Callendar</li></a>
            <a href="#"><li>Community Groups</li></a>
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