<template>
    <div>
        <title-bar :title-stack="['Admin', 'Категории']"/>
        <section class="section is-main-section">
            <card-component title="Фильтрация" class="has-table has-mobile-sort-spaced">
                <categories-filter/>
            </card-component>
            <div class="buttons is-right">
                <router-link :to="{name:'categories.create'}"
                             class="button is-primary">
                    Создать новую
                </router-link>
            </div>
            <categories-table/>
        </section>
    </div>
</template>

<script>
import TitleBar from "../../components/TitleBar";
import CategoriesTable from "../../used/category/CategoriesTable";
import CategoriesFilter from "../../used/category/CategoriesFilter";
import CardComponent from "../../components/CardComponent";

export default {
    name: "Categories",
    components: {
        TitleBar, CategoriesTable, CategoriesFilter, CardComponent
    },
    created() {
        this.$store.dispatch('getCategories');
    },
}
</script>

<style scoped>

</style>
