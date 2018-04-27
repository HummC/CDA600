<template>
<div class="page-group col-12"> 
    <header>
    <h1 class="text-center">
        {{groupinfo[0].name}} 
    </h1>
    <a @click="leave(groupinfo[0].ID)" class="btn btn-basic edit-profile">Leave Group</a>
    </header>
     <div class="alert col-md-8 mx-auto" id="alert">
    </div>
    <section class="memberssection">
       <ul class="group-tabs">
           <li @click="toggle = toggle !== 'mems' ? 'mems' : null"> View Members</li>
       </ul>
           <div class="avatarcontainer" v-bind:class="{ 'display': toggle === 'mems' }">
           <div v-for="member in groupmembers">
            <a href="javascript:"><img v-bind:src="member.image_loc">
            <span>{{member.name}}</span>
            </a>
            </div>
           </div> 
            
            <div class="descriptioncontainer" v-bind:class="{ 'display': toggle === 'descr' }">
            <h4> Description </h4>
            <p v-for="group in groupinfo">{{group.description}}</p>
           </div>
    </section>
    <section class="todaystasks">
    
    <h1> {{todaysDate}} </h1>
    <hr/>
    <div v-for="task in taskList" class="grouptasks">
            <a href="javascript:"><img v-bind:src="task.image_loc"></a> 
        <h5>{{task.name}}</h5>
        <p> - scheduled for today</p>
        <div class="button-group">
        <a href="javascript:" @click="motivate(task.ID)" v-bind:id="task.ID" class="btn btn-basic visitedmotivate"><i class="fa fa-star"></i> Motivate </a>
            <router-link v-bind:to="'/tasks/' + task.ID"><a href="#" class="btn btn-basic"> View </a></router-link>
    </div>
    </div>    
        
        
        
    </section>
    </div>
</template>

<script>   
export default {
  name: 'single-group',
  data () {
    return {
      id: this.$route.params.id, // route parameter
      toggle:-1,
      groupinfo:[],
      groupmembers:[],
      joined: true,
      todaysDate: "",
      taskList:[],
      visitedmotivate: false
    }
  },
    created: function(){
       var self = this;
       axios.get('php/showmembers.php?group_id='+this.id,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.groupmembers = response.data;
              })
              .catch(function (error) {
           
               });
        
        
        
        
         axios.get('php/showtasks.php?group_id='+this.id,
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
        
        var theDate = new Date();
        var month = theDate.getMonth() + 1;
        var day = theDate.getDate();
        var year = theDate.getFullYear();
        
        this.todaysDate = day + "-" + month + "-" + year;        
        this.loadGroup().then(({data}) => {
       self.groupinfo = data
       console.log(data)
    }); 
    },
    
methods: {
    
  motivate(taskid) {
   
    var taskid = taskid;
    var formData = new FormData();
    formData.set('task_id', taskid);
      
              axios.post('php/motivate.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                document.getElementById(taskid).style.backgroundColor = "white";
                document.getElementById(taskid).style.color = "#639";
                document.getElementById(taskid).innerHTML = "<i class='fa fa-star'></i>  Motivated!";
              })
              .catch(function (error) {
                console.log(error);
              })
  },
        
  join() {
     
  },
    
  leave(groupid) {
    var groupid = groupid;
    var formData = new FormData();
    formData.set('group_id', groupid);
     var alert = document.getElementById('alert');
     alert.innerHTML = '';
     alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
      
              axios.post('php/leave.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Group Left!";
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
                window.location="./";
            }, 1500);   
              })
              .catch(function (error) {
                console.log(error);
                window.location="./";
              }) 
  },
    
  loadGroup () {
      return axios.get(`./php/showgroups.php?group_id=`+this.id);   
    }
}
}
</script>