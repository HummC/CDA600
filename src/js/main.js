import Vue from 'vue'
import axios from 'axios'

// ROOT COMPONENT
import App from './components/App.vue'

// MAIN STYLES
import '../scss/main.scss'

//COMPONENTS PATH
import Sidebar from './components/app-navigation/sidebar.vue'
/*import GoalPage from 'components/goals/page-goals.vue'
       import GoalIndiv from 'components/goals/goals-individual.vue'
       import GoalGroup from 'components/goals/goals-group.vue'
import GroupPage 'components/groups/page-groups.vue'
       import GroupSingle from '../components/groups/groups-single.vue'
       import ProfileImportant '../components/profile/profile-important.vue'
       */
import PageProfile from './components/profile/page-profile.vue'
// REGISTERING COMPONENTS
Vue.component('sidebar', Sidebar);
Vue.component('page-profile', PageProfile);


// MAIN PAGES
import '../home.php'
import '../login.html'
import '../signup.html'



// TEST SCRIPTS

import '../testpost.html'
/*
import '../testmotivate.html'
import '../testdelete.html'
import '../testupdategoal.html'
import '../testupdategroup.html'
import '../testupdatetask.html'
import '../testjoin.html'
import '../testleave.html'
import '../testcomplete.html'
import '../testpostgoal.html'
import '../testpostgroup.html'
import '../testposttask.html'
*/

new Vue({
  el: '#app',
  render: h => h(App)
})


