<template>
    <div :class="show ? 'custom-modal active' : 'custom-modal'" v-show="show">
        <div class="modal-header">
            <div class="back" @click="$emit('close')">
                <img src="/images/back.svg" alt="">
            </div>
            <div class="burger" @click="openBurger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
        <div class="modal-body">
            <slot name="body"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['show'],
    name: "Modal",
    methods: {
        openBurger() {
            document.querySelector('.burger-modal').classList.add('active');
            document.querySelector('.bg-over').classList.add('active');
        },
    },
    emits: ['close'],
}
</script>

<style scoped>

</style>
