<template>
<div class="page-callendar col-12"> 
    <header>
    <h1 class="text-center"> CALLENDAR </h1>
    </header>
    <!-- THIS CALENDAR IS FROM VUE-FULLCALENDAR. I HAVE USED IT AS TIME HAS RAN OUT AND VIEWING TASKS IN
    RELATION TO DATES IS A REQUIREMENT OF THE SPECIFICATION. THE CALENDAR COMPONENT IS CREATED BY WANDERXX. I HAVE ALTERED IT TO FIT MY USECASE BY TURNING THE DATA RECIEVED BY MY GET REQUEST INTO A STRING, REPLACING THE KEYS TO FIT THE CALENDAR SYNTAX AND THEN IMPORTING MY TASKS INTO THE FCEVENTS ARRAY. I HAVE MANIPULATED THE DATASET AND IMPLEMENTED MINOR STYLING AS SEEN IN THIS COMPONENTS LOCAL STYLE -->
    <full-calendar :events="fcEvents" locale="en"></full-calendar>
</template>

<script>  
 
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      Tasks:[],
      fcEvents :[]
    }
  },
    created: function(){
        var self = this;
        this.loadTasks().then(({data}) => {
        var s = JSON.stringify(data);
        var t = s.replace(/"name"/g, '"title"').replace(/"start_date"/g, '"start"').replace(/"due_date"/g, '"end"');
        var newJson = JSON.parse(t);
        self.fcEvents = newJson;
    },
        console.log(this.fcEvents)                    
                              
                              )},
    
methods: {
  loadTasks () {
      return axios.get(`./php/showtasks.php`);   
    } 
}
}
</script>
<style>
    
    .full-calendar-body .dates .dates-events .events-week .events-day .event-box .event-item {
         background-color: #639 !important;
         padding:1em;
         height:auto;
         color:white;
    }
    
    .comp-full-calendar{
    font-family: "elvetica neue", tahoma, "hiragino sans gb";
    background: #fff;
    padding: 0;
    padding-top:2em;
    max-width:none;
    }
.event-item {

}
</style>