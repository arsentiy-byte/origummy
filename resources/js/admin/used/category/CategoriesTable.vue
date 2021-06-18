<template>
    <div>
        <delete-modal
            :is-active="isDeleteModalActive"
            :trash-object-name="trashCategoryName"
            @confirm="deleteCategory(trashCategoryId)"
            @cancel="closeModal"
        />
        <b-table
            :checked-rows.sync="checkedRows"
            :loading="isLoading"
            :striped="true"
            :hoverable="true"
            default-sort="name"
            :data="categories">

            <b-table-column label="ID" field="id" sortable v-slot="props">
                {{ props.row.id }}
            </b-table-column>
            <b-table-column label="Название" field="title" sortable v-slot="props">
                {{ props.row.title }}
            </b-table-column>
            <b-table-column label="URL название" field="slug" sortable v-slot="props">
                {{ props.row.slug }}
            </b-table-column>
            <b-table-column label="Родитель" field="slug" sortable v-slot="props">
                <router-link :to="{name:'categories.edit', params: {id: props.row.parent.id}}" v-if="props.row.parent">
                    <b>{{ props.row.parent.title }}</b>
                </router-link>
            </b-table-column>
            <b-table-column label="По умолчанию" field="slug" v-slot="props">
                <b-switch v-model="props.row.is_default"
                          @change.native="changeIsDefault(props.row.id, props.row.is_default, props.row.title)">
                    {{ props.row.is_default ? 'Да' : 'Нет' }}
                </b-switch>
            </b-table-column>
            <b-table-column label="Активный" field="status" v-slot="props">
                <b-switch v-model="props.row.status" @change.native="changeStatus(props.row.id, props.row.status, props.row.title)">
                    {{ props.row.status ? 'Да' : 'Нет' }}
                </b-switch>
            </b-table-column>
            <b-table-column custom-key="actions" cell-class="is-actions-cell" v-slot="props">
                <div class="buttons is-right">
                    <router-link :to="{name:'categories.edit', params: {id: props.row.id}}"
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
    name: "CategoriesTable",
    data() {
        return {
            checkedRows: [],
            isLoading: false,
            currentPage: 1,
            trashCategoryName: '',
            trashCategoryId: '',
            isDeleteModalActive: false,
        };
    },
    components: {
        DeleteModal,
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
            pagination: 'getPagination',
        })
    },
    watch: {
        categories(newValue) {
            this.categories = newValue;
        },
        pagination(newValue) {
            this.currentPage = newValue.current_page;
        },
        currentPage(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.getCategoriesWithPagination(newValue);
            }
        },
        isDeleteModalActive(newValue) {
            if (!newValue) {
                this.trashCategoryId = null;
                this.trashCategoryName = '';
            }
        }
    },
    methods: {
        getCategoriesWithPagination(page) {
            this.$store.dispatch('getCategories', page);
        },
        openModal(id, name) {
            this.trashCategoryName = name;
            this.trashCategoryId = id;
            this.isDeleteModalActive = true;
        },
        closeModal() {
            this.trashCategoryName = '';
            this.trashCategoryId = null;
            this.isDeleteModalActive = false;
        },
        deleteCategory() {
            if (this.trashCategoryId) {
                axios.delete('origummy/api/v1/categories/' + this.trashCategoryId)
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.isLoading = false;
                            this.$buefy.notification.open({
                                message: response.data.message,
                                type: 'is-success'
                            });
                            this.$store.dispatch('getCategories');
                        }

                        if (response.data.status !== 'success') {
                            this.isLoading = false;
                            this.$buefy.toast.open({
                                message: `Error: #${response.data.error_code} ${response.data.message}`,
                                type: 'is-danger',
                                queue: false
                            })
                        }
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.$buefy.toast.open({
                            message: `Error: ${error.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    })
                this.closeModal();
            }
        },
        changeStatus(id, value, title) {
            let formData = new FormData();
            formData.append('title', title);
            formData.append('status', value ? 1 : 0);
            this.updateCategory(id, formData);
        },
        changeIsDefault(id, value, title) {
            let formData = new FormData();
            formData.append('title', title);
            formData.append('is_default', value ? 1 : 0);
            this.updateCategory(id, formData);
        },
        updateCategory(id, formData) {
            formData.append('_method', 'put');
            axios.post('origummy/api/v1/categories/' + id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    if (response.data.status === 'success') {
                        this.isLoading = false;
                        this.$buefy.notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        });
                        this.$store.dispatch('getCategories');
                    }

                    if (response.data.status !== 'success') {
                        this.isLoading = false;
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    this.isLoading = false;
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
