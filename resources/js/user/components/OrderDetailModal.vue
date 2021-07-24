<template>
    <div>
        <modal :show="isShow" @close="close" id="order-detail-modal" v-if="isShow">
            <template slot="body">
                <div class="order-id">Заказ #{{ order.id }}</div>
                <div class="products" v-if="products.length > 0">
                    <product v-for="(product, index) in products" :key="index" :product="product" :from-basket="false">
                        <template slot="structure">
                            <div></div>
                        </template>
                        <template slot="description">
                            <div></div>
                        </template>
                        <template slot="prices">
                            <div class="count">
                                {{ product.pivot.count }} шт.
                            </div>
                        </template>
                        <template slot="actions">
                            <div class="product-basket-clear">
                                <span class="product-price">{{ product.price }} тг.</span>
                            </div>
                        </template>
                    </product>
                </div>
                <div class="basket-price" v-if="products.length > 0">
                    <span class="price-title">Итого</span>
                    <span class="value">{{ order.total_price }}</span>
                </div>
                <div class="actions" v-if="products.length > 0">
                    <a href="#" @click.prevent="reorder" class="to-form">Повторить заказ</a>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from './Modal';
import {mapGetters} from 'vuex';
import Product from "./Product";

export default {
    name: "OrderDetailModal",
    props: ['order'],
    components: {
        Modal, Product,
    },
    computed: {
        ...mapGetters({
            isShow: 'getOrderDetailModal',
        }),
        products() {
            return this.order.products;
        },
    },
    watch: {
        isShow(newValue) {
            this.isShow = newValue;
            this.$store.commit('MODAL_IS_OPENED', newValue);
        },
    },
    methods: {
        close() {
            this.$store.commit('SET_ORDER_DETAIL_MODAL', false);
        },
        trashProduct(id) {
            const index = this.products.findIndex((item) => item.id === id);
            this.products.splice(index, 1);
        },
        reorder() {
            const products = this.products.map((item) => {
                item.basketCount = item.pivot.count;
                return item;
            });
            this.$store.commit('CLEAR_BASKET_PRODUCTS');
            this.$store.commit('SET_BASKET_PRODUCTS', products);
            this.$store.commit('UPDATE_STORAGE_PRODUCTS');
            this.close();
            this.$store.commit('SET_BASKET_MODAL', true);
        },
    },
}
</script>

<style scoped>
.actions {
    justify-content: center !important;
}
</style>
