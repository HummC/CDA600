<template>
<div class="page-tasks col-12"> 
    <header>
    <h1 class="text-center"> TASKS </h1>
  <div class="form-row">
    <ul>
        <li><a href="javascript:" class="btn btn-basic edit-profile"> Add New Task</a></li>
    </ul>
  </div>
    </header>
    <div class="alert col-md-8 mx-auto" id="alert">
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
            <td v-if="task.due_date > today || task.status == 'complete'">{{task.status}}</td>
            <td v-else>
            <div class="button-group-tasks" id="task.ID">
            <a class="task.ID" href="javascript:" @click="complete(task.ID)"> Yes / </a>
            <a href="javascript:" @click="notcomplete(task.ID)"> No </a>
            </div>
            
            </td>
            <td><a class="btn btn-basic edit-profile"> Edit</a></td>
            <td><a class="btn btn-danger logout"> Delete </a></td>
            
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
      overdue: false
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
                message = "Successfully Completed!";
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
        
        
        
    }
    
    
    }
}
</script>