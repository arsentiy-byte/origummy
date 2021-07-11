<template>
    <div id="app">
        <nav-bar/>
        <aside-menu :menu="menu"/>
        <router-view/>
        <footer-bar/>
        <b-loading :is-full-page="true" v-model="isLoading" :can-cancel="true"></b-loading>
    </div>
</template>

<script>
// @ is an alias to /src
import {mapGetters} from 'vuex';
import FooterBar from "./components/FooterBar";
import AsideMenu from "./components/AsideMenu";
import NavBar from "./components/NavBar";

export default {
    name: 'home',
    components: {
        FooterBar,
        AsideMenu,
        NavBar
    },
    computed: {
        ...mapGetters({
            isLoading: 'getIsLoading',
        }),
        menu() {
            return [
                'Главная',
                [
                    {
                        to: '/',
                        icon: 'desktop-mac',
                        label: 'Dashboard'
                    }
                ],
                'Модели',
                [
                    {
                        to: '/categories',
                        icon: 'alphabetical-variant',
                        label: 'Категории'
                    },
                    {
                        to: '/products',
                        icon: 'sitemap',
                        label: 'Товары'
                    },
                    {
                        to: '/promotions',
                        icon: 'sale',
                        label: 'Акции'
                    },
                    {
                        to: '/banners',
                        icon: 'picture-in-picture-top-right',
                        label: 'Баннеры'
                    }
                ]
            ]
        }
    },
}
</script>
