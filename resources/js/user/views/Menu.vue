<template>
    <div>
        <div class="fixed">
            <nav-header id="header" :on-main-page="false" :on-menu="true"></nav-header>
            <swiper class="menu-slider swiper" :options="swiperOption">
                <swiper-slide v-for="(category, index) in categories" :key="index" :class="slug === category.slug ? 'item active' : 'item'">
                    <router-link :to="{name: 'menu', params: {slug: category.slug}}" tag="span">
                        {{ category.title }}
                    </router-link>
                </swiper-slide>
            </swiper>
        </div>
        <div class="menu-content" v-if="category">
            <h1 class="category-title">{{ category.title }}</h1>
            <div class="products">
                <product v-for="(product, index) in products" :key="index" :product="product"/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../components/Header";
import {Swiper, SwiperSlide} from "vue-awesome-swiper";
import {mapGetters} from 'vuex';
import Product from "../components/Product";

export default {
    props: {
        slug: {
            type: String,
            required: true,
        },
    },
    name: "Menu",
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
            category: {},
        };
    },
    watch: {
        categories(newValue) {
            if (newValue.length > 0) {
                this.category = newValue.find((item) => {
                    return item.slug === this.slug;
                })
            }
        },
        category(newValue) {
            this.$store.dispatch('fetchProductsByCategorySlug', {slug: newValue.slug});
        },
        slugFromParams(newValue) {
            document.querySelector('.menu-slider').classList.remove('active');
            document.querySelector('.bg-content').classList.remove('active');

            this.category = this.categories.find((item) => {
                return item.slug === newValue;
            });
        },
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
            products: 'getProducts',
        }),
        slugFromParams() {
            return this.$route.params.slug;
        }
    },
    created() {
        if (this.categories.length === 0) {
            this.$store.dispatch('fetchCategories');
        } else {
            this.category = this.categories.find((item) => {
                return item.slug === this.slug;
            });
        }
    },
}
</script>

<style scoped>

</style>
