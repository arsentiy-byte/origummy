<template>
    <b-modal :active.sync="isModalActive" has-modal-card>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Подтвердите удаление</p>
            </header>
            <section class="modal-card-body">
                <p>
                    Это действие удалит <b>"{{ trashObjectName }}"</b>
                </p>
                <p>Удаление нельзя восстановить!</p>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="cancel">Отменить</button>
                <button class="button is-danger" @click="confirm">Удалить</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
export default {
  name: 'DeleteModal',
  props: {
    isActive: {
      type: Boolean,
      default: false
    },
    trashObjectName: {
      type: String,
      default: null
    }
  },
  data () {
    return {
      isModalActive: false
    }
  },
  watch: {
    isActive (newValue) {
      this.isModalActive = newValue
    },
    isModalActive (newValue) {
      if (!newValue) {
        this.cancel()
      }
    }
  },
  methods: {
    cancel () {
      this.$emit('cancel')
    },
    confirm () {
      this.$emit('confirm')
    }
  }
}
</script>

<style scoped>

</style>
