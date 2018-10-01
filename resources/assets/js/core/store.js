import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'core/axios';

Vue.use(Vuex);

const filters = [
  {
    name: 'All',
    icon: 'fa-list',
    empty: {
      icon: 'fa-file-o',
      title: 'You don\'t have any tasks',
      subtitle: 'Try to create some =D',
    },
    execute: tasks => tasks,
  },
  {
    name: 'Remain',
    icon: 'fa-circle-o',
    empty: {
      icon: 'fa-sign-language',
      title: 'You have completed all your tasks',
      subtitle: 'Go add more tasks, you can\'t stop xD',
    },
    execute: tasks => tasks.filter(task => ! task.status),
  },
  {
    name: 'Done',
    icon: 'fa-check',
    empty: {
      icon: 'fa-meh-o',
      title: 'Whaaattt???',
      subtitle: 'GO FINISH YOUR TASKS!!!',
    },
    execute: tasks => tasks.filter(task => task.status),
  }
];

const task = () => {
  /**
   * @type {object}
   * @property {null|false|object} task Single task object
   */
  const state = {
    task: null,
  };

  const getters = {
    fetching: ({ task }) => task === null,
    fetched: ({ task }) => typeof task === 'object',
  };

  const mutations = {
    'SET_TASK' (state, task) {
      state.task = task;
    },
  };

  const actions = {
    fetch: ({ commit }, id) => Axios.get('task/' + id)
      .then(({ data }) => commit('SET_TASK', data))
      .catch(() => commit('SET_TASK', false)),
  };

  return {
    state,
    actions,
    getters,
    mutations,
    namespaced: true,
  };
};

const tasks = () => {
  const busy = new Map();

  /**
   * @type {object}
   * @property {null|false|array} tasks Array with all tasks
   */
  const state = {
    filters,
    tasks: null,
    filter: 'All',
  };

  const getters = {
    fetching: ({ tasks }) => tasks === null,
    fetched: ({ tasks }) => Array.isArray(tasks),
    count: ({ tasks }, g) => g.fetched ? tasks.length : 0,
    filtered: ({ tasks }, g) => g.filter.execute(tasks || []),
    filter: ({ filters, filter }) => filters.find(f => f.name == filter),
  };

  const mutations = {
    'SET_TASKS' (state, tasks) {
      state.tasks = tasks;
    },

    'SET_FILTER' (state, filter) {
      state.filter = filter;
    },

    'SET_TASK_STATUS' (state, { id, status }) {
      const task = state.tasks.find(task => task.id == id);

      if (! task) {
        return;
      }

      task.status = status;
    },
  };

  const actions = {
    fetch: ({ commit }) => Axios.get('task')
      .then(({ data }) => commit('SET_TASKS', data))
      .catch(() => commit('SET_TASKS', false)),

     updateStatus: ({ commit }, { id, status }) => {
      if (busy.has(id)) {
        return Promise.resolve();
      }

      busy.set(id, true);

      commit('SET_TASK_STATUS', { id, status });

      return Axios.put('task/' + id, {
          status,
        })
        .catch(() => commit('SET_TASK_STATUS', { id, status: ! status }))
        .finally(() => busy.delete(id));
     },
  };

  return {
    state,
    actions,
    getters,
    mutations,
    namespaced: true,
  };
};

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',

  modules: {
    task: task(),
    tasks: tasks(),
  },
});
