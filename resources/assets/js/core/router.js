import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Task from '@/Task/Main.vue';

export default new VueRouter({
  routes: [
    {
      path: '/',
      component: Task,
    },
  ],
});
