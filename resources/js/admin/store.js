import Vue from 'vue'
import Vuex from 'vuex'

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
        isAsideMobileExpanded: false
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
                    }
                })
                .catch((error) => {
                    this.$buefy.toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
    },
})
