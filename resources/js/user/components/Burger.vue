<template>
    <div class="burger-modal">
        <div class="top">
            <div class="burger-wrapper">
                <div class="burger active" @click="closeBurger">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
            <div class="menu-list">
                <a href="/" class="item">
                    <img src="/images/home.svg" alt="">
                    <span>Главная</span>
                </a>
                <a href="/" class="item">
                    <img src="/images/kitchen.svg" alt="">
                    <span>Меню</span>
                </a>
                <a href="/" class="item">
                    <img src="/images/envelope.svg" alt="">
                    <span>Подарки и акции</span>
                </a>
                <a href="/" class="item">
                    <img src="/images/bag.svg" alt="">
                    <span>Мои заказы</span>
                </a>
                <a href="/" class="item">
                    <img src="/images/info.svg" alt="">
                    <span>О компании</span>
                </a>
                <a href="/" class="item">
                    <img src="/images/comment.svg" alt="">
                    <span>Оставить отзыв</span>
                </a>
            </div>
        </div>
        <div class="links">
            <div class="phone">
                <a href="tel:+77787478866" class="phone">
                    <span>+7(778)-747-88-66</span>
                    <span>Позвонить</span>
                </a>
            </div>
            <div class="social">
                <a href="#"><img src="/images/insta.svg" alt="instagram"></a>
                <a href="#"><img src="/images/whatsapp.svg" alt="instagram"></a>
                <a href="#"><img src="/images/telegram.svg" alt="instagram"></a>
            </div>
            <span class="burger-footer">@origummy.kz - Sushi & Pizza</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Burger",
    methods: {
        closeBurger() {
            document.querySelector('.burger-modal').classList.remove('active');
            document.querySelector('.bg-over').classList.remove('active');
        },
    },
}
</script>

<style scoped>

</style>
