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
  </div>
</template>

<script>
export default {
  name: 'page-profile',
  data () {
    return {
      imagesrc: "",
      imagehere: "location"
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
    }
}
</script>