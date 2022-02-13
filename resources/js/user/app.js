require('./bootstrap');

import Vue from 'vue'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/css/swiper.min.css';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import 'vue2-timepicker/dist/VueTimepicker.css'
Vue.use(VueAwesomeSwiper);

import router from "./router";
import store from "./store";

import App from "./App.vue";

Vue.config.productionTip = false

Vue.component('App', App)

new Vue({
    store,
    router,
    render: h => h(App),
}).$mount('#app')
