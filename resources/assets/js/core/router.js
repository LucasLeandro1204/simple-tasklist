import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Form from '@/Task/Form.vue';
import Main from '@/Task/Main.vue';
import Show from '@/Task/Show.vue';

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Main,
      name: 'task.index',
    },
    {
      path: '/create',
      component: Form,
      name: 'task.create',
    },
    {
      props: true,
      path: '/:id',
      component: Show,
      name: 'task.show',
    },
    {
      props: true,
      path: '/:id/edit',
      component: Form,
      name: 'task.edit',
    },
  ],
});
