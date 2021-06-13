<template>
  <div class="is-user-avatar">
    <img :src="newUserAvatar" :alt="Origummy">
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'UserAvatar',
  props: {
    avatar: {
      type: String,
      default: null
    }
  },
  computed: {
    newUserAvatar () {
      if (this.avatar) {
        return this.avatar
      }

      if (this.user.avatar) {
        return this.user.avatar
      }
    },
    ...mapState([
      'user'
    ])
  }
}
</script>
