<template>
    <div>
        <div class="fixed">
            <nav-header id="header" :on-main-page="false"></nav-header>
        </div>
        <div class="menu-content my-orders">
            <h1 class="category-title">Мои заказы</h1>
            <div class="orders-group" v-if="user && ordersGroups.length > 0">
                <div class="group" v-for="(group, index) in ordersGroups" :key="index">
                    <div class="group-date">
                        {{ getDate(group.date) }}
                    </div>
                    <div class="group-orders">
                        <div class="order" v-for="(order, orderIndex) in group.orders" :key="orderIndex">
                            <div class="top">
                                <span class="order-id">Заказ #{{order.id}}</span>
                            </div>
                            <div class="bottom">
                                <span class="order-details" @click="openModal(order)">Подробнее</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-orders-empty" v-else>
                <img src="/images/basket-empty.svg" alt="">
                <div class="title">Вы ещё не сделали заказ</div>
                <div class="info">Пройдите на “Главное” и добавьте в корзину понравившийся товар.</div>
                <a href="/">На главное</a>
            </div>
        </div>
        <order-detail-modal :order="currentOrder"/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Header from "../components/Header";
import OrderDetailModal from "../components/OrderDetailModal";

export default {
    name: "MyOrders",
    data() {
        return {
            currentOrder: null,
        };
    },
    components: {
        'nav-header': Header,
        OrderDetailModal,
    },
    computed: {
        ...mapGetters({
            orders: 'getOrders',
            user: 'getUser',
        }),
        ordersGroups() {
            const groups = this.orders.reduce((groups, order) => {
                const date = order.date.split(' ')[0];
                if (!groups[date]) {
                    groups[date] = [];
                }

                groups[date].push(order);
                return groups;
            }, {});

            return Object.keys(groups).map((date) => {
                return {
                    date,
                    orders: groups[date]
                };
            });
        },
    },
    watch: {
        user(newValue) {
            this.$store.dispatch('fetchUserOrders', newValue.phone);
        },
    },
    created() {
        if (!this.user) {
            this.$store.dispatch('fetchInfoFromStore');
            const userPhone = this.$store.getters.getUserPhone;
            if (userPhone) {
                this.$store.dispatch('fetchUser', userPhone);
            }
        } else {
            this.$store.dispatch('fetchUserOrders', this.user.phone);
        }
    },
    methods: {
        getDate(date) {
            return date.split('-').reverse().join('.');
        },
        openModal(order) {
            this.currentOrder = order;
            this.$store.commit('SET_ORDER_DETAIL_MODAL', true);
        },
    },
}
</script>

<style scoped>
.category-title {
    text-transform: none;
}

.my-orders-empty {
    height: auto !important;
    min-height: auto !important;
}

.my-orders-empty a {
    margin-top: 50px;
}

.group {
    margin-bottom: 15px;
}
</style>
