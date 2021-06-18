<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <section class="section is-main-section">
            <tiles>
                <card-widget class="tile is-child" type="is-primary" icon="account-multiple" :number="getTotalClients"
                             label="Клиенты"/>
                <card-widget class="tile is-child" type="is-info" icon="cart-outline" :number="getTotalSales" suffix=" тг."
                             label="Продажи"/>
                <card-widget class="tile is-child" type="is-success" icon="chart-timeline-variant" :number="getTotalOrders"
                             label="Заказы"/>
            </tiles>

            <card-component title="Статистика за текущий месяц" @header-icon-click="loadStatistics" icon="finance" header-icon="reload">
                <div v-if="statisticsCharts.data" class="chart-area">
                    <line-chart style="height: 100%"
                                ref="bigChart"
                                chart-id="big-line-chart"
                                :chart-data="statisticsCharts.data"
                                :extra-options="statisticsCharts.options">
                    </line-chart>
                </div>
            </card-component>

            <card-component title="Заказы за текущий месяц" class="has-table has-mobile-sort-spaced">
                <statistics-orders-table/>
            </card-component>
        </section>
    </div>
</template>

<script>
import * as chartConfig from '../components/Charts/chart.config'
import TitleBar from "../components/TitleBar";
import HeroBar from "../components/HeroBar";
import Tiles from "../components/Tiles";
import CardWidget from "../components/CardWidget";
import CardComponent from "../components/CardComponent";
import LineChart from "../components/Charts/LineChart";
import StatisticsOrdersTable from "../used/StatisticsOrdersTable";
import {mapGetters} from 'vuex';

export default {
    name: 'home',
    components: {
        StatisticsOrdersTable,
        LineChart,
        CardComponent,
        CardWidget,
        Tiles,
        HeroBar,
        TitleBar
    },
    data () {
        return {
            statisticsCharts: {
                data: null,
                options: chartConfig.chartOptionsMain,
            },
        };
    },
    computed: {
        titleStack() {
            return [
                'Admin',
                'Dashboard'
            ]
        },
        ...mapGetters({
            total: 'getStatisticsTotal',
            charts: 'getStatisticsCharts',
        }),
        getTotalClients() {
            return this.total.clients;
        },
        getTotalOrders() {
            return this.total.orders;
        },
        getTotalSales() {
            return this.total.sales;
        },
        getDaysInMonth() {
            let days = [];
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();
            for (let i = 1; i <= new Date(currentYear, currentMonth + 1, 0).getDate(); i++) {
                days.push(i);
            }
            return days;
        },
    },
    created() {
        this.loadStatistics();
    },
    mounted() {
        this.fillChartData();

        this.$buefy.snackbar.open({
            message: 'Добро пожаловать',
            queue: false
        })
    },
    watch: {
        charts(newValue) {
            this.charts = newValue;
            this.fillChartData();
        },
        total(newValue) {
            this.total = newValue;
        },
    },
    methods: {
        loadStatistics() {
            this.$store.dispatch('getStatistics');
            this.fillChartData();
        },
        fillChartData() {
            this.statisticsCharts.data = {
                datasets: [
                    {
                        fill: true,
                        borderColor: chartConfig.chartColors.default.primary,
                        borderWidth: 2,
                        borderDash: [],
                        borderDashOffset: 0.0,
                        pointBackgroundColor: chartConfig.chartColors.default.primary,
                        pointBorderColor: 'rgba(255,255,255,0)',
                        pointHoverBackgroundColor: chartConfig.chartColors.default.primary,
                        pointBorderWidth: 20,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 15,
                        pointRadius: 4,
                        data: this.charts.clients,
                        label: 'Клиенты'
                    },
                    {
                        fill: true,
                        borderColor: chartConfig.chartColors.default.info,
                        borderWidth: 2,
                        borderDash: [],
                        borderDashOffset: 0.0,
                        pointBackgroundColor: chartConfig.chartColors.default.info,
                        pointBorderColor: 'rgba(255,255,255,0)',
                        pointHoverBackgroundColor: chartConfig.chartColors.default.info,
                        pointBorderWidth: 20,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 15,
                        pointRadius: 4,
                        data: this.charts.orders,
                        label: 'Заказы'
                    }
                ],
                labels: this.getDaysInMonth
            }
        }
    }
}
</script>
