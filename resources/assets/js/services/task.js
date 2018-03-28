import Axios from 'axios';

class Task {
  constructor (axios) {
    this.request = axios.create({
      baseURL: 'api/task',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
    this.cache = new Map();
  }

  all () {
    if (this.cache.has('all')) {
      return Promise.resolve({ data: this.cache.get('all') });
    }

    return this.request.get()
      .then(({ data }) => {
        this.cache.set('all', data);

        return {
          data,
        };
      });
  }

  update (id, data) {
    return this.request.put('/' + id, data);
  }

  find (id) {
    if (this.cache.has('all')) {
      const data = this.cache.get('all').find(task => task.id == id);

      if (data) {
        return Promise.resolve({ data });
      }

      return Promise.reject({ data });
    }
    return this.request.get('/' + id);
  }
};

export default new Task(Axios);
