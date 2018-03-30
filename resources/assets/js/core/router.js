import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Main from '@/Task/Main.vue';
// import Show from '@/Task/Show.vue';

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Main,
      name: 'task.index',
    },
    // {
    //   props: true,
    //   path: '/:id',
    //   component: Show,
    //   name: 'task.show',
    // }
  ],
});
