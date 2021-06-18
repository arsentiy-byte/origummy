import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Categories from "./views/category/Categories";
import Category from "./views/category/Category";
import NewCategory from "./views/category/NewCategory";

Vue.use(Router)

const router = new Router({
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories,
        },
        {
            path: '/categories/new',
            name: 'categories.create',
            component: NewCategory,
        },
        {
            path: '/categories/:id',
            name: 'categories.edit',
            component: Category,
            props: true,
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {x: 0, y: 0}
        }
    }
})

export default router
