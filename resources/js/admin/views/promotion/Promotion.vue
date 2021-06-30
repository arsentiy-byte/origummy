<template>
    <div>
        <title-bar :title-stack="['Admin', 'Акция #' + this.id]"/>
        <div class="buttons is-left ml-5 mt-2">
            <router-link :to="{name: 'promotions'}"
                         class="button">
                Назад в Акции
            </router-link>
        </div>
        <card-component title="Редактирование акций" icon="alphabetical-variant">
            <form @submit.prevent="submit">
                <div style="max-width: 40%">
                    <b-field label="Название">
                        <b-input v-model="promotion.title" name="title" required/>
                    </b-field>
                    <b-field label="Описание">
                        <b-input maxlength="500" v-model="promotion.description" name="description"/>
                    </b-field>
                    <b-field grouped group-multiline>
                        <b-field label="Активный" style="margin-right: 20px;">
                            <b-switch v-model="promotion.status">
                                {{ promotion.status ? 'Да' : 'Нет' }}
                            </b-switch>
                        </b-field>
                    </b-field>
                    <b-field label="Тип" class="mt-3">
                        <b-select placeholder="Выберите тип" v-model="promotion.type" required>
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
                    <b-field label="Товары в подарок" v-if="promotion.type && promotion.type.name === 'gift'"
                             :message="relatedProductsEmptyMessage">
                        <b-taginput
                            v-model="promotion.related_products"
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
    props: [
        'id'
    ],
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            promotion: {
                title: '',
                description: '',
                status: true,
                type: null,
                related_products: [],
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
        id(newValue) {
            this.getPromotion(newValue);
        },
        promotion(newValue) {
            this.promotion = newValue;
        },
        types(newValue) {
            this.types = newValue;
        },
        productsSearchData(newValue) {
            this.productsSearchData = newValue;
        },
    },
    created() {
        this.$store.dispatch('getPromotionTypes');
        this.getPromotion(this.id);
    },
    methods: {
        submit() {
            if (this.promotion.title && this.promotion.type) {
                this.$store.commit('SET_IS_LOADING', true);
                let formData = new FormData();

                formData.append('title', this.promotion.title);
                formData.append('description', this.promotion.description);
                formData.append('status', this.promotion.status ? '1' : '0');
                formData.append('type_id', this.promotion.type.id);

                if (this.promotion.type.name === 'gift') {

                    if (this.promotion.related_products.length === 0) {
                        this.relatedProductsEmptyMessage = 'Заполните список!';
                        this.$store.commit('SET_IS_LOADING', false);
                        return;
                    }

                    this.promotion.related_products.forEach(item => {
                        formData.append('related_products[]', item.id);
                    })
                }

                formData.append('_method', 'put');

                axios.post('origummy/api/v1/promotions/' + this.id, formData, {
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
            return !this.promotion.related_products.some((product) => {
                return item.id === product.id;
            });
        },
        getPromotion(id) {
            axios.get('origummy/api/v1/promotions/' + id)
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.promotion = response.data.data;
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
    },
}
</script>

<style scoped>

</style>
