import './bootstrap';
import { createApp } from 'vue'
import App from './vue/App.vue'
import '../sass/app.scss'
import 'animate.css';

const app = createApp(App)
app.mount('#app')