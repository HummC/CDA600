import pageProfile from './components/profile/page-profile.vue';
import pageGoals from './components/goals/page-goals.vue';

export default[
    {path:"/",
    component:pageProfile},
    {path:"/#/goals",
    component: pageGoals}
]