<template>
    <div class="header">
        <div class="logo">
            <router-link :to="{name: 'main'}" tag="div" class="avatar" v-if="!empty"></router-link>
            <div class="title" v-if="onMainPage">
                <span class="top">
                    OriGummy
                </span>
                <span class="down">
                    Мастерская суши
                </span>
            </div>
        </div>
        <div class="search" v-if="false">
            <input type="text" name="search" class="input" placeholder="Поиск">
        </div>
        <div class="menu active" v-if="onMenu" @click="openMenu">
            <span>Меню</span>
            <img src="/images/arrow.svg" alt="">
        </div>
        <div class="burger" v-if="!onMenu" @click="openBurger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="basket" v-if="onMenu" @click="openBasketModal">
            <img src="/images/basket.svg" alt="" class="icon">
            <span class="price">
                {{ total }} тг.
            </span>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "Header",
    props: {
        onMainPage: {
            type: Boolean,
            default: true,
        },
        onMenu: {
            type: Boolean,
            default: false,
        },
        empty: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        ...mapGetters({
            total: 'getTotal',
        }),
    },
    methods: {
        openMenu() {
            let menu = document.querySelector('.menu-slider');
            let bg = document.querySelector('.bg-content');

            if (menu.classList.contains('active')) {
                menu.classList.remove('active');
                bg.classList.remove('active');
            } else {
                menu.classList.add('active');
                bg.classList.add('active');
            }
        },
        openBasketModal() {
            this.$store.commit('SET_BASKET_MODAL', true);
        },
        openBurger() {
            document.querySelector('.burger-modal').classList.add('active');
            document.querySelector('.bg-over').classList.add('active');
        },
    },
}
</script>

<style scoped>

</style>
