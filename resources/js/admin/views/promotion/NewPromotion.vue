<template>
    <div>
        <title-bar :title-stack="['Admin', 'Акция']"/>
        <card-component title="Создание новой акций" icon="alphabetical-variant">
            <form @submit.prevent="submit">
                <div style="max-width: 40%">
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
                    </b-field>
                    <b-field label="Тип" class="mt-3">
                        <b-select placeholder="Выберите тип" v-model="form.type" required>
                            <option :value="null">
                                Выберите тип
                            </option>
                            <option
                                v-for="type in types"
                                :value="type"
                                :key="type.id">
                                {{ type.display_name }}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Товары в подарок" v-if="form.type && form.type.name === 'gift'" :message="relatedProductsEmptyMessage">
                        <b-taginput
                            v-model="form.relatedProducts"
                            :data="productsSearchData"
                            autocomplete
                            :allow-new="false"
                            :open-on-focus="false"
                            field="title"
                            icon="label"
                            placeholder="Добавить товар"
                            :before-adding="beforeAdding"
                            @typing="searchProducts">
                        </b-taginput>
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
import CardComponent from "../../components/CardComponent";
import TitleBar from "../../components/TitleBar";
import {mapGetters} from 'vuex';
import axiosRateLimit from "axios-rate-limit";

export default {
    name: "NewPromotion",
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            form: {
                title: '',
                description: '',
                status: true,
                type: null,
                relatedProducts: [],
            },
            relatedProductsEmptyMessage: '',
            productsSearchData: [],
        };
    },
    computed: {
        ...mapGetters({
            types: 'getPromotionTypes',
            isLoading: 'getIsLoading',
        }),
    },
    watch: {
        types(newValue) {
            this.types = newValue;
        },
        productsSearchData(newValue) {
            this.productsSearchData = newValue;
        },
    },
    created() {
        this.$store.dispatch('getPromotionTypes');
    },
    methods: {
        submit() {
            if (this.form.title && this.form.type) {
                this.$store.commit('SET_IS_LOADING', true);
                let formData = new FormData();

                formData.append('title', this.form.title);
                formData.append('description', this.form.description);
                formData.append('status', this.form.status ? '1' : '0');
                formData.append('type_id', this.form.type.id);

                if (this.form.type.name === 'gift') {

                    if (this.form.relatedProducts.length === 0) {
                        this.relatedProductsEmptyMessage = 'Заполните список!';
                        this.$store.commit('SET_IS_LOADING', false);
                        return;
                    }

                    this.form.relatedProducts.forEach(item => {
                        formData.append('related_products[]', item.id);
                    })
                }

                axios.post('origummy/api/v1/promotions', formData, {
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
                            this.$router.push({name: 'promotions'});
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
        searchProducts(text) {
            const http = axiosRateLimit(axios.create(), {
                maxRequests: 1, perMilliseconds: 2000
            })
            http.get('origummy/api/v1/products/search', {
                params: {
                    search: text
                },
            })
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.productsSearchData = response.data.data.filter(option => {
                            return (
                                option.title
                                    .toString()
                                    .toLowerCase()
                                    .indexOf(text.toLowerCase()) >= 0
                            )
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
        beforeAdding(item) {
            return !this.form.relatedProducts.some((product) => {
                return item.id === product.id;
            });
        },
    },
}
</script>

<style scoped>

</style>
