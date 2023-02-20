import Jquery from 'jquery'
import 'bootstrap';
import './bootstrap';
import Swal from 'sweetalert2'
import { createApp } from 'vue'
import App from './vue/App.vue'
import '../sass/bootstrap.scss'
import 'animate.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();
window.$ = Jquery;
window.Swal = Swal;

const app = createApp(App)
app.mount('#app')