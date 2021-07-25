<template>
    <div>
        <modal :show="isShow" @close="close" id="product-modal" v-if="product">
            <template slot="body">
                <div class="title">{{ product.title }}</div>
                <div>
                    <swiper class="swiper images" :options="swiperOption">
                        <swiper-slide class="product-image" v-for="(productImage, index) in product.images" :key="index">
                            <div :style="`background-image: url('/images/${productImage.path}')`" :alt="index" class="image">
                            </div>
                        </swiper-slide>
                        <div class="swiper-pagination swiper-pagination-bullets" slot="pagination"></div>
                    </swiper>
                </div>
                <div class="structure" v-if="product.related_products.length > 0">
                    <div class="related_product" v-for="(relatedProduct, index) in product.related_products" :key="index">
                        <span class="title">{{ getProductTitle(relatedProduct) }}</span>
                        <span class="count">{{ getProductCount(relatedProduct) }}</span>
                    </div>
                </div>
                <div class="description" v-else>
                    {{ product.description && product.description !== 'null' ? product.description : '' }}
                </div>
                <div class="promotion" v-if="product.promotions.length > 0">
                    <span class="title">{{ getPromotionTitle(product.promotions[0]) }}</span>
                    <span class="type">{{ getPromotionType(product.promotions[0]) }}</span>
                </div>
                <div class="actions">
                    <a href="#" class="to-basket" @click.prevent="toBasket">К корзине</a>
                    <a class="whatsapp" :href="`https://wa.me/77787478866?text=${encodeURI('Я хочу заказать ' + product.title)}`">WhatsApp</a>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Modal from "./Modal";
import {Swiper, SwiperSlide} from 'vue-awesome-swiper'

export default {
    name: "ProductModal",
    components: {
        Modal,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            swiperOption: {
                direction: 'vertical',
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 2000,
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
            isShow: 'getProductModal',
            product: 'getProduct',
        }),
    },
    watch: {
        isShow(newValue) {
            this.isShow = newValue;
            this.$store.commit('MODAL_IS_OPENED', newValue);
        },
        product(newValue) {
            this.product = newValue;
        },
    },
    methods: {
        close() {
            this.$store.commit('SET_PRODUCT_MODAL', false);
            this.$store.commit('SET_PRODUCT', null);
        },
        getProductTitle(product) {
            if (product.category.slug === 'picca') {
                return product.title.split(' ')[0];
            }

            return product.title;
        },
        getProductCount(product) {
            if (product.category.slug === 'picca') {
                return product.title.split(' ')[1] + ' ' + product.title.split(' ')[2];
            }

            return product.count ? product.count + ' шт.' : '';
        },
        getPromotionTitle(promotion) {
            if (promotion.type.name === 'gift') {
                return promotion.related_products.map((item) => {
                    return item.title
                }).join(', ');
            }

            if (promotion.type.name === 'discount') {
                return promotion.title;
            }

            return '';
        },
        getPromotionType(promotion) {
            if (promotion.type.name === 'gift') {
                return 'В подарок';
            }

            return '';
        },
        toBasket() {
            this.$store.commit('SET_BASKET_MODAL', true);
        },
    },
}
</script>

<style scoped>
.swiper /deep/ .swiper-pagination-bullet-custom {
    width: 3px !important;
    height: 24px !important;
    line-height: 18px !important;
    text-align: center;
    color: rgba(0, 0, 0, 0.2);
    opacity: 0.6;
    background: rgba(0, 0, 0, 0.2);
    transition: all 0.1s;
    border-radius: 2px;
}

.swiper /deep/ .swiper-pagination-bullet-active {
    opacity: 1;
    color: rgba(0, 0, 0, 0.4);
    background: rgba(0, 0, 0, 0.4);
}
</style>
