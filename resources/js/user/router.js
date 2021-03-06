import Vue from 'vue'
import Router from 'vue-router'
import Main from "./views/Main";
import Menu from "./views/Menu";
import MyOrders from "./views/MyOrders";
import Promotions from "./views/Promotions";
import About from "./views/About";

Vue.use(Router);

const router = new Router({
    history: true,
    hashbang: false,
    mode: 'history',
    base: process.env.APP_URL,
    routes: [
        {
            path: '/',
            name: 'main',
            component: Main,
        },
        {
            path: '/menu/:slug',
            name: 'menu',
            component: Menu,
            beforeEnter: (to, from, next) => {
                if (to.params.slug) {
                    next();
                } else {
                    next({name: 'main'});
                }
            },
            props: true,
        },
        {
            path: '/my-orders',
            name: 'my-orders',
            component: MyOrders,
        },
        {
            path: '/promotions',
            name: 'promotions',
            component: Promotions,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        }
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {x: 0, y: 0}
        }
    },
});

export default router;
