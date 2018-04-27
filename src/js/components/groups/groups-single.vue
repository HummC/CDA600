<template>
<div class="page-callendar col-12"> 
    <header>
    <h1 class="text-center"> GROUP SINGLE </h1>
    <h2> {{groupinfo[0].name}}</h2>
    </header>
</template>

<script>   
export default {
  name: 'single-group',
  data () {
    return {
      id: this.$route.params.id, // route parameter
      groupinfo:[]
    }
  },
    created: function(){
        this.loadGroup().then(({data}) => {
        this.groupinfo = data 
        });
    },
    
methods: {
  loadGroup () {
      return axios.get(`./php/showgroups.php?group_id=`+this.id);   
    } 
}
}
</script>