<template>
<div class="page-callendar col-12"> 
    <header>
    <h1 class="text-center"> CALLENDAR </h1>
  <div class="form-row">
    <ul>
        <li><input type="text" class="form-control" placeholder="First name"></li>
        <li><input type="text" class="form-control" placeholder="Last name"></li>
        <li><a href="javascript:" class="btn btn-basic edit-profile"> Add New Goal</a></li>
    </ul>
  </div>
    </header>
</template>

<script>   
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      Tasks:[]
    }
  },
    created: function(){
        this.loadTasks().then(({data}) => {
        this.Tasks = data 
        });
    },
    
methods: {
  loadTasks () {
      return axios.get(`./php/showtasks.php`);   
    } 
}
}
</script>