<template>
    <div class="product">
        <div class="image" @click="openProductModal(product)"
             :style="`background-image: url('/images/${product.images[0].path}')`"
        ></div>
        <div class="info" @click="openProductModal(product)">
            <div class="title">
                <img class="promotion-img" src="/images/sale.svg" alt="" v-if="product.promotions.length > 0 && product.promotions[0].type.name === 'discount'">
                <img class="promotion-img" src="/images/gift.svg" alt="" v-if="product.promotions.length > 0 && product.promotions[0].type.name === 'gift'">
                <span>{{ product.title }}</span>
            </div>
            <div class="structure" v-if="product.related_products.length > 0">
                <slot name="structure">
                    {{ getProductsTitles(product.related_products) }}
                </slot>
            </div>
            <div class="description" v-else>
                <slot name="description">
                    {{ product.description }}
                </slot>
            </div>
            <div class="promotion" v-if="product.promotions.length > 0">
                + {{ getPromotionTitles(product.promotions[0]) }}
            </div>
            <div class="prices">
                <slot name="prices">
                    <span class="old_price" v-if="product.old_price">{{ product.old_price }} тг.</span>
                    <div class="price">{{ product.price }} тг. <span v-if="product.count">/ {{ product.count }} шт.</span></div>
                </slot>
            </div>
        </div>
        <div class="product-actions">
            <slot name="actions">
                <button><img src="/images/plus.svg" alt="" @click="addToBasket(product)"></button>
                <div class="basket-count"><span>{{ getProductCount(product) }}</span></div>
                <button><img src="/images/minus.svg" alt="" @click="removeFromBasket(product)"></button>
            </slot>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    props: ['product', 'fromBasket'],
    name: "Product",
    computed: {
        ...mapGetters({
            basketProducts: 'getBasketProducts',
        }),
    },
    watch: {
        basketProducts(newValue) {
            if (newValue.length === 0) {
                this.product.basketCount = 0;
            }
        },
    },
    methods: {
        openProductModal(product) {
            if (!this.fromBasket) {
                this.$store.commit('SET_PRODUCT_MODAL', true);
                this.$store.commit('SET_PRODUCT', product);
            }
        },
        getProductCount(product) {
            let basketProduct = this.basketProducts.find((item) => item.id === product.id);
            if (basketProduct) {
                product.basketCount = basketProduct.basketCount;
            }

            return product.basketCount;
        },
        addToBasket(product) {
            product.basketCount += 1;
            this.$store.commit('UPDATE_BASKET_PRODUCT', product);
            this.$store.commit('UPDATE_STORAGE_PRODUCTS');
        },
        removeFromBasket(product) {
            if (product.basketCount > 0) {
                product.basketCount -= 1;
                this.$store.commit('UPDATE_BASKET_PRODUCT', product);
                this.$store.commit('UPDATE_STORAGE_PRODUCTS');
            }
        },
        getProductsTitles(products) {
            return products.map((item) => {
                return item.title;
            }).join(', ');
        },
        getPromotionTitles(promotion) {
            if (promotion.type.name === 'gift') {
                return promotion.related_products.map((item) => {
                    return item.title;
                }).join(', ');
            } else if (promotion.type.name === 'discount') {
                return promotion.title;
            }

            return '';
        },
    },
}
</script>

<style scoped>

</style>
