<template>
    <div class="main">
        <nav-header id="header"/>
        <div class="info">
            Доставка суши с 11:00 до 23:00 г. Алматы
        </div>
        <swiper class="swiper banners" :options="swiperOption">
            <swiper-slide class="banner" v-for="(banner, index) in banners" :key="index">
                <img :src="`/images/${banner.image}`" :alt="index" class="image">
            </swiper-slide>
            <div class="swiper-pagination swiper-pagination-bullets" slot="pagination"></div>
        </swiper>
        <div class="categories">
            <router-link tag="div"
                         class="category" v-for="category in categories"
                         :key="category.id"
                         :style="`background-image: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ), url('/images/${category.images[0].path}')`"
                         :to="{name: 'menu', params: {slug: category.slug}}">
                <span class="title">{{category.title}}</span>
            </router-link>
        </div>
    </div>
</template>

<script>
import {Swiper, SwiperSlide} from 'vue-awesome-swiper'
import {mapGetters} from 'vuex'
import Header from "../components/Header";

export default {
    name: "Main",
    components: {
        Swiper,
        SwiperSlide,
        'nav-header': Header,
    },
    data() {
        return {
            swiperOption: {
                autoHeight: true,
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 1500,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    renderBullet(index, className) {
                        return `<span class="${className} swiper-pagination-bullet-custom"></span>`
                    }
                }
            }
        };
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
            banners: 'getBanners',
        }),
    },
    created() {
        this.$store.dispatch('fetchCategories');
        this.$store.dispatch('fetchBanners');
    },
}
</script>

<style scoped>
.swiper /deep/ .swiper-pagination-bullet-custom {
    width: 18px !important;
    height: 2px !important;
    line-height: 18px !important;
    text-align: center;
    color: rgba(242, 242, 242, 0.6);
    opacity: 0.6;
    background: rgba(242, 242, 242, 0.2);
    transition: all 0.1s;
    border-radius: 2px;
}

.swiper /deep/ .swiper-pagination-bullet-active {
    opacity: 1;
    color: #f2f2f2;
    background: #f2f2f2;
}
</style>
