import './bootstrap';
import { createApp } from 'vue'
import axios from "axios";
import App from './App.vue'

window.axios = axios;

const app = createApp(App)

app.mount('#app')