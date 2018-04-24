import Vue from 'vue'
import axios from 'axios'
import VueRouter from 'vue-router'
import Routes from "./routes"
import 'vue-event-calendar/dist/style.css'
import vueEventCalendar from 'vue-event-calendar'
Vue.use(vueEventCalendar, {locale: 'en'}) /
Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes
});

// ROOT COMPONENT
import App from './components/App.vue'

// MAIN STYLES
import '../scss/main.scss'

//COMPONENTS PATH
import Sidebar from './components/app-navigation/sidebar.vue'
import PageGoals from './components/goals/page-goals.vue'
import PageGroups from './components/groups/page-groups.vue'
import PageProfile from './components/profile/page-profile.vue'
import PageCallendar from './components/callendar/page-callendar.vue'

// REGISTERING COMPONENTS
Vue.component('sidebar', Sidebar);
Vue.component('page-profile', PageProfile);
Vue.component('page-goals', PageGoals);
Vue.component('page-groups', PageGroups);
Vue.component('page-callendar', PageCallendar);


// MAIN PAGES
import '../home.php'
import '../login.html'
import '../signup.html'



// TEST SCRIPTS

import '../testpost.html'
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

Vue.filter('uppercase',function(value) {
    return value.toUpperCase()
});

new Vue({
  el: '#app',
  render: h => h(App),
    router:router
})


