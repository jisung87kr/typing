import Jquery from 'jquery'
import 'bootstrap';
import './bootstrap';
import Swal from 'sweetalert2'
import { createApp } from 'vue'
import App from './vue/App.vue'
import '../sass/bootstrap.scss'
import 'animate.css';

window.$ = Jquery;
window.Swal = Swal;

const app = createApp(App)
app.mount('#app')