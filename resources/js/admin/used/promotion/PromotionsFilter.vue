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
            <b-field label="Тип" class="mt-5">
                <b-select placeholder="Выберите тип" v-model="type_id">
                    <option :value="null">
                        Выберите тип
                    </option>
                    <option
                        v-for="type in types"
                        :value="type.id"
                        :key="type.id">
                        {{ type.display_name }}
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
    name: "PromotionsFilter",
    data() {
        return {
            title: '',
            status: true,
            type_id: null,
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
        }
    },
    methods: {
        submit() {
            let params = {};

            if (this.title) {
                params.title = this.title;
            } else {
                params.status = this.status;
            }

            if (this.type_id) {
                params.type_id = this.type_id;
            }

            this.$store.dispatch('getPromotionsByFilter', params);
            this.$store.dispatch('getPromotionTypes');
        },
    },
}
</script>

<style scoped>

</style>
