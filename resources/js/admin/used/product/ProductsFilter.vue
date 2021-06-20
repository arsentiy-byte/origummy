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
export default {
    name: "ProductsFilter",
    data() {
        return {
            title: '',
            status: true,
            isLoading: false,
        };
    },
    methods: {
        submit() {
            let params = {};

            if (this.title) {
                params.title = this.title;
            } else {
                params.status = this.status;
            }

            this.isLoading = true;
            this.$store.dispatch('getProductsByFilter', params);
            this.isLoading = false;
        },
    },
}
</script>

<style scoped>

</style>
