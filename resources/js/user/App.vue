<template>
    <div id="app">
        <div class="bg-over" @click="closeBurger"></div>
        <div class="content">
            <div class="bg-content" v-if="$route.name === 'menu'" @click="closeMenu"></div>
            <router-view/>
        </div>
        <nav-footer id="footer"/>
        <burger/>
        <product-modal/>
        <basket-modal/>
        <order-modal/>
        <thank-modal/>
    </div>
</template>

<script>
import Header from "./components/Header";
import Footer from "./components/Footer";
import Burger from "./components/Burger";
import ProductModal from "./components/ProductModal";
import BasketModal from "./components/BasketModal";
import OrderModal from "./components/OrderModal";
import ThankModal from "./components/ThankModal";

export default {
    name: "App",
    components: {
        'nav-header': Header,
        'nav-footer': Footer,
        Burger, ProductModal,  BasketModal, OrderModal, ThankModal,
    },
    created() {
        this.$store.dispatch('fetchBasketProductsFromStore');
        this.$store.dispatch('fetchInfoFromStore');
        const user_id = this.$store.getters.getUserId;
        if (user_id) {
            this.$store.dispatch('fetchUser', user_id);
        }
    },
    methods: {
        closeMenu() {
            document.querySelector('.menu-slider').classList.remove('active');
            document.querySelector('.bg-content').classList.remove('active');
        },
        closeBurger() {
            document.querySelector('.burger-modal').classList.remove('active');
            document.querySelector('.bg-over').classList.remove('active');
        },
    },
}
</script>

<style scoped>
</style>
