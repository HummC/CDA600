<template>
<div class="page-groups col-12"> 
    <header>
    <h1 class="text-center"> GROUPS </h1>
    </header>
     <div class="alert col-md-8 mx-auto" id="alert">
    </div>
    <section class="goals">
        <div  v-for="group in groups" class="single-goal" v-bind:id="group.ID">
            <h4>{{group.name}} <span class="memberscount">({{group.members}} / {{group.size}})</span></h4>
            <small class="category"><span>Category:</span> {{group.category}}</small>
            <p>{{group.description}}</p>
            <ul class="group-buttons">
                <router-link v-bind:to="'/groups/' + group.ID"><a href="javascript:" class="btn btn-basic view-button"><li> View </li></a></router-link>
                <a href="javascript:" @click="join(group.ID)" class="btn btn-basic complete-button"><li> Join Group </li></a>
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
      groups: []
    }
  },
    
    created: function() {
        var self = this;
        axios.get('php/showgroups.php',
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                self.groups = response.data;
              })
              .catch(function (error) {
           
               });
    },
    methods: {
        join(groupid) {
        var groupID = groupid;
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        
        
        // CREATE ELEMENT
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        
            
        var formData = new FormData();
            formData.set('group_id', groupID);
            
        // AXIOS POST REQUEST
        
              axios.post('php/join.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Joined!"
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                // APPEND CREATED ELEMENT
                // APPEND TEXT NODE
                
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
               });
        }
    }
}
</script>