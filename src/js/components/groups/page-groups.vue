<template>
<div class="page-groups col-12"> 
    <header>
    <h1 class="text-center"> GROUPS </h1>
  <div class="form-row">
    <ul>
        <li><input type="text" class="form-control" placeholder="First name"></li>
        <li><input type="text" class="form-control" placeholder="Last name"></li>
        <li><a href="javascript:" class="btn btn-basic edit-profile"> Add New Goal</a></li>
    </ul>
  </div>
    </header>
    <section class="goals">
        <div v-if="importantgoals" v-for="goal in importantgoals" class="single-goal" v-bind:id="goal.ID">
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
                <a href="javascript:" @click="markComplete(goal.ID)" class="btn btn-basic complete-button"><li> Complete</li></a>
                <a href="javascript:" @click="removeGoal(goal.ID)" class="btn btn-danger logout"><li> Delete</li></a>
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
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>