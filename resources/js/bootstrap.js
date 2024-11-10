import axios from 'axios';
import {BASE_URL} from './constants/urls';

window.axios = axios;

window.axios.defaults.baseURL = BASE_URL;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';
