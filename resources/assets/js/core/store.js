import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'core/axios';

Vue.use(Vuex);

const task = () => {
  /**
   * @type {object}
   * @property {null|false|object} task Single task object
   * @property {null|false|array} tasks Array with all tasks
   */
  const state = {
    task: null,
    tasks: null,
  };

  const getters = {
    loadingTask: ({ task }) => task === null,
    loadingTasks: ({ tasks }) => tasks === null,
    hasTask: ({ tasks }, g) => ! g.loadingTask && typeof task === 'object',
    hasTasks: ({ tasks }, g) => ! g.loadingTasks && tasks && tasks.length > 0,
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
      .then(({ data }) => commit('SET_TASKS', data.data))
      .catch(() => commit('SET_TASKS', false)),

    find: ({ commit }, id) => Axios.get('task/' + id)
      .then(({ data }) => commit('SET_TASK', data))
      .catch(() => commit('SET_TASK', false)),
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
    task: task(),
  },
});
