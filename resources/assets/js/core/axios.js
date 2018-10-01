import Axios from 'axios';

export default Axios.create({
  baseURL: '/api',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
  },
});
