<template>
    <div>
        <title-bar :title-stack="['Admin', 'Товар']"/>
        <card-component title="Создание нового товара" icon="package">
            <form @submit.prevent="submit">
                <div style="max-width: 40%">
                    <b-field label="Название">
                        <b-input v-model="form.title" name="title" required/>
                    </b-field>
                    <b-field label="Описание">
                        <b-input maxlength="500" v-model="form.description" name="description"/>
                    </b-field>
                    <b-field label="Цена">
                        <b-input v-model="form.price" name="price" type="number" required/>
                    </b-field>
                    <b-field label="Кол-во">
                        <b-input v-model="form.count" name="count" type="number"/>
                    </b-field>
                    <b-field label="Категория" class="mt-3">
                        <b-select placeholder="Выберите категорию" v-model="form.category_id" required>
                            <option
                                v-for="category in categories"
                                :value="category.id"
                                :key="category.id">
                                {{ category.title }}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Акция" class="mt-3">
                        <b-select placeholder="Выберите акцию" v-model="form.promotion">
                            <option :value="null">
                                Выберите акцию
                            </option>
                            <option
                                v-for="promotion in promotions"
                                :value="promotion"
                                :key="promotion.id">
                                {{ promotion.title }}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Старая цена по скидке" v-if="form.promotion && form.promotion.type.name === 'discount'">
                        <b-input v-model="form.old_price" name="old_price" type="number"/>
                    </b-field>
                    <b-field label="Товары в подарок" v-if="form.promotion && form.promotion.type.name === 'gift'">
                        <ul>
                            <li v-for="product in form.promotion.related_products">
                                {{ product.title }}
                            </li>
                        </ul>
                    </b-field>
                    <b-field label="Состав, содержит:">
                        <b-taginput
                            v-model="form.related_products"
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
                    <b-field label="Активный" style="margin-right: 20px;">
                        <b-switch v-model="form.status">
                            {{ form.status ? 'Да' : 'Нет' }}
                        </b-switch>
                    </b-field>
                </div>
                <b-field label="Изображения" class="mt-4">
                    <b-upload v-model="form.images"
                              required
                              multiple
                              drag-drop>
                        <section class="section">
                            <div class="content has-text-centered">
                                <p>
                                    <b-icon
                                        icon="upload"
                                        size="is-large">
                                    </b-icon>
                                </p>
                                <p>Drop your files here or click to upload</p>
                            </div>
                        </section>
                    </b-upload>
                </b-field>
                <div class="tags">
                    <div v-for="(file, index) in form.images"
                         :key="index"
                         class="tag is-primary" style="width: 300px; display:flex; flex-direction: column; height: auto;">
                        <div>
                            {{ file.name }}
                            <button class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)">
                            </button>
                        </div>
                        <div>
                            <img :src="getImageObjectUrl(file)" alt="" style="max-width: 100%">
                        </div>
                    </div>
                </div>
                <b-field>
                    <div class="control">
                        <button type="submit" class="button is-primary" :class="{'is-loading':isLoading}">
                            Сохранить
                        </button>
                    </div>
                </b-field>
            </form>
        </card-component>
    </div>
</template>

<script>
import axiosRateLimit from "axios-rate-limit";
import CardComponent from "../../components/CardComponent";
import TitleBar from "../../components/TitleBar";
import {mapGetters} from 'vuex';

export default {
    name: "NewProduct",
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            form: {
                title: '',
                description: '',
                status: true,
                price: 0,
                old_price: 0,
                count: 0,
                category_id: null,
                images: [],
                promotion: null,
                related_products: [],
            },
            productsSearchData: [],
        };
    },
    computed: {
        ...mapGetters({
            isLoading: 'getIsLoading',
            categories: 'getCategories',
            promotions: 'getPromotions',
        }),
    },
    created() {
        this.$store.dispatch('getAllCategories');
        this.$store.dispatch('getAllPromotions');
    },
    methods: {
        getImageObjectUrl(image) {
            return URL.createObjectURL(image);
        },
        searchProducts(text) {
            const http = axiosRateLimit(axios.create(), {
                maxRequests: 1, perMilliseconds: 2000,
            });
            http.get('origummy/api/v1/products/search', {
                params: {
                    search: text,
                },
            })
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.productsSearchData = response.data.data;
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
        submit() {
            if (this.form.title
                && this.form.price
                && this.form.category_id
                && this.form.images.length > 0
            ) {
                this.$store.commit('SET_IS_LOADING', true);
                let formData = new FormData();

                this.form.images.forEach((item) => {
                    formData.append('images[]', item);
                });

                formData.append('title', this.form.title);
                formData.append('description', this.form.description);
                formData.append('status', this.form.status ? '1' : '0');
                formData.append('price', this.form.price);
                formData.append('count', this.form.count);
                formData.append('category_id', this.form.category_id);

                if (this.form.promotion) {
                    formData.append('promotions[]', this.form.promotion.id);

                    if (this.form.promotion.type.name === 'discount') {
                        formData.append('old_price', this.form.old_price);
                    }
                }

                if (this.form.related_products.length > 0) {
                    this.form.related_products.forEach((item) => {
                        formData.append('related_products[]', item.id);
                    });
                }

                axios.post('origummy/api/v1/products', formData, {
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
                            this.$router.push({name: 'products'});
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
        deleteDropFile(index) {
            this.form.images.splice(index, 1);
        },
        beforeAdding(item) {
            return !this.form.related_products.some((product) => {
                return item.id === product.id;
            });
        },
    },
}
</script>

<style scoped>

</style>
