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
                <b-switch v-model="isDefault">
                    По умолчанию
                </b-switch>
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

import {mapGetters} from "vuex";

export default {
    name: "CategoriesFilter",
    data() {
        return {
            title: '',
            status: true,
            isDefault: false,
        };
    },
    computed: {
        ...mapGetters({
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
                params.is_default = this.isDefault;
            }

            this.$store.dispatch('getCategoriesByFilter', params);
        },
    },
}
</script>

<style scoped>

</style>
