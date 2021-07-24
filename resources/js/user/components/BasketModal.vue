<template>
    <div>
        <modal :show="isShow" @close="close" id="basket-modal" v-if="isShow">
            <template slot="body">
                <div class="basket-title" v-if="products.length > 0">Корзина</div>
                <div class="empty" v-if="products.length === 0">
                    <img src="/images/basket-empty.svg" alt="">
                    <div class="title">Ваша корзина пуста</div>
                    <div class="info">Пройдите на “Главное” и добавьте в корзину понравившийся товар.</div>
                    <a href="/">На главное</a>
                </div>
                <div class="products" v-if="products.length > 0">
                    <product v-for="(product, index) in products" :key="index" :product="product" :from-basket="false">
                        <template slot="structure">
                            <div></div>
                        </template>
                        <template slot="description">
                            <div></div>
                        </template>
                        <template slot="prices">
                            <div class="product-basket-actions">
                                <button><img src="/images/minus.svg" alt="" @click="removeFromBasket(product)"></button>
                                <div class="basket-count"><span>{{ getProductCount(product) }}</span></div>
                                <button><img src="/images/plus.svg" alt="" @click="addToBasket(product)"></button>
                            </div>
                        </template>
                        <template slot="actions">
                            <div class="product-basket-clear">
                                <img src="/images/trash.svg" alt="" class="product-clear" @click="trashProduct(product)">
                                <span class="product-price">{{ product.price }} тг.</span>
                            </div>
                        </template>
                    </product>
                </div>
                <div class="basket-price" v-if="products.length > 0">
                    <span class="price-title">К оплате</span>
                    <span class="value">{{ total }} тг.</span>
                </div>
                <div class="actions" v-if="products.length > 0">
                    <span class="clear" @click="clear">Очистить корзину</span>
                    <a href="#" @click.prevent="toForm" class="to-form">Заказать</a>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Modal from "./Modal";
import Product from "./Product";

export default {
    name: "BasketModal",
    components: {
        Modal, Product,
    },
    computed: {
        ...mapGetters({
            isShow: 'getBasketModal',
            products: 'getBasketProducts',
            total: 'getTotal',
        }),
    },
    watch: {
        isShow(newValue) {
            this.isShow = newValue;
            this.$store.commit('MODAL_IS_OPENED', newValue);
        },
    },
    methods: {
        close() {
            this.$store.commit('SET_BASKET_MODAL', false);
        },
        toForm() {
            this.$store.commit('SET_ORDER_MODAL', true);
        },
        clear() {
            this.$store.commit('CLEAR_BASKET_PRODUCTS');
            this.$store.commit('UPDATE_STORAGE_PRODUCTS');
        },
        getProductCount(product) {
            let basketProduct = this.products.find((item) => item.id === product.id);
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
        trashProduct(product) {
            product.basketCount = 0;
            this.$store.commit('UPDATE_BASKET_PRODUCT', product);
            this.$store.commit('UPDATE_STORAGE_PRODUCTS');
        }
    },
}
</script>

<style scoped>

</style>
