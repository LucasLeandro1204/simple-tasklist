import Axios from 'axios';

class Task {
  constructor (axios) {
    this.request = axios.create({
      baseURL: 'api/task',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
  }

  all () {
    return this.request.get();
  }

  update (id, data) {
    return this.request.put('/' + id, data);
  }
};

export default new Task(Axios);
