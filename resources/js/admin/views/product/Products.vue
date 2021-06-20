<template>
    <div>
        <title-bar :title-stack="['Admin', 'Товары']"/>
        <section class="section is-main-section">
            <card-component title="Фильтрация" class="has-table has-mobile-sort-spaced">
                <products-filter/>
            </card-component>
<!--            <div class="buttons is-right">
                <router-link :to="{name:'categories.create'}"
                             class="button is-primary">
                    Создать новую
                </router-link>
            </div>-->
            <products-table/>
        </section>
    </div>
</template>

<script>
import TitleBar from "../../components/TitleBar";
import CardComponent from "../../components/CardComponent";
import ProductsTable from "../../used/product/ProductsTable";
import ProductsFilter from "../../used/product/ProductsFilter";

export default {
    name: "Products",
    components: {
        TitleBar, ProductsTable, ProductsFilter, CardComponent
    },
    created() {
        this.$store.dispatch('getProducts');
    },
}
</script>

<style scoped>

</style>
