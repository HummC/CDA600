<template>
<div class="page-goals col-12"> 
   <header>
    <h1 class="text-center"> GOALS </h1>
  <div class="form-row">
    <ul>
        <li><input v-model="search" type="text" class="form-control" placeholder="Keywords"></li>
         <li><input @click="toggle = toggle !== 'grp' ? 'grp' : null" type="radio" name="options" id="option2" autocomplete="off">Individual</li>
        <li><input @click="toggle = toggle !== 'ind' ? 'ind' : null" type="radio" name="options" id="option1" autocomplete="off">Group</li>

        <li><a href="javascript:" class="btn btn-basic edit-profile"> Add New Goal</a></li>
    </ul>
  </div>
    </header>
    <div class="alert col-md-8 mx-auto" id="alert">
    </div>
    <section class="goals">
        <div  v-for="goal in searchGoals" class="single-goal" v-bind:id="goal.ID" v-bind:class="{ 'shown': toggle === 'ind' }">
            <h4>{{goal.name}}</h4>
            <small class="category"><span>Category:</span> {{goal.category}}</small>
            <p>{{goal.description}}</p>
            <div class="importance">
                {{goal.importance}}
            </div>
            <div class="progress progress-info">
                <div v-if="goal.status == 'complete'" v-bind:class="goal.status" class="bar">
                <ul>
                <a class="start" href="javascript:">{{goal.start_date}}</a>
                <a class="end" href="javascript:">{{goal.end_date}}</a>
                </ul>
                </div>
                 <div v-else class="bar">
                <ul>
                <a class="start" href="javascript:">{{goal.start_date}}</a>
                <a class="end" href="javascript:">{{goal.end_date}}</a>
                </ul>
                </div>
                </div>
            <ul class="goal-buttons">
                <a href="javascript:" @click="markComplete(goal.ID)" class="btn btn-basic complete-button"><li> Complete</li></a>
                <a href="javascript:" @click="removeGoal(goal.ID)" class="btn btn-danger logout"><li> Delete</li></a>
            </ul>
        </div>
    </section>
    
    
    
    
    
    <section class="groups">
        <div v-for="group in searchGroups" class="single-group" v-bind:id="group.ID" v-bind:class="{ 'shown': toggle === 'grp' }">
            <h4>{{group.name}}</h4>
            <small class="category"><span>Category:</span> {{group.category}}</small>
            <p>{{group.description}}</p>
            <div class="importance">
                {{group.importance}}
            </div>
            <h1 v-if="group.status == 'complete'">{{group.status}}</h1>
            <div class="progress progress-info">
                <div v-if="group.status == 'complete'" v-bind:class="group.status" class="bar">
                <ul>
                <a class="start" href="javascript:">{{group.start_date}}</a>
                <a class="end" href="javascript:">{{group.end_date}}</a>
                </ul>
                </div>
                
                 <div v-else class="bar">
                <ul>
                <a class="start" href="javascript:">{{group.start_date}}</a>
                <a class="end" href="javascript:">{{group.end_date}}</a>
                </ul>
                </div>
                
                </div>
            <ul class="goal-buttons">
                <a href="javascript:" @click="markCompleteGroup(group.ID)" class="btn btn-basic complete-button"><li> Complete</li></a>
                <a href="javascript:" @click="removeGroup(group.ID)" class="btn btn-danger logout"><li> Delete</li></a>
            </ul>
        </div>
    </section>
</div>
</template>

<script>   
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      importantgoals: [],
      mygroups:[],
      toggle:-1,
      search: "",
      progress:""
    }
  },
    
    

    
    
    
    
    
    

    
created: function(){
    
    // when page is created and after data is gathered, progress percentage is equal to this maths, then we
    // progress bar width equal to percentage, but how?
    
        this.loadGoals().then(({data}) => {
        this.importantgoals = data 
        });
    this.loadGroups().then(({data}) => {
       this.mygroups = data 
       console.log(this.mygroups);
    });  
},
    
    mounted: function() {
        if(this.mygroups.status == "complete") {
            this.progress = 100 + "%";
        }  
        else {
            this.progress = 0 + "%";
        }
    },
    
    
methods: {
  loadGoals () {
      return axios.get(`./php/showgoals.php`);   
    }, 
    
    loadGroups () {
      return axios.get(`./php/showgroups.php?mygroups`);   
    }, 
    
    markComplete(goalid) {
        var goalID = goalid;
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        //var goalID = e.target.id;
        var formData = new FormData();
            formData.set('goal_id', goalID);
            formData.set('complete', 1);
            axios.post('php/complete.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Completed!";
                var chosenElement = document.getElementById(goalid);
                var bar = chosenElement.querySelector('.bar');
                bar.style.backgroundColor = "#97c630";
                console.log(response.data);
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
                
              })
              .catch(function (error) {
                console.log(error);
                alert.className = "alert col-md-8 mx-auto alert-danger";
                alert.style.display = "block";
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
                  if(error.response.status == 400) {
                      message = "400 - Bad request - Profile cannot update with empty fields!";
                  }
                  else if (error.response.status == 415) {
                      message = "415 - Media format not supported. Supported formats: .jpg, .jpeg, .png";
                  }
                  else if (error.response.status == 409) {
                      message = "409 - Upload failed! Sorry :(";
                  }
                  else {
                      message = "Something went wrong, please check your username and password is correct and try again!";
                  }
    
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
               });  
            
        },
    
    markCompleteGroup(groupid) {
        var groupID = groupid;
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        //var goalID = e.target.id;
        var formData = new FormData();
            formData.set('group_id', groupID);
            formData.set('complete', 1);
            axios.post('php/complete.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Completed!";
                var chosenElement = document.getElementById(groupID);
                var bar = chosenElement.querySelector('.bar');
                bar.style.width = "100" + "%";
                bar.style.backgroundColor = "#97c630";
                console.log(response.data);
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
                
              })
              .catch(function (error) {
                console.log(error);
                alert.className = "alert col-md-8 mx-auto alert-danger";
                alert.style.display = "block";
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
                  if(error.response.status == 400) {
                      message = "400 - Bad request - Profile cannot update with empty fields!";
                  }
                  else if (error.response.status == 415) {
                      message = "415 - Media format not supported. Supported formats: .jpg, .jpeg, .png";
                  }
                  else if (error.response.status == 409) {
                      message = "409 - Upload failed! Sorry :(";
                  }
                  else {
                      message = "Something went wrong, please check your username and password is correct and try again!";
                  }
    
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
               });  
            
        },
    removeGoal(goalid) {
        var goalID = goalid;
        
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        //var goalID = e.target.id;
        var formData = new FormData();
            formData.set('goal_id', goalID);
            axios.post('php/delete.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Removed!";
                var chosenElement = document.getElementById(goalid);
                chosenElement.parentNode.removeChild(chosenElement);
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
                
              })
              .catch(function (error) {
                console.log(error);
                alert.className = "alert col-md-8 mx-auto alert-danger";
                alert.style.display = "block";
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
                  if(error.response.status == 400) {
                      message = "400 - Bad request - Profile cannot update with empty fields!";
                  }
                  else if (error.response.status == 415) {
                      message = "415 - Media format not supported. Supported formats: .jpg, .jpeg, .png";
                  }
                  else if (error.response.status == 409) {
                      message = "409 - Upload failed! Sorry :(";
                  }
                  else {
                      message = "Something went wrong, please check your username and password is correct and try again!";
                  }
    
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
               });  
        }, 
    
    
    
    
    removeGroup(groupid) {
        var groupID = groupid;
        
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        //var goalID = e.target.id;
        var formData = new FormData();
            formData.set('group_id', groupID);
            axios.post('php/delete.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Removed!";
                var chosenElement = document.getElementById(groupid);
                chosenElement.parentNode.removeChild(chosenElement);
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
                
              })
              .catch(function (error) {
                console.log(error);
                alert.className = "alert col-md-8 mx-auto alert-danger";
                alert.style.display = "block";
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
                  if(error.response.status == 401) {
                      message = "401 - Unauthorized! You must be group owner to delete the group, if you wish to leave a group visit the group page and click 'leave group'.";
                  }
                  else if (error.response.status == 415) {
                      message = "415 - Media format not supported. Supported formats: .jpg, .jpeg, .png";
                  }
                  else if (error.response.status == 409) {
                      message = "409 - Upload failed! Sorry :(";
                  }
                  else {
                      message = "Something went wrong, please check your username and password is correct and try again!";
                  }
    
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
               });  
        },
},
    
     computed: {
        
        filterGoals: function() {
        return this.importantgoals.filter((goal) => {
        return goal.importance > 2
        })
        },
         
        searchGoals: function() {
            return this.importantgoals.filter(goal => {
                return goal.name.match(this.search);
            });
        },
         
          searchGroups: function() {
            return this.mygroups.filter(group => {
                return group.name.match(this.search);
            });
        },
         
         compClasses: function() {
              return {
            shown:this.shown
              } 
}
}
}
</script>