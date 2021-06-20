<template>
    <div>
        <title-bar :title-stack="['Admin', 'Акции']"/>
        <section class="section is-main-section">
            <card-component title="Фильтрация" class="has-table has-mobile-sort-spaced">
                <promotions-filter/>
            </card-component>
            <div class="buttons is-right">
                <router-link :to="{name:'promotions.create'}"
                             class="button is-primary">
                    Создать новую
                </router-link>
            </div>
            <promotions-table/>
        </section>
    </div>
</template>

<script>
import TitleBar from "../../components/TitleBar";
import CardComponent from "../../components/CardComponent";
import PromotionsTable from "../../used/promotion/PromotionsTable";
import PromotionsFilter from "../../used/promotion/PromotionsFilter";

export default {
    name: "Promotions",
    components: {
        TitleBar, PromotionsTable, PromotionsFilter, CardComponent
    },
    created() {
        this.$store.dispatch('getPromotions');
        this.$store.dispatch('getPromotionTypes');
    },
}
</script>

<style scoped>

</style>
