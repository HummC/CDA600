<template>
<div class="page-tasks col-12"> 
   <header class="banner">
    </header>
    <div v-for="task in taskList">
       <div class="row">
       <div class="heading">
        <h1> {{ task.name }}</h1>
        <p>  {{ task.description }}</p>
        </div>
        <ul class="stats">
            <li><span>Due Date:</span> {{task.due_date}} </li>
            <li><span>Motivates:</span>  {{task.motivates}}</li>
        </ul>
    </div>
        <section class="taskmotivators">
            <h3> Task Motivators ({{task.motivates}})</h3>
            <div class="avatarcontainer" v-for="motivator in motivators">
            <a href="javascript:"><img v-bind:src="motivator.image_loc">
            <span>{{motivator.name}}</span>
            </a>
    </div>
         
        </section>
    </div>
    </div>
</template>

<script>   
export default {
  name: 'single-task',
  data () {
    return {
      id: this.$route.params.id, // route parameter
      toggle:-1,
      groupinfo:[],
      groupmembers:[],
      joined: true,
      todaysDate: "",
      taskList:[],
      motivators:[]
    }
  },
    created: function(){
       var self = this;
        
         axios.get('php/showtasks.php?task_id='+this.id,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.taskList = response.data;
              })
              .catch(function (error) {
           
               }); 
        
        
         axios.get('php/showmotivators.php?task_id='+this.id,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.motivators = response.data;
              })
              .catch(function (error) {
           
               }); 
    },
    
methods: {
    
    
  join() {
     
  },
    
  leave() {

  }, 
}
}
</script>