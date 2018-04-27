<template>
<div class="page-group col-12"> 
    <header>
    <h1 class="text-center">
        {{groupinfo[0].name}} 
    </h1>
    <a v-if="joined" @click="leave()" class="btn btn-basic edit-profile">Leave Group</a>
    <a v-else class="btn btn-basic edit-profile" @click="join()">Join Group</a>
    </header>
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
        <p>scheduled for today</p>
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
      taskList:[]
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
    
    
  join() {
     
  },
    
  leave() {

  },
    
  loadGroup () {
      return axios.get(`./php/showgroups.php?group_id=`+this.id);   
    }, 
}
}
</script>