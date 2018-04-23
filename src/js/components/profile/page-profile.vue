<template>
  <div class="page-profile col-12">
      <header class="banner">
          <div class="avatarcontainer">
              <img v-bind:src="imagesrc" alt="profile image">
          </div>
      </header>
      <section class="profile-description">
      <h2> Name </h2>
      <h4> Bio</h4>
      <p> Content </p>
    </section>
    <section class="goals">
        <div v-for="goal in filterGoals" class="single-goal">
            <h2>{{goal.name}}</h2>
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
      imagesrc: "",
      importantgoals: []
    }
  },
    created: function(){
        axios.get(`./php/showprofile.php`)
    .then(response => {
      console.log(response.data)
      this.imagesrc = response.data[0].image_loc
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