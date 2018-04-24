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
    <div v-bind:class="compClasses" class="edit-modal profile">
           <h2> EDIT PROFILE</h2>
            <form>
        <div class="form-group">
            <label for="name" class="col-md-8 col-form-label"> Profile Name </label>
            <input type="text" class="form-control col-md-12" id="name" placeholder="Change profile name" v-model="profile[0].name">
            
            <label for="bio" class="col-md-8 col-form-label"> Bio</label>
            <input type="text" class="form-control col-md-12" id="bio" placeholder="Change profile bio" v-model="profile[0].bio">
            
            <label for="avatar" class="col-md-8 col-form-label"> Image </label>
            <input type="file" class="form-control col-md-12" id="avatar" placeholder="Change profile bio">
        </div>
        <div class="form-group">
            <div class="col-md-12 submit-row">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>  
        </div>
    <section class="goals">
       <h3> Important Goals </h3>
       <p> Your most important goals based on importance rating</p>
        <div v-if="importantgoals" v-for="goal in filterGoals" class="single-goal">
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
                <a href="#" class="btn btn-danger logout"><li> Delete</li></a>
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
        
        updateProfile() {
            // update profile axios
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
        });
        this.loadGoals().then(({data}) => {
          this.importantgoals = data 
        });
        
    },
     computed: {
        
        filterGoals: function() {
        return this.importantgoals.filter((goal) => {
            return goal.importance > 7;
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