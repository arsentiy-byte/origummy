import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categories: [],
        banners: [],
        products: [],
        productModal: false,
        basketModal: false,
        orderModal: false,
        thankModal: false,
        orderDetailModal: false,
        product: null,
        basketProducts: [],
        user_phone: null,
        user: null,
        lastScroll: 0,
        orders: [],
    },
    getters: {
        getCategories(state) {
            return state.categories;
        },
        getBanners(state) {
            return state.banners;
        },
        getProducts(state) {
            return state.products;
        },
        getProductModal(state) {
            return state.productModal;
        },
        getBasketModal(state) {
            return state.basketModal;
        },
        getOrderModal(state) {
            return state.orderModal;
        },
        getThankModal(state) {
            return state.thankModal;
        },
        getOrderDetailModal(state) {
            return state.orderDetailModal;
        },
        getProduct(state) {
            return state.product;
        },
        getBasketProducts(state) {
            return state.basketProducts;
        },
        getUserPhone(state) {
            return state.user_phone;
        },
        getTotal(state) {
            let total = 0;
            state.basketProducts.forEach((item) => {
                total += item.basketCount * item.price;
            });

            return total;
        },
        getUser(state) {
            return state.user;
        },
        getOrders(state) {
            return state.orders;
        },
    },
    mutations: {
        SET_CATEGORIES(state, data) {
            state.categories = data;
        },
        SET_BANNERS(state, data) {
            state.banners = data;
        },
        SET_PRODUCTS(state, data) {
            state.products = data;
        },
        SET_PRODUCT_MODAL(state, value) {
            state.productModal = value;
        },
        SET_BASKET_MODAL(state, value) {
            state.basketModal = value;
        },
        SET_ORDER_MODAL(state, value) {
            state.orderModal = value;
        },
        SET_THANK_MODAL(state, value) {
            state.thankModal = value;
        },
        SET_ORDER_DETAIL_MODAL(state, value) {
            state.orderDetailModal = value;
        },
        SET_PRODUCT(state, value) {
            state.product = value;
        },
        SET_BASKET_PRODUCTS(state, data) {
            state.basketProducts = data;
        },
        UPDATE_BASKET_PRODUCT(state, product) {
            const index = state.basketProducts.findIndex((item) => item.id === product.id);

            if (index !== -1) {
                if (product.basketCount === 0) {
                    state.basketProducts.splice(index, 1);
                } else {
                    state.basketProducts[index].basketCount = product.basketCount;
                }
            } else {
                state.basketProducts.push(product);
            }
        },
        CLEAR_BASKET_PRODUCTS(state) {
            state.basketProducts = [];
        },
        UPDATE_STORAGE_PRODUCTS(state) {
            localStorage.setItem('products', JSON.stringify(state.basketProducts));
        },
        UPDATE_STORAGE_USER(state) {
            localStorage.setItem('user_phone', JSON.stringify(state.user_phone));
        },
        SET_USER_PHONE(state, value) {
            state.user_phone = value;
        },
        SET_USER(state, value) {
            state.user = value;
        },
        MODAL_IS_OPENED(state, value) {
            if (value) {
                state.lastScroll = window.scrollY;
                document.body.classList.add('modal-open');
            } else {
                document.body.classList.remove('modal-open');
                window.scrollTo(0, state.lastScroll);
            }
        },
        SET_ORDERS(state, data) {
            state.orders = data;
        },
    },
    actions: {
        fetchCategories({commit}) {
            axios.get('/origummy/web/v1/categories/main_page')
                .then((response) => {
                    if (response.data && response.data.data) {
                        commit('SET_CATEGORIES', response.data.data);
                    }
                })
        },
        fetchBanners({commit}) {
            axios.get('/origummy/api/v1/banners')
                .then((response) => {
                    if (response.data && response.data.data) {
                        commit('SET_BANNERS', response.data.data);
                    }
                })
        },
        fetchProductsByCategorySlug({commit}, payload) {
            axios.get(`/origummy/web/v1/products/by_category/${payload.slug}`)
                .then((response) => {
                    if (response.data && response.data.data) {
                        commit('SET_PRODUCTS', response.data.data);
                    }
                })
        },
        fetchBasketProductsFromStore({commit}) {
            let products = localStorage.getItem('products');
            products = products ? JSON.parse(products) : [];
            commit('SET_BASKET_PRODUCTS', products);
        },
        fetchInfoFromStore({commit}) {
            let info = localStorage.getItem('user_phone');
            info = info ? JSON.parse(info) : null;

            commit('SET_USER_PHONE', info);
        },
        fetchUser({commit}, phone) {
            axios.get(`/origummy/api/v1/clients/by/phone/${phone}`)
                .then((response) => {
                    if (response.data && response.data.data) {
                        commit('SET_USER', response.data.data);
                    }
                })
        },
        fetchUserOrders({commit}, phone) {
            axios.get(`/origummy/web/v1/orders/by_client/${phone}`)
                .then((response) => {
                    if (response.data && response.data.data) {
                        commit('SET_ORDERS', response.data.data);
                    }
                })
        },
    },
});
