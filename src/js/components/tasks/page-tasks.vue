<template>
<div class="page-tasks col-12"> 
    <header>
    <h1 class="text-center"> TASKS </h1>
  <div class="form-row">
    <ul>
        <li><a @click="toggle = toggle !== 'tsks' ? 'tsks' : null" href="javascript:" class="btn btn-basic add-group"> Add New Task</a></li>
    </ul>
  </div>
    </header>
    <div class="alert col-md-8 mx-auto" id="alert">
    </div>
    <div v-bind:class="{ 'display': toggle === 'tsks' }" class="edit-modal profile">
           <h2> ADD TASK </h2>
            <form>
        <div class="form-group">
            <label for="taskname" class="col-md-8 col-form-label"> Task Name </label>
            <input type="text" class="form-control col-md-12" id="taskname" placeholder="Name of your task">
            
            <label for="parent" class="col-md-8 col-form-label"> Parent Goal  <span><i class="fas fa-arrow-left"></i>(INDIVIDUAL GOAL TASKS ARE VIEWABLE BY JUST YOU)</span></label>
            <select class="form-control col-md-12" id="taskparentgoals">
                <option> </option>
                <option v-for="parent in goalParents">
                {{parent.name}}
                </option>
            </select>
            
            <label for="parent" class="col-md-8 col-form-label"> Parent Group <span><i class="fas fa-arrow-left"></i> (GROUP TASKS ARE VIEWABLE BY THE COMMUNITY)</span>  </label>
            <select class="form-control col-md-12" id="taskparentgroups">
               <option> </option>
                <option v-for="parent in groupParents">
                {{parent.name}}
                </option>
            </select>
            
            <label for="description" class="col-md-8 col-form-label"> Description</label>
            <textarea type="text" class="form-control col-md-12" id="taskdescription" placeholder="Try being specific for better results, example: 'run 3 miles in 10 minutes' as opposed to 'Go for run' "></textarea>
            
            <label for="taskstartdate" class="col-md-8 col-form-label"> Start Date</label>
            <input type="date" class="form-control col-md-12" id="taskstartdate">
            
            <label for="taskenddate" class="col-md-8 col-form-label"> Due Date</label>
            <input type="date" class="form-control col-md-12" id="taskenddate">
            
        </div>
        <div class="form-group">
            <div class="col-md-12 submit-row">
                <button  @click="addTask()" type="submit" class="btn btn-primary">Add Task</button>
            </div>
        </div>
    </form>  
        </div>
        
    <section class="tasks">
       <table>
       <tr>
          <th> Task Date</th>
          <th> Task Name</th>
          <th> Motivates </th>
          <th> Did you complete </th>
          <th> Edit </th>
          <th> Delete </th>
       </tr>
        <tr  v-for="task in taskList"v-bind:id="task.ID">
            <td>{{task.due_date}}</td>
            <td>{{task.name}}</td>
            <td>{{task.motivates}}</td>
            <td v-if="task.due_date > today || task.status == 'complete' || task.status == 'in-complete'">{{task.status}}</td>
            <td v-else>
            <div class="button-group-tasks" id="task.ID">
            <a class="task.ID" href="javascript:" @click="complete(task.ID)"> Yes / </a>
            <a href="javascript:" @click="notcomplete(task.ID)"> No </a>
            </div>
            
            </td>
            <td><a class="btn btn-basic edit-profile"> Edit</a></td>
            <td><a class="btn btn-danger logout" @click="removeTask(task.ID)"> Delete </a></td>
            
    </tr>
    </table>
    </section>
</template>

<script>   
export default {
  name: 'app',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      taskList:[],
      today: "",
      toggle: -1,
      overdue: false,
      groupParents:[],
      goalParents:[]
    }
  },
    
      created: function(){
       var self = this;
        
         axios.get('php/showtasks.php',
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
          
            axios.get('php/showparents.php?goals',
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.goalParents = response.data;
              })
              .catch(function (error) {
           
               }); 
          
          
          
          
           axios.get('php/showparents.php?groups',
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.groupParents = response.data;
              })
              .catch(function (error) {
           
               }); 
          
          
        var theDate = new Date();
        var month = theDate.getMonth() + 1;
        var day = theDate.getDate();
        var year = theDate.getFullYear();
        
        this.today = year + "-" + "0" + month + "-" + day;
          
          
    },
    
    methods: {

    complete(taskid) {
        var taskID = taskid;
        var alert = document.getElementById('alert');
        var element = document.getElementById(taskID).childNodes;
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        var formData = new FormData();
            formData.set('task_id', taskID);
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
                message = "Successfully Updated!";
                console.log(response.data);
                element[5].innerHTML = "completed";
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
        
    notcomplete(taskid) {
        
        var taskID = taskid;
        var alert = document.getElementById('alert');
        var element = document.getElementById(taskID).childNodes;
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        var formData = new FormData();
            formData.set('task_id', taskID);
            formData.set('complete', 0);
            axios.post('php/complete.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Updated!";
                console.log(response.data);
                element[5].innerHTML = "in-complete";
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
        
        removeTask(taskid) {
        var taskID = taskid;
        
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        var formData = new FormData();
            formData.set('task_id', taskID);
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
                var chosenElement = document.getElementById(taskid);
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
        
        
        
        addTask(event) {
    var alert = document.getElementById('alert');
    alert.innerHTML = '';
    alert.style.display="none";
    
        // CREATE ELEMENT
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        var formData;
        formData = new FormData();
            
        // INPUTS 
        var taskname = document.getElementById('taskname').value;
        var taskParentGroup = document.getElementById('taskparentgroups').value;
        var taskParentGoal = document.getElementById('taskparentgoals').value;
        var taskstart = document.getElementById('taskstartdate').value;
        var taskend = document.getElementById('taskenddate').value;
        var taskDesc = document.getElementById('taskdescription').value;
            
        if(taskParentGroup !== "" && taskParentGoal !== "") {
            console.log("ERROR!");
        }
            
        else if(taskParentGroup !== "") {
             formData.set('groupname', taskParentGroup);
        }
        else if(taskParentGoal !== "") {
            formData.set('goalname', taskParentGoal);
        }
        else {
            alert("A task can have only 1 parent - choose either group or goal, but not both!");
        }
            
        // CHANGE INPUT TO STRING TO BE PARSED AS FORM DATA AND NOT JSON
            
        /*var params = new URLSearchParams();
        params.append('name',name);
        params.append('bio',bio);
        params.append('avatar',avatar_image);
        */
            formData.set('taskname', taskname);
            formData.set('taskstart', taskstart);
            formData.set('taskend', taskend);
            formData.set('taskdesc', taskDesc);
            
        // AXIOS POST REQUEST
        
              axios.post('php/addtasks.php', formData,
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
                document.getElementById('taskparentgoals').style.border = "1px solid #ced4da";
                document.getElementById('taskparentgroups').style.border = "1px solid #ced4da";
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
                      message = "400 - Bad request - Tasks can have 1 parent goal, or 1 parent group, but not both! - Please check that you have selected just one.";
                      document.getElementById('taskparentgoals').style.border = "2px solid red";
                      document.getElementById('taskparentgroups').style.border = "2px solid red";
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
            }, 6000);
               });
},
    
    
    
    }
}
</script>