import Axios from 'axios';

class Task {
  constructor (axios) {
    this.request = axios.create({
      baseURL: '/api/task',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
    this.cache = new Map();
  }

  all () {
    if (this.cache.has('all')) {
      return Promise.resolve({
        data: this.cache.get('all'),
      });
    }

    return this.request.get()
      .then(({ data }) => {
        this.cache.set('all', data);

        return {
          data,
        };
      });
  }

  store (data) {
    return this.request.post('/', data)
      .then(({ data }) => {
        if (this.cache.has('all')) {
          this.cache.get('all').unshift(data);
        }

        return {
          data,
        };
      });
  }

  update (id, data) {
    return this.request.put('/' + id, data)
      .then(({ data }) => {
        if (this.cache.has('all')) {
          const tasks = this.cache.get('all');

          tasks[tasks.findIndex(task => task.id == id)] = data;
        }

        return {
          data,
        };
      });
  }

  find (id) {
    if (this.cache.has('all')) {
      const task = this.cache.get('all').find(t => t.id == id);

      if (task) {
        return Promise.resolve({
          data: task,
        });
      }

      return Promise.reject();
    }

    return this.request.get('/' + id);
  }

  delete (id) {
    if (this.cache.has('all')) {
      const tasks = this.cache.get('all');

      tasks.splice(tasks.findIndex(task => task.id == id), 1);
    }

    return this.request.delete('/' + id);
  }
};

export default new Task(Axios);
