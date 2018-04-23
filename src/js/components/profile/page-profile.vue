<template>
  <div class="page-profile col-12">
      <header class="banner">
          <div class="avatarcontainer">
              <img v-bind:src="profile[0].image_loc" alt="profile image">
          </div>
      </header>
      <section class="profile-description">
      <h2> {{profile[0].name}} </h2>
      <h4> Bio</h4>
      <p> {{profile[0].bio}} </p>
      <hr/>
      <a href="#" class="btn btn-basic edit-profile"> Edit Profile</a>
      
    </section>
    <section class="goals">
       <h3> Important Goals </h3>
       <p> Your most important goals based on importance rating</p>
       <hr/>
        <div v-for="goal in filterGoals" class="single-goal">
            <h4>{{goal.name}}</h4>
            <small>{{goal.category}}</small>
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
      importantgoals: []
    }
  },
    created: function(){
        axios.get(`./php/showprofile.php`)
    .then(response => {
      console.log(response.data)
      this.profile = response.data;
    })
    .catch(e => {
      this.errors.push(e)
    });
    
    axios.get(`./php/showgoals.php`)
    .then(response => {
      this.importantgoals = response.data;
      console.log(response.data)
    })
    .catch(e => {
      this.errors.push(e)
    });
    
    },
     computed: {
        filterGoals: function() {
        return this.importantgoals.filter((goal) => {
            return goal.importance > 7;
        })
        }    
}
}
</script>