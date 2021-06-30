import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Categories from "./views/category/Categories";
import Category from "./views/category/Category";
import NewCategory from "./views/category/NewCategory";
import Products from "./views/product/Products";
import Promotions from "./views/promotion/Promotions";
import NewPromotion from "./views/promotion/NewPromotion";
import Promotion from "./views/promotion/Promotion";
import NewProduct from "./views/product/NewProduct";
import Product from "./views/product/Product";

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
        {
            path: '/products',
            name: 'products',
            component: Products,
        },
        {
            path: '/products/new',
            name: 'products.create',
            component: NewProduct,
        },
        {
            path: '/products/:id',
            name: 'products.edit',
            component: Product,
            props: true,
        },
        {
            path: '/promotions',
            name: 'promotions',
            component: Promotions,
        },
        {
            path: '/promotions/new',
            name: 'promotions.create',
            component: NewPromotion,
        },
        {
            path: '/promotions/:id',
            name: 'promotions.edit',
            component: Promotion,
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
