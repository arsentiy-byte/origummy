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
export default {
    name: "CategoriesFilter",
    data() {
        return {
            title: '',
            status: true,
            isDefault: false,
            isLoading: false,
        };
    },
    methods: {
        submit() {
            let params = {
                status: this.status,
                is_default: this.isDefault,
            };

            if (this.title) {
                params.title = this.title;
            }

            this.isLoading = true;
            this.$store.dispatch('getCategoriesByFilter', params);
            this.isLoading = false;
        },
    },
}
</script>

<style scoped>

</style>
