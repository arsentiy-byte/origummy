<template>
    <div>
        <title-bar :title-stack="['Admin', 'Категория']"/>
        <card-component title="Создание новой категорий" icon="alphabetical-variant">
            <form @submit.prevent="submit">
                <div style="max-width: 40%">
                    <div class="tag is-primary is-medium" v-if="form.image">
                        {{ form.image.name }}
                        <button class="delete is-small"
                                type="button"
                                @click="form.image = null">
                        </button>
                    </div>
                    <img :src="getImageObjectUrl(form.image)" alt="" v-if="form.image"/>
                    <b-field label="Изображение">
                        <b-upload v-model="form.image" drag-drop class="file-label" required>
                            <span class="file-cta">
                                <b-icon class="file-icon" icon="upload"></b-icon>
                                <span class="file-label">Загрузить изображение</span>
                            </span>
                        </b-upload>
                    </b-field>
                    <b-field label="Название">
                        <b-input v-model="form.title" name="title" required/>
                    </b-field>
                    <b-field label="Описание">
                        <b-input maxlength="500" v-model="form.description" name="description"/>
                    </b-field>
                    <b-field grouped group-multiline>
                        <b-field label="Активный" style="margin-right: 20px;">
                            <b-switch v-model="form.status">
                                {{ form.status ? 'Да' : 'Нет' }}
                            </b-switch>
                        </b-field>
                        <b-field label="По умолчанию">
                            <b-switch v-model="form.is_default">
                                {{ form.is_default ? 'Да' : 'Нет' }}
                            </b-switch>
                        </b-field>
                    </b-field>
                    <b-field label="Родитель" style="margin-top: 25px;">
                        <div style="margin-right: 30px;">
                            <div v-if="form.parent_id">
                                <b>{{ searchField }}</b>
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
                            @select="option => form.parent_id = option.id">
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
            </form>
        </card-component>
    </div>
</template>

<script>
import axiosRateLimit from "axios-rate-limit";
import CardComponent from "../../components/CardComponent";
import TitleBar from "../../components/TitleBar";

export default {
    name: "NewCategory",
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            form: {
                image: null,
                title: '',
                description: '',
                status: true,
                is_default: false,
                parent_id: '',
            },
            searchField: '',
            isLoading: false,
            categoriesSearchData: [],
        };
    },
    computed: {
        categoriesFilteredData() {
            return this.categoriesSearchData.filter(option => {
                return (
                    option.title
                        .toString()
                        .toLowerCase()
                        .indexOf(this.searchField.toLowerCase()) >= 0
                )
            });
        },
    },
    watch: {
        searchField(newValue, oldValue) {
            if (newValue.length >= 3 && newValue !== oldValue) {
                this.searchCategories();
            }
        },
    },
    methods: {
        getImageObjectUrl(image) {
            return URL.createObjectURL(image);
        },
        submit() {
            if (this.form.title && this.form.image) {
                this.isLoading = true;
                let formData = new FormData();

                if (this.form.image) {
                    formData.append('images[]', this.form.image);
                }

                formData.append('title', this.form.title);
                formData.append('description', this.form.description);
                formData.append('status', this.form.status ? '1' : '0');
                formData.append('is_default', this.form.is_default ? '1' : '0');

                if (this.form.parent_id) {
                    formData.append('parent_id', this.form.parent_id);
                }

                axios.post('origummy/api/v1/categories', formData, {
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
                            this.$router.push({name: 'categories'});
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
            }
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
