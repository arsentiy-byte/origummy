<template>
    <div>
        <div class="fixed">
            <nav-header id="header" :on-main-page="false" :on-menu="true"></nav-header>
            <swiper class="menu-slider swiper" :options="swiperOption">
                <swiper-slide v-for="(category, index) in categories" :key="index" class="item">
                    <router-link :to="{name: 'menu', params: {slug: category.slug}}" tag="span">
                        {{ category.title }}
                    </router-link>
                </swiper-slide>
            </swiper>
        </div>
        <div class="menu-content">
            <h1 class="category-title">Подарки и скидки</h1>
            <div class="products">
                <product v-for="(product, index) in products" :key="index" :product="product"/>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Header from "../components/Header";
import {Swiper, SwiperSlide} from "vue-awesome-swiper";
import Product from "../components/Product";

export default {
    name: "Promotions",
    components: {
        'nav-header': Header,
        Swiper, SwiperSlide, Product
    },
    data() {
        return {
            swiperOption: {
                freeMode: true,
                slidesPerView: 4,
            },
            products: [],
        };
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
        }),
    },
    created() {
        if (this.categories.length === 0) {
            this.$store.dispatch('fetchCategories');
        }

        this.getProductsWithPromotions();
    },
    methods: {
        getProductsWithPromotions() {
            axios.get('/origummy/web/v1/products/with/promotions')
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.products = response.data.data;
                    }
                })
        },
    },
}
</script>

<style scoped>
.category-title {
    text-transform: none;
}
</style>
