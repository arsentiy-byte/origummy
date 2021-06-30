<template>
    <div>
        <title-bar :title-stack="['Admin', 'Товар']"/>
        <card-component title="Редактирование товара" icon="package">
            <form @submit.prevent="submit" v-if="product">
                <div style="max-width: 40%">
                    <b-field label="Название">
                        <b-input v-model="product.title" name="title" required/>
                    </b-field>
                    <b-field label="Описание">
                        <b-input maxlength="500" v-model="product.description" name="description"/>
                    </b-field>
                    <b-field label="Цена">
                        <b-input v-model="product.price" name="price" type="number" required/>
                    </b-field>
                    <b-field label="Кол-во">
                        <b-input v-model="product.count" name="count" type="number"/>
                    </b-field>
                    <b-field label="Категория" class="mt-3">
                        <b-select placeholder="Выберите категорию" v-model="product.category_id" required>
                            <option
                                v-for="category in categories"
                                :value="category.id"
                                :key="category.id">
                                {{ category.title }}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Акция" class="mt-3">
                        <b-select placeholder="Выберите акцию" v-model="promotionId">
                            <option :value="null">
                                Выберите акцию
                            </option>
                            <option
                                v-for="item in promotions"
                                :value="item.id"
                                :key="item.id">
                                {{ item.title }}
                            </option>
                        </b-select>
                    </b-field>
                    <b-field label="Старая цена по скидке" v-if="promotion && promotion.type.name === 'discount'">
                        <b-input v-model="product.old_price" name="old_price" type="number"/>
                    </b-field>
                    <b-field label="Товары в подарок" v-if="promotion && promotion.type.name === 'gift'">
                        <ul>
                            <li v-for="product in promotion.related_products">
                                {{ product.title }}
                            </li>
                        </ul>
                    </b-field>
                    <b-field label="Состав, содержит:">
                        <b-taginput
                            v-model="product.related_products"
                            :data="productsSearchData"
                            autocomplete
                            :allow-new="false"
                            :open-on-focus="false"
                            field="title"
                            icon="label"
                            placeholder="Добавить товар"
                            :before-adding="beforeAdding"
                            @remove="beforeDelete"
                            @typing="searchProducts">
                        </b-taginput>
                    </b-field>
                    <b-field label="Активный" style="margin-right: 20px;">
                        <b-switch v-model="product.status">
                            {{ product.status ? 'Да' : 'Нет' }}
                        </b-switch>
                    </b-field>
                </div>
                <b-field label="Изображения" class="mt-4">
                    <b-upload v-model="images"
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
                    <div v-for="(image, index) in product.images"
                         :key="index"
                         class="tag is-primary" style="width: 300px; display:flex; flex-direction: column; height: auto;">
                        <div>
                            {{ image.path }}
                            <button class="delete is-small"
                                    type="button"
                                    @click="addToDeleteImages(image.path, index)">
                            </button>
                        </div>
                        <div>
                            <img :src="`/images/${image.path}`" alt="" style="max-width: 100%">
                        </div>
                    </div>
                    <div v-for="(file, index) in images"
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
import TitleBar from "../../components/TitleBar";
import CardComponent from "../../components/CardComponent";
import axiosRateLimit from "axios-rate-limit";
import {mapGetters} from 'vuex';

export default {
    name: "Product",
    props: [
        'id'
    ],
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            product: null,
            productsSearchData: [],
            deleteImages: [],
            images: [],
            deletePromotions: [],
            deleteRelatedProducts: [],
            activeTab: 0,
            promotion: null,
            promotionId: null,
            oldRelatedProducts: [],
        };
    },
    created() {
        this.$store.dispatch('getAllCategories');
        this.$store.dispatch('getAllPromotions');
        this.getProduct(this.id);
    },
    watch: {
        id (newValue) {
            this.getProduct(newValue);
        },
        product(newValue) {
            if (newValue.promotions.length > 0) {
                this.promotionId = newValue.promotions[0].id;
            }

            this.oldRelatedProducts = newValue.related_products;
        },
        promotionId(newValue) {
            if (this.product.promotions.length > 0) {
                this.deletePromotions = [];

                if (newValue !== this.product.promotions[0].id) {
                    this.deletePromotions.push(this.product.promotions[0].id);
                }
            }

            this.promotion = this.promotions.find((item) => {
                return item.id === newValue;
            });
        },
    },
    computed: {
        ...mapGetters({
            isLoading: 'getIsLoading',
            categories: 'getCategories',
            promotions: 'getPromotions',
        }),
    },
    methods: {
        getImageObjectUrl(image) {
            return URL.createObjectURL(image);
        },
        getProduct(id) {
            this.$store.commit('SET_IS_LOADING', true);
            axios.get('origummy/api/v1/products/' + id)
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.product = response.data.data;

                        this.$buefy.notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        });
                        this.$store.commit('SET_IS_LOADING', false);
                    }

                    if (response.data.status !== 'success') {
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                        this.$store.commit('SET_IS_LOADING', false);
                    }
                })
                .catch((error) => {
                    this.$buefy.toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                    this.$store.commit('SET_IS_LOADING', false);
                })
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
        deleteDropFile(index) {
            this.images.splice(index, 1);
        },
        addToDeleteImages(path, index) {
            this.product.images.splice(index, 1);
            this.deleteImages.push(path);
        },
        beforeAdding(item) {
            return !this.product.related_products.some((product) => {
                return item.id === product.id;
            });
        },
        beforeDelete(product) {
            if (this.oldRelatedProducts.find((item) => {
                return item.id === product.id;
            })) {
                if (!this.deleteRelatedProducts.includes(product.id)) {
                    this.deleteRelatedProducts.push(product.id);
                }
            }
        },
        submit() {
            if (this.product.title
                && this.product.price
                && this.product.category_id
                && (this.product.images.length > 0 || this.images.length > 0)
            ) {
                this.$store.commit('SET_IS_LOADING', true);
                let formData = new FormData();

                this.images.forEach((item) => {
                    formData.append('images[]', item);
                });

                formData.append('title', this.product.title);
                formData.append('description', this.product.description);
                formData.append('status', this.product.status ? '1' : '0');
                formData.append('price', this.product.price);
                formData.append('count', this.product.count);
                formData.append('category_id', this.product.category_id);

                if (this.promotion && !this.deletePromotions.includes(this.promotion.id)) {
                    formData.append('promotions[]', this.promotion.id);

                    if (this.promotion.type.name === 'discount') {
                        formData.append('old_price', this.product.old_price);
                    }
                }

                if (this.product.related_products.length > 0) {
                    this.product.related_products.forEach((item) => {
                        if (!this.oldRelatedProducts.find((oldItem) => {
                            return item.id === oldItem.id
                        })) {
                            formData.append('related_products[]', item.id);
                        }
                    });
                }

                if (this.deleteRelatedProducts.length > 0) {
                    this.deleteRelatedProducts.forEach((item) => {
                        formData.append('delete_related_products[]', item);
                    });
                }

                if (this.deletePromotions.length > 0) {
                    this.deletePromotions.forEach((item) => {
                        formData.append('delete_promotions[]', item);
                    });
                }

                if (this.deleteImages.length > 0) {
                    this.deleteImages.forEach((item) => {
                        formData.append('delete_images[]', item);
                    });
                }

                formData.append('_method', 'put');

                axios.post('origummy/api/v1/products/' + this.id, formData, {
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
    },
}
</script>

<style scoped>

</style>
