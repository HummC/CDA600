<template>
<div class="page-tasks col-12"> 
    <header>
    <h1 class="text-center">
        TASKS 
    </h1>
    </header>
    <div v-for="task in taskList">
        <h1> {{ task.name }}</h1>
        <p>  {{ task.description }}</p>
        <section class="taskmotivators">
            <h2> Task Motivators ({{task.motivates}})</h2>
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
      taskList:[]
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
    },
    
methods: {
    
    
  join() {
     
  },
    
  leave() {

  }, 
}
}
</script>