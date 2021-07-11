<template>
    <div>
        <delete-modal
            :is-active="isDeleteModalActive"
            :trash-object-name="trashPromotionName"
            @confirm="deletePromotion(trashPromotionId)"
            @cancel="closeModal"
        />
        <b-table
            :checked-rows.sync="checkedRows"
            :loading="isLoading"
            :striped="true"
            :hoverable="true"
            default-sort="name"
            :data="promotions">

            <b-table-column label="ID" field="id" sortable v-slot="props">
                {{ props.row.id }}
            </b-table-column>
            <b-table-column label="Название" field="title" sortable v-slot="props">
                {{ props.row.title }}
            </b-table-column>
            <b-table-column label="Тип" field="slug" sortable v-slot="props">
                {{ props.row.type.display_name }}
            </b-table-column>
            <b-table-column label="Активный" field="status" v-slot="props">
                <b-switch v-model="props.row.status" @change.native="changeStatus(props.row.id, props.row.status)">
                    {{ props.row.status ? 'Да' : 'Нет' }}
                </b-switch>
            </b-table-column>
            <b-table-column custom-key="actions" cell-class="is-actions-cell" v-slot="props">
                <div class="buttons is-right">
                    <router-link :to="{name:'promotions.edit', params: {id: props.row.id}}"
                                 class="button is-small is-primary">
                        <b-icon icon="pencil-box-outline" size="is-default"/>
                    </router-link>
                    <button class="button is-small is-danger" @click="openModal(props.row.id, props.row.title)">
                        <b-icon icon="delete" size="is-default"/>
                    </button>
                </div>
            </b-table-column>

            <section slot="empty" class="section">
                <div class="content has-text-grey has-text-centered">
                    <template v-if="isLoading">
                        <p>
                            <b-icon icon="dots-horizontal" size="is-large"/>
                        </p>
                        <p>Загрузка данных...</p>
                    </template>
                    <template v-else>
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"/>
                        </p>
                        <p>Таблица пустая...</p>
                    </template>
                </div>
            </section>
        </b-table>
        <b-pagination
            :total="pagination.total_items"
            v-model="currentPage"
            :per-page="pagination.limit"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
        >
        </b-pagination>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import DeleteModal from "../DeleteModal";

export default {
    name: "PromotionsTable",
    data() {
        return {
            checkedRows: [],
            currentPage: 1,
            trashPromotionName: '',
            trashPromotionId: null,
            isDeleteModalActive: false,
        };
    },
    components: {
        DeleteModal,
    },
    computed: {
        ...mapGetters({
            promotions: 'getPromotions',
            types: 'getPromotionTypes',
            pagination: 'getPagination',
            isLoading: 'getIsLoading',
        })
    },
    watch: {
        promotions(newValue) {
            this.promotions = newValue;
        },
        types(newValue) {
            this.types = newValue;
        },
        pagination(newValue) {
            this.currentPage = newValue.current_page;
        },
        currentPage(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.getPromotionsWithPagination(newValue);
            }
        },
        isDeleteModalActive(newValue) {
            if (!newValue) {
                this.trashPromotionId = null;
                this.trashPromotionName = '';
            }
        }
    },
    methods: {
        getPromotionsWithPagination(page) {
            this.$store.dispatch('getPromotions', page);
        },
        openModal(id, name) {
            this.trashPromotionName = name;
            this.trashPromotionId = id;
            this.isDeleteModalActive = true;
        },
        closeModal() {
            this.trashPromotionName = '';
            this.trashPromotionId = null;
            this.isDeleteModalActive = false;
        },
        deletePromotion() {
            if (this.trashPromotionId) {
                this.$store.commit('SET_IS_LOADING', true);
                axios.delete('/origummy/api/v1/promotions/' + this.trashPromotionId)
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$store.commit('SET_IS_LOADING', false);
                            this.$buefy.notification.open({
                                message: response.data.message,
                                type: 'is-success'
                            });
                            this.$store.dispatch('getPromotions');
                            this.$store.dispatch('getPromotionTypes');
                        }

                        if (response.data.status !== 'success') {
                            this.$store.commit('SET_IS_LOADING', false);
                            this.$buefy.toast.open({
                                message: `Error: #${response.data.error_code} ${response.data.message}`,
                                type: 'is-danger',
                                queue: false
                            })
                        }
                    })
                    .catch((error) => {
                        this.$store.commit('SET_IS_LOADING', false);
                        this.$buefy.toast.open({
                            message: `Error: ${error.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    })
                this.closeModal();
            }
        },
        changeStatus(id, value) {
            let formData = new FormData();
            formData.append('status', value ? 1 : 0);
            this.updatePromotion(id, formData);
        },
        updatePromotion(id, formData) {
            this.$store.commit('SET_IS_LOADING', true);
            formData.append('_method', 'put');
            axios.post('/origummy/api/v1/promotions/' + id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    if (response.data.status === 'success') {
                        this.$store.commit('SET_IS_LOADING', false);
                        this.$buefy.notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        });
                    }

                    if (response.data.status !== 'success') {
                        this.$store.commit('SET_IS_LOADING', false);
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    this.$store.commit('SET_IS_LOADING', false);
                    this.$buefy.toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
    },
}
</script>

<style scoped>

</style>
