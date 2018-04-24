<template v-if="profile">
  <div class="page-profile col-12">
      <header class="banner">
          <div class="avatarcontainer">
              <img v-if="profile" v-bind:src="profile[0].image_loc" alt="profile image">
          </div>
      </header>
      <section class="profile-description">
      <h2> {{profile[0].name | uppercase}} </h2>
      <h4> Bio</h4>
      <p> {{profile[0].bio}} </p>
      <hr/>
      <a @click="shown = !shown" href="javascript:" class="btn btn-basic edit-profile"> Edit Profile</a>
    </section>
    <div class="alert col-md-8 mx-auto" id="alert">
   </div>
    <div v-bind:class="compClasses" class="edit-modal profile">
           <h2> EDIT PROFILE</h2>
            <form>
        <div class="form-group">
            <label for="name" class="col-md-8 col-form-label"> Profile Name </label>
            <input type="text" class="form-control col-md-12" id="name" placeholder="Change profile name" v-model="profile[0].name">
            
            <label for="bio" class="col-md-8 col-form-label"> Bio</label>
            <textarea type="text" class="form-control col-md-12" id="bio" placeholder="Change profile bio" v-model="profile[0].bio"></textarea>
            
            <label for="avatar" class="col-md-8 col-form-label"> Image </label>
            <input type="file" class="form-control col-md-12" id="avatar" placeholder="Change profile bio">
        </div>
        <div class="form-group">
            <div class="col-md-12 submit-row">
                <button @click="updateProfile" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>  
        </div>
    <section class="goals">
       <h3> Important Goals </h3>
       <p> Your most important goals based on importance rating</p>
        <div v-if="importantgoals" v-for="goal in filterGoals" class="single-goal" v-bind:id="goal.ID">
            <h4>{{goal.name}}</h4>
            <small class="category"><span>Category:</span> {{goal.category}}</small>
            <p>{{goal.description}}</p>
            <div class="importance">
                {{goal.importance}}
            </div>
            <div class="progress progress-info">
                <div class="bar"></div>
                </div>
            <ul class="goal-buttons">
                <a href="#" class="btn btn-basic complete-button"><li> Complete</li></a>
                <a href="#" class="btn btn-basic goal-button"><li> Edit</li></a>
                <a href="javascript:" @click="removeGoal(goal.ID)" class="btn btn-danger logout"><li> Delete</li></a>
            </ul>
        </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'page-profile',
  data () {
    return {
      profile: [],
      importantgoals: [],
      shown: false
    }
  },
    
    methods: {
        
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
            console.log(goalID);
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
        updateProfile(e) {
        e.preventDefault();
        var alert = document.getElementById('alert');
        alert.innerHTML = '';
        alert.style.display="none";
        
        
        // CREATE ELEMENT
        var p = document.createElement("p");
        var a = document.createElement("a");
        var message = "";
        
            
        // INPUTS 
        var name = document.getElementById('name').value;
        var bio = document.getElementById('bio').value;
        var avatar_image = document.getElementById('avatar').files[0];
        console.log(avatar_image);
        var formData = new FormData();
            formData.set('name', name);
            formData.set('bio', bio);
            formData.set('avatar', avatar_image);
            
        // AXIOS POST REQUEST
        
              axios.post('php/updateprofile.php', formData,
              {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
              .then(function (response) {
                console.log(response.data);
                alert.className = "alert col-md-8 mx-auto alert-success";
                alert.style.display = "block";
                message = "Successfully Updated!"
                var textNode = document.createTextNode(message);
                p.appendChild(textNode);
                alert.appendChild(p);
                  setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
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
                  setTimeout(function(){
                alert.style.display = "none";
            }, 2500);
               });
            
        },
        loadProfile () {
              return axios.get(`./php/showprofile.php`);
     },
    loadGoals () {
      return axios.get(`./php/showgoals.php`);   
    } 
    },
    created: function(){
        this.loadProfile().then(({data}) => {
          this.profile = data 
          console.log(data);
        });
        this.loadGoals().then(({data}) => {
          this.importantgoals = data 
          console.log(data);
        });
        
    },
     computed: {
        
        filterGoals: function() {
        return this.importantgoals.filter((goal) => {
            return goal.importance > 2;
        })
        },
          compClasses: function() {
              return {
            shown:this.shown
              }     
}
}
}
</script>