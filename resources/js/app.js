import './bootstrap';
import Jquery from 'jquery'
import { createApp } from 'vue'
import App from './vue/App.vue'
import '../sass/app.scss'
import 'animate.css';

window.$ = Jquery;

const app = createApp(App)
app.mount('#app')