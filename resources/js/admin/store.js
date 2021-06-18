import Vue from 'vue'
import Vuex from 'vuex'
import {ToastProgrammatic as Toast, NotificationProgrammatic as Notification} from 'buefy'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null,
        statisticsTotal: [],
        statisticsCharts: [],
        statisticsOrders: [],

        /* NavBar */
        isNavBarVisible: true,

        /* FooterBar */
        isFooterBarVisible: true,

        /* Aside */
        isAsideVisible: true,
        isAsideMobileExpanded: false,

        pagination: {
            total_pages: 0,
            total_items: 0,
            current_page: 1,
            limit: 10,
        },

        categories: [],
    },
    getters: {
        getStatisticsTotal(state) {
            return state.statisticsTotal;
        },
        getStatisticsOrders(state) {
            return state.statisticsOrders
        },
        getStatisticsCharts(state) {
            return state.statisticsCharts;
        },
        getCategories(state) {
            return state.categories;
        },
        getPagination(state) {
            return state.pagination;
        },
    },
    mutations: {
        /* A fit-them-all commit */
        basic(state, payload) {
            state[payload.key] = payload.value
        },

        /* Aside Mobile */
        asideMobileStateToggle(state, payload = null) {
            const htmlClassName = 'has-aside-mobile-expanded'

            let isShow

            if (payload !== null) {
                isShow = payload
            } else {
                isShow = !state.isAsideMobileExpanded
            }

            if (isShow) {
                document.documentElement.classList.add(htmlClassName)
            } else {
                document.documentElement.classList.remove(htmlClassName)
            }

            state.isAsideMobileExpanded = isShow
        },

        SET_STATISTICS_CHARTS(state, data) {
            state.statisticsCharts = data;
        },

        SET_STATISTICS_ORDERS(state, data) {
            state.statisticsOrders = data;
        },

        SET_STATISTICS_TOTAL(state, data) {
            state.statisticsTotal = data;
        },

        SET_CATEGORIES(state, data) {
            state.categories = data;
        },

        SET_PAGINATION(state, data) {
            state.pagination = data;
        },
    },
    actions: {
        getStatistics({commit}) {
            axios.get('origummy/web/v1/statistics')
                .then((response) => {
                    if (response.data && response.data.data) {
                        let data = response.data.data;
                        commit('SET_STATISTICS_ORDERS', data['orders']);
                        commit('SET_STATISTICS_TOTAL', data['total']);
                        commit('SET_STATISTICS_CHARTS', data['charts']);
                        Notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        })
                    }

                    if (response.data.status !== 'success') {
                        Toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    Toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
        getCategories({commit}, page = 1) {
            axios.get('origummy/api/v1/categories?page=' + page)
                .then((response) => {
                    if (response.data && response.data.data) {
                        let data = response.data.data;
                        commit('SET_CATEGORIES', data.items);
                        commit('SET_PAGINATION', data.pagination);
                        Notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        })
                    }

                    if (response.data.status !== 'success') {
                        Toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    Toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
        getCategoriesByFilter({commit}, filter) {
            axios.get('origummy/api/v1/categories', {
                params: filter,
            })
                .then((response) => {
                    if (response.data && response.data.data) {
                        let data = response.data.data;
                        commit('SET_CATEGORIES', data.items);
                        commit('SET_PAGINATION', data.pagination);
                        Notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        })
                    }

                    if (response.data.status !== 'success') {
                        Toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    Toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
    },
})
