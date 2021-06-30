<template>
    <div>
        <title-bar :title-stack="['Admin', 'Категория #' + this.id]"/>
        <div class="buttons is-left ml-5 mt-2">
            <router-link :to="{name: 'categories'}"
                         class="button">
                Назад в Категории
            </router-link>
        </div>
        <card-component title="Редактирование категорий" icon="alphabetical-variant">
            <form v-if="category" @submit.prevent="submit" style="display:flex; justify-content: space-between;">
                <div style="max-width: 50%; width: 100%;">
                    <div class="tag is-primary is-medium" v-if="file">
                        {{ file.name }}
                        <button class="delete is-small"
                                type="button"
                                @click="file = null">
                        </button>
                    </div>
                    <img :src="getImageObjectUrl(file)" alt="" v-if="file"/>
                    <img :src="`/images/${category.images[0].path}`" alt="" v-else/>
                    <b-field label="Изображение">
                        <b-upload v-model="file" drag-drop class="file-label">
                            <span class="file-cta">
                                <b-icon class="file-icon" icon="upload"></b-icon>
                                <span class="file-label">Загрузить изображение</span>
                            </span>
                        </b-upload>
                    </b-field>
                    <b-field label="Название">
                        <b-input v-model="category.title" name="title" required/>
                    </b-field>
                    <b-field label="Описание">
                        <b-input maxlength="500" v-model="category.description" name="description"/>
                    </b-field>
                    <b-field grouped group-multiline>
                        <b-field label="Активный" style="margin-right: 20px;">
                            <b-switch v-model="category.status">
                                {{ category.status ? 'Да' : 'Нет' }}
                            </b-switch>
                        </b-field>
                        <b-field label="По умолчанию">
                            <b-switch v-model="category.is_default">
                                {{ category.is_default ? 'Да' : 'Нет' }}
                            </b-switch>
                        </b-field>
                    </b-field>
                    <b-field label="Родитель" style="margin-top: 25px;">
                        <div style="margin-right: 30px;">
                            <div v-if="selectedParentId">
                                <b>{{ searchField }}</b>
                            </div>
                            <div v-else-if="category.parent">
                                <b>{{ category.parent.title }}</b>
                            </div>
                        </div>
                        <b-autocomplete
                            rounded
                            :data="categoriesFilteredData"
                            v-model="searchField"
                            placeholder="Название категории"
                            icon="magnify"
                            field="title"
                            clearable
                            @select="option => selectedParentId = option.id">
                            <template #empty>No results found</template>
                        </b-autocomplete>
                    </b-field>
                    <b-field>
                        <div class="control">
                            <button type="submit" class="button is-primary" :class="{'is-loading':isLoading}">
                                Сохранить
                            </button>
                        </div>
                    </b-field>
                </div>
                <b-tabs v-model="activeTab" style="max-width: 50%; width: 100%;">
                    <b-tab-item label="Подкатегории">
                        <ul style="margin-left: 30px; margin-top: 20px;">
                            <li v-for="child in category.children">
                                <router-link :to="{name:'categories.edit', params: {id: child.id}}">
                                    #{{ child.id }} {{ child.title }}
                                </router-link>
                            </li>
                        </ul>
                    </b-tab-item>
                    <b-tab-item label="Товары">
                        <ul style="margin-left: 30px; margin-top: 20px;">
                            <li v-for="product in category.products">
                                <router-link :to="{name: 'products.edit', params: {id: product.id}}">
                                    #{{ product.id }} {{ product.title }}
                                </router-link>
                            </li>
                        </ul>
                    </b-tab-item>
                </b-tabs>
            </form>
        </card-component>
    </div>
</template>

<script>
import TitleBar from "../../components/TitleBar";
import CardComponent from "../../components/CardComponent";
import axiosRateLimit from "axios-rate-limit";
import {mapGetters} from 'vuex';

export default {
    name: "Category",
    props: [
        'id'
    ],
    components: {
        TitleBar, CardComponent
    },
    data() {
        return {
            category: null,
            categoriesSearchData: [],
            searchField: '',
            file: null,
            deleteImages: [],
            selectedParentId: '',
            activeTab: 0,
        };
    },
    created() {
        this.getCategory(this.id);
    },
    watch: {
        id (newValue) {
            this.getCategory(newValue);
        },
        category(newValue) {
            this.category = newValue;
        },
        searchField(newValue, oldValue) {
            if (newValue.length >= 3 && newValue !== oldValue) {
                this.searchCategories();
            }
        },
        file(newValue) {
            if (newValue) {
                this.deleteImages.push(this.category.images[0].path);
            } else {
                this.deleteImages = [];
            }
        },
    },
    computed: {
        ...mapGetters({
           isLoading: 'getIsLoading',
        }),
        categoriesFilteredData() {
            return this.categoriesSearchData.filter(option => {
                return (
                    option.title
                        .toString()
                        .toLowerCase()
                        .indexOf(this.searchField.toLowerCase()) >= 0 && this.category.id !== option.id
                )
            });
        },
    },
    methods: {
        getImageObjectUrl(image) {
            return URL.createObjectURL(image);
        },
        submit() {
            if (this.category.title && (this.file || this.deleteImages.length === 0)) {
                this.$store.commit('SET_IS_LOADING', false);
                let formData = new FormData();

                if (this.file) {
                    formData.append('images[]', this.file);
                }

                formData.append('title', this.category.title);
                formData.append('description', this.category.description);
                formData.append('status', this.category.status ? '1' : '0');
                formData.append('is_default', this.category.is_default ? '1' : '0');

                if (this.selectedParentId) {
                    formData.append('parent_id', this.selectedParentId);
                }

                formData.append('_method', 'put');

                this.deleteImages.forEach((item) => {
                    formData.append('delete_images[]', item);
                });

                axios.post('origummy/api/v1/categories/' + this.id, formData, {
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
            }
        },
        getCategory(id) {
            axios.get('origummy/api/v1/categories/' + id)
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.category = response.data.data;
                        this.$buefy.notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        });
                    }

                    if (response.data.status !== 'success') {
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
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
        searchCategories() {
            const http = axiosRateLimit(axios.create(), {
                maxRequests: 1, perMilliseconds: 2000
            })
            http.get('origummy/api/v1/categories/search', {
                params: {
                    search: this.searchField
                },
            })
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.categoriesSearchData = response.data.data;
                    }

                    if (response.data.status !== 'success') {
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
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
}
</script>

<style scoped>

</style>
