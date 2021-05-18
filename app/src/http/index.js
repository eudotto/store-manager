import axios from 'axios';
import store from '@/store';

const http = axios.create({
  baseURL: 'http://172.23.0.2/',
  headers: {
    'Accept': '*/*',
    'Content-Type': 'aplication/json',
  }
});

http.interceptors.request.use(function(config) {
  const token = store.state.token;

  if (token) {
    config.headers.Authorization = 'Bearer ' + token;
  }

  return config;
}, function(error) {
  return Promise.reject(error);
});

export default http;
