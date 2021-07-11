<template>
    <div style="margin: 25px;">
        <form @submit.prevent="submit">
            <b-field grouped group-multiline>
                <b-field horizontal label="Название">
                    <b-input v-model="title" name="title"/>
                </b-field>
                <b-switch v-model="status">
                    Активный
                </b-switch>
            </b-field>
            <b-field label="Категория" class="mt-5">
                <b-select placeholder="Выберите категорию" v-model="category_id">
                    <option
                        v-for="category in categories"
                        :value="category.id"
                        :key="category.id">
                        {{ category.title }}
                    </option>
                </b-select>
            </b-field>
            <hr>
            <b-field horizontal>
                <div class="control">
                    <button type="submit" class="button is-primary" :class="{'is-loading':isLoading}">
                        Искать
                    </button>
                </div>
            </b-field>
        </form>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "ProductsFilter",
    data() {
        return {
            title: '',
            status: true,
            category_id: null,
        };
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
            isLoading: 'getIsLoading',
        }),
    },
    methods: {
        submit() {
            let params = {};

            if (this.title) {
                params.title = this.title;
            } else {
                params.status = this.status;
            }

            if (this.category_id) {
                params.category_id = this.category_id;
            }

            this.$store.dispatch('getProductsByFilter', params);
        },
    },
}
</script>

<style scoped>

</style>
