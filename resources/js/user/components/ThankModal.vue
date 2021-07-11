<template>
    <div>
        <modal :show="isShow" @close="close" id="thank-modal" v-if="isShow">
            <template slot="body">
                <div class="thank">
                    <img src="/images/thank.svg" alt="">
                    <div class="title">Спасибо за заказ!</div>
                    <div class="info">Наш менеджер свяжется с вами в ближайшие минуты.</div>
                    <a href="/">Посмотреть мои заказы</a>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from "./Modal";
import {mapGetters} from 'vuex';

export default {
    name: "ThankModal",
    components: {
        Modal,
    },
    computed: {
        ...mapGetters({
            isShow: 'getThankModal',
        }),
    },
    methods: {
        close() {
            this.$store.commit('SET_THANK_MODAL', false);
        },
    },
    watch: {
        isShow(newValue) {
            this.isShow = newValue;
            this.$store.commit('MODAL_IS_OPENED', newValue);
        },
    },
}
</script>

<style scoped>

</style>
