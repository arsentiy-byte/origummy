<template>
    <div>
        <modal :show="isShow" @close="close" id="order-modal" v-if="isShow">
            <template slot="body">
                <div class="order-title">Оформление заказа</div>
                <form action="#" @submit.prevent="submit" class="order-form">
                    <input required type="text" name="name" v-model="form.name" class="order-input" placeholder="Введите имя">
                    <input required type="text" name="address" v-model="form.address" class="order-input" placeholder="Адрес доставки">
                    <vue-phone-number-input v-model="form.phone"
                                            id="phone-number"
                                            default-contry-code="KZ"
                                            :only-countries="['KZ']"
                                            :no-country-selector="true"
                                            :show-code-on-list="true"
                                            :translations="{
                                                phoneNumberLabel: 'Номер телефона',
                                                example: 'Пример:',
                                            }"
                                            :border-radius="3"
                                            required
                    />
                    <label for="phone-number" class="phone-error" v-if="isPhoneError">Неправильный формат!</label>
                    <textarea name="add_info" rows="6" v-model="form.add_info" class="order-input input-area" placeholder="Дополнительная информация"></textarea>
                    <div class="delivery-time">
                        <span class="order-label">Время доставки</span>
                        <div class="order-options">
                            <div class="order-radio">
                                <input type="radio" id="delivery-for-ready" name="delivery-time" value="for-ready"
                                       v-model="form.delivery_time">
                                <span @click="form.delivery_time = 'for-ready'">По готовности</span>
                            </div>
                            <div class="order-radio">
                                <input type="radio" id="delivery-for-time" name="delivery-time" value="for-time"
                                       v-model="form.delivery_time">
                                <span @click="form.delivery_time = 'for-time'">Ко времени</span>
                            </div>
                        </div>
                        <div class="delivery-for-time" v-if="form.delivery_time === 'for-time'">
                            <span>Выберите время</span>
                            <vue-timepicker :minute-interval="5"
                                            close-on-complete
                                            :hour-range="[[11, 22]]"
                                            hide-disabled-hours
                                            v-model="form.time"
                                            required
                            />
                        </div>
                    </div>
                    <div class="count">
                        <img src="/images/order-count.svg" alt="">
                        <div class="count-input">
                            <span>Кол-во прибора</span>
                            <input type="number" v-model="form.count">
                        </div>
                    </div>
                    <div class="payment-type">
                        <span class="order-label">Оплата</span>
                        <div class="order-options">
                            <div class="order-radio">
                                <input type="radio" id="payment-type-cash" name="payment-type" value="cash"
                                       v-model="form.payment_type">
                                <span @click="form.payment_type = 'cash'">Наличными</span>
                            </div>
                            <div class="order-radio">
                                <input type="radio" id="payment-type-kaspi" name="payment-type" value="kaspi"
                                       v-model="form.payment_type">
                                <span @click="form.payment_type = 'kaspi'">Kaspi.kz</span>
                            </div>
                        </div>
                    </div>
                    <div class="order-actions">
                        <button type="submit">Оформить заказ</button>
                        <button type="button" @click.prevent="toWhatsapp">WhatsApp</button>
                    </div>
                </form>
            </template>
        </modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Modal from './Modal';
import VuePhoneNumberInput from 'vue-phone-number-input';
import VueTimepicker from 'vue2-timepicker';

export default {
    name: "OrderModal",
    components: {
        Modal, VuePhoneNumberInput, VueTimepicker
    },
    data() {
        return {
            form: {
                name: '',
                address: '',
                phone: '',
                add_info: '',
                delivery_time: 'for-ready',
                time: '',
                count: 1,
                payment_type: 'cash',
            },
            isPhoneError: false,
        };
    },
    computed: {
        ...mapGetters({
            isShow: 'getOrderModal',
            user: 'getUser',
            products: 'getBasketProducts',
            total: 'getTotal',
        }),
    },
    watch: {
        isShow(newValue) {
            this.isShow = newValue;
            this.$store.commit('MODAL_IS_OPENED', newValue);
        },
        user(newValue) {
            this.form.name = newValue.name;
            this.form.address = newValue.address;
            this.form.phone = newValue.phone.slice(3);
        },
    },
    methods: {
        close() {
            this.$store.commit('SET_ORDER_MODAL', false);
        },
        toWhatsapp() {
            if (this.products.length === 0) {
                this.close();
            }

            if (this.form.phone && this.form.phone.replace(/[^A-Z0-9]+/ig, '').length !== 10) {
                this.isPhoneError = true;
                return;
            }

            if (this.form.name && this.form.phone && this.form.address) {
                let payment_type = '';
                let delivery_time = '';

                switch (this.form.payment_type) {
                    case 'cash':
                        payment_type = 'Наличными';
                        break;
                    case 'kaspi':
                        payment_type = 'Kaspi.kz';
                        break;
                }

                switch (this.form.delivery_time) {
                    case 'for-ready':
                        delivery_time = 'По готовности';
                        break;
                    case 'for-time':
                        delivery_time = `Ко времени - ${this.form.time}`;
                        break;
                }

                let message = '';
                message += 'Имя: ' + this.form.name + '\r\n';
                message += 'Номер телефона: +7 ' + this.form.phone + '\r\n';
                message += 'Адрес: ' + this.form.address + '\r\n';

                message += 'Способ оплаты: ' + payment_type + '\r\n';
                message += 'Время доставки: ' + delivery_time + '\r\n';
                message += 'Кол-во приборов: ' + this.form.count + '\r\n';
                message += 'Итоговая цена: ' + this.total + 'тг.\r\n';
                message += 'Доп. информация: ' + this.form.add_info + '\r\n';
                message += '    *** Корзина ***\r\n';
                message += this.products.map((item) => {
                    return {
                        title: item.title,
                        count: item.basketCount,
                    };
                }).reduce((text, current, i, array) => (array.length - i) + ') ' + current.title + ' - ' + current.count + ' пор.' + (i > 0 ? '\r\n' : '') + text, '');

                location.href = 'https://wa.me/77787478866?text=' + encodeURI(message);
                return false;
            }
        },
        submit() {
            if (this.products.length === 0) {
                this.close();
            }

            if (this.form.phone && this.form.phone.replace(/[^A-Z0-9]+/ig, '').length !== 10) {
                this.isPhoneError = true;
                return;
            }

            if (this.form.name && this.form.phone && this.form.address) {
                let payment_type = '';
                let delivery_time = '';

                switch (this.form.payment_type) {
                    case 'cash':
                        payment_type = 'Наличными';
                        break;
                    case 'kaspi':
                        payment_type = 'Kaspi.kz';
                        break;
                }

                switch (this.form.delivery_time) {
                    case 'for-ready':
                        delivery_time = 'По готовности';
                        break;
                    case 'for-time':
                        delivery_time = `Ко времени - ${this.form.time}`;
                        break;
                }

                let products = this.products.map((item) => {
                    return {
                        id: item.id,
                        count: item.basketCount,
                    };
                })

                axios.post('/origummy/api/v1/order', {
                    name: this.form.name,
                    phone: `+7 ${this.form.phone}`,
                    address: this.form.address,
                    additional_info: this.form.add_info,
                    count: this.form.count,
                    payment_type,
                    delivery_time,
                    products,
                }).then((response) => {
                    if (response.data) {
                        if (response.data.status === 'success') {
                            this.$store.commit('SET_USER_PHONE', response.data.data.user_phone);
                            this.$store.commit('UPDATE_STORAGE_USER');
                            this.$store.commit('CLEAR_BASKET_PRODUCTS');
                            this.$store.commit('UPDATE_STORAGE_PRODUCTS');
                            this.$store.commit('SET_BASKET_MODAL', false);
                            this.$store.commit('SET_PRODUCT_MODAL', false);
                            this.close();
                            this.$store.commit('SET_THANK_MODAL', true);
                        }
                    }
                });
            }
        },
    },
}
</script>

<style scoped>
.phone-error {
    font-size: .8rem;
    color: red;
}
</style>
