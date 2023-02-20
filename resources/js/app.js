import Jquery from 'jquery'
import 'bootstrap';
import './bootstrap';
import Swal from 'sweetalert2'
import Alpine from "alpinejs";
import { createApp } from 'vue'
import App from './vue/App.vue'
// import '../sass/app.scss'
import 'animate.css';

window.$ = Jquery;
window.Swal = Swal;
window.Alpine = Alpine;

Alpine.start();

const app = createApp(App)
app.mount('#app')