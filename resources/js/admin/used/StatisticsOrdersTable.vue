<template>
    <div>
        <b-table
            :loading="isLoading"
            :striped="true"
            :hoverable="true"
            default-sort="name"
            :data="orders">

            <b-table-column label="#" field="id" sortable v-slot="props">
                {{ props.row.id }}
            </b-table-column>
            <b-table-column label="Имя клиента" field="client_name" sortable v-slot="props">
                {{ props.row.client_name }}
            </b-table-column>
            <b-table-column label="Номер телефона" field="client_phone" sortable v-slot="props">
                {{ props.row.client_phone }}
            </b-table-column>
            <b-table-column label="Тип оплаты" field="payment_type" sortable v-slot="props">
                {{ props.row.payment_type }}
            </b-table-column>
            <b-table-column label="Время доставки" field="delivery_time" sortable v-slot="props">
                {{ props.row.delivery_time }}
            </b-table-column>
            <b-table-column label="Сумма оплаты" field="total_price" sortable v-slot="props">
                {{ props.row.total_price }}
            </b-table-column>
            <b-table-column label="Дата" field="date" sortable v-slot="props">
                {{ props.row.date }}
            </b-table-column>
            <b-table-column custom-key="actions" cell-class="is-actions-cell" v-slot="props">
                <div class="buttons is-right">
                    <router-link :to="{name:'orders.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                        <b-icon icon="pencil-box-outline" size="is-small"/>
                    </router-link>
                </div>
            </b-table-column>

            <section slot="empty" class="section">
                <div class="content has-text-grey has-text-centered">
                    <template v-if="isLoading">
                        <p>
                            <b-icon icon="dots-horizontal" size="is-large"/>
                        </p>
                        <p>Fetching data...</p>
                    </template>
                    <template v-else>
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"/>
                        </p>
                        <p>Nothing's here&hellip;</p>
                    </template>
                </div>
            </section>
        </b-table>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: 'StatisticsOrdersTable',
    data() {
        return {
            paginated: false,
        }
    },
    computed: {
        ...mapGetters({
            orders: 'getStatisticsOrders',
            isLoading: 'getIsLoading',
        })
    },
    watch: {
        orders(newValue) {
            this.orders = newValue;
        },
    },
}
</script>
