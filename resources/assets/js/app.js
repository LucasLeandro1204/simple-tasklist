import Vue from 'vue';
import Axios from 'axios';
import App from '@/App.vue';

const token = document.head.querySelector('meta[name="csrf-token"]');

Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

const app = new Vue(App).$mount('#app');
