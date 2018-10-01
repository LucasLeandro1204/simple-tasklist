import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'core/axios';

Vue.use(Vuex);

const tasks = () => {

  /**
   * @type {object}
   * @property {null|object} task Single task (show)
   * @property {null|array} tasks All tasks
   */
  const state = {
    task: null,
    tasks: null,
  };

  const mutations = {
    'SET_TASKS' (state, tasks) {
      state.tasks = tasks;
    },

    'SET_TASK' (state, task) {
      state.task = task;
    },
  };

  const actions = {
    fetch: ({ commit }) => Axios.get('task')
      .then(({ data }) => commit('SET_TASKS', data.data)),
    find: ({ commit }, task) => Axios.get('task/' + task)
      .then(({ data }) => commit('SET_TASK', data)),
  };

  return {
    state,
    actions,
    mutations,
    namespaced: true,
  };
};

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',

  modules: {
    tasks,
  },
});
