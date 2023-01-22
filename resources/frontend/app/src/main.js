import { createApp } from 'vue';
import router from './router';
import store from './store';
import App from './App';
import VueAxios from "vue-axios";
import axios from "axios";

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

const app = createApp(App);

app.use(store)
    .use(router)
    .use(VueAxios, axios)
    .mount('#app')
