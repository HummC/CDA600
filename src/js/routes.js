import pageProfile from './components/profile/page-profile.vue';
import pageGoals from './components/goals/page-goals.vue';
import pageTasks from './components/tasks/page-tasks.vue';
import pageCallendar from './components/callendar/page-callendar.vue';
import pageGroups from './components/groups/page-groups.vue';

export default[
    {path:"/",
    component:pageProfile},
    {path:"/goals",
    component: pageGoals},
    {path:"/tasks",
    component: pageTasks},
    {path:"/callendar",
    component: pageCallendar},
    {path:"/groups",
    component: pageGroups}
]