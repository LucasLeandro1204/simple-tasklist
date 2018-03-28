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
};

export default new Task(Axios);
