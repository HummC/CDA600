<template>
<div class="page-goals col-12"> 
   <header>
    <h1 class="text-center"> GOALS </h1>
  <div class="form-row">
    <ul>
        <li><input v-model="search" type="text" class="form-control" placeholder="Keywords"></li>
         <li><input @click="toggle = toggle !== 'grp' ? 'grp' : null" type="radio" name="options" id="option2" autocomplete="off">Individual Goals</li>
        <li><input @click="toggle = toggle !== 'ind' ? 'ind' : null" type="radio" name="options" id="option1" autocomplete="off">Group</li>

        <li><a @click="display = !display" href="javascript:" class="btn btn-basic edit-profile"> Add New Goal</a></li>
    </ul>
  </div>
    </header>
    <div class="alert col-md-8 mx-auto" id="alert">
    </div>
    <div v-bind:class="compClasses" class="edit-modal profile">
           <h2> ADD GOAL </h2>
            <form>
        <div class="form-group">
            <label for="name" class="col-md-8 col-form-label"> Goal Name </label>
            <input type="text" class="form-control col-md-12" id="goalname" placeholder="Goal Name">
            
            <label for="name" class="col-md-8 col-form-label"> Category </label>
            <select class="form-control col-md-12" id="goalcategory">
                <option> Health &amp; Fitness</option>
                <option> Academic</option>
                <option> Career</option>
                <option> Social</option>
                <option> Entertainment</option>
                <option> Arts &amp; Entertainment</option>
                <option> Sports &amp; Recreation</option>
                <option> Volunteer</option>
                <option> Other</option>
            </select>
            
            <label for="description" class="col-md-8 col-form-label"> Description</label>
            <textarea type="text" class="form-control col-md-12" id="goaldescription" placeholder="Goal description"></textarea>
            
            <label for="goalstartdate" class="col-md-8 col-form-label"> Start Date</label>
            <input type="date" class="form-control col-md-12" id="goalstartdate">
            
            <label for="goalenddate" class="col-md-8 col-form-label"> Due Date</label>
            <input type="date" class="form-control col-md-12" id="goalenddate">
            
            <label for="goalimportance" class="col-md-8 col-form-label"> Importance</label>
            <select class="form-control col-md-12" id="goalimportance">
                <option value=4> Very Important</option>
                <option value=3> Important</option>
                <option value=2> Average</option>
                <option value=1> Not important</option>   
            </select>
            
            <label for="goaldifficult" class="col-md-8 col-form-label"> Difficulty</label>
            <select class="form-control col-md-12" id="goaldifficult">
                <option value=5> Very Difficult</option>
                <option value=4> Difficult</option>
                <option value=3> Average</option>
                <option value=2> Not Difficult</option>
                <option value=1> Easy</option> 
            </select>
        </div>
        <div class="form-group">
            <div class="col-md-12 submit-row">
                <button  @click="addGoal()" type="submit" class="btn btn-primary">Add Goal</button>
            </div>
        </div>
    </form>  
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
      display: false,
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
    
    
addGoal() {
    var alert = document.getElementById('alert');
    alert.innerHTML = '';
    alert.style.display="none";
    
        // CREATE ELEMENT
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        
            
        // INPUTS 
        var goalname = document.getElementById('goalname').value;
        var goalcat = document.getElementById('goalcategory').value;
        var goalstart = document.getElementById('goalstartdate').value;
        var goalend = document.getElementById('goalenddate').value;
        var goalDesc = document.getElementById('goaldescription').value;
        var goalDif = document.getElementById('goaldifficult').value;
        var goalImp = document.getElementById('goalimportance').value;
            
        // CHANGE INPUT TO STRING TO BE PARSED AS FORM DATA AND NOT JSON
            
        /*var params = new URLSearchParams();
        params.append('name',name);
        params.append('bio',bio);
        params.append('avatar',avatar_image);
        */
        var formData = new FormData();
            formData.set('goalname', goalname);
            formData.set('goalcat', goalcat);
            formData.set('goalstart', goalstart);
            formData.set('goalend', goalend);
            formData.set('goaldesc', goalDesc);
            formData.set('goaldif', goalDif);
            formData.set('goalimp', goalImp);
            
        // AXIOS POST REQUEST
        
              axios.post('php/addgoals.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Success!"
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
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
                bar.style.width = "100" + "%";
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
                if(!this.importantgoals == null) {
                return goal.name.match(this.search);
                }
                else {
                    return "";
                }
            });
        },
         
          searchGroups: function() {
            return this.mygroups.filter(group => {
                return group.name.match(this.search);
            });
        },
         
         compClasses: function() {
              return {
            display:this.display
              } 
}
}
}
</script>