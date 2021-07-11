<template>
    <div>
        <title-bar :title-stack="['Admin', 'Баннеры']"/>
        <card-component title="Баннеры" icon="picture-in-picture-top-right">
            <div class="banners" style="display:flex; flex-wrap: wrap;">
                <div class="banner"
                     v-for="banner in banners"
                     style="padding: 5px; border: 1px solid #f2f2f2;">
                    <img :src="`/images/${banner.image}`" alt="Banner">
                    <b-button type="is-danger" @click="deleteBanner(banner.image)"
                              icon-left="delete">
                        Delete
                    </b-button>
                </div>
                <div class="add-banner">
                    <b-upload v-model="file" class="file-label">
                    <span class="file-cta">
                        <b-icon class="file-icon" icon="upload"></b-icon>
                        <span class="file-label">Click to upload</span>
                    </span>
                        <span class="file-name" v-if="file">
                        {{ file.name }}
                    </span>
                    </b-upload>
                </div>
            </div>
        </card-component>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import CardComponent from "../components/CardComponent";
import TitleBar from "../components/TitleBar";

export default {
    name: "Banners",
    components: {
        TitleBar, CardComponent,
    },
    data() {
        return {
            file: null,
        };
    },
    watch: {
        file(newValue) {
            if (newValue) {
                this.uploadBanner(newValue);
            }
        },
    },
    computed: {
        ...mapGetters({
            banners: 'getBanners',
        }),
    },
    created() {
        this.$store.dispatch('getAllBanners');
    },
    methods: {
        uploadBanner(file) {
            this.$store.commit('SET_IS_LOADING', true);
            let formData = new FormData();
            formData.append('banners[]', file);
            this.uploadRequest(formData)
        },
        deleteBanner(fileName) {
            this.$store.commit('SET_IS_LOADING', true);
            let formData = new FormData();
            formData.append('delete_banners[]', fileName);
            this.uploadRequest(formData)
        },
        uploadRequest(formData) {
            axios.post('/origummy/api/v1/banners', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    if (response.data.status === 'success') {
                        this.$store.commit('SET_IS_LOADING', false);
                        this.$buefy.notification.open({
                            message: response.data.message,
                            type: 'is-success'
                        });
                        this.$store.dispatch('getAllBanners');
                    }

                    if (response.data.status !== 'success') {
                        this.$store.commit('SET_IS_LOADING', false);
                        this.$buefy.toast.open({
                            message: `Error: #${response.data.error_code} ${response.data.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    }
                })
                .catch((error) => {
                    this.$store.commit('SET_IS_LOADING', false);
                    this.$buefy.toast.open({
                        message: `Error: ${error.message}`,
                        type: 'is-danger',
                        queue: false
                    })
                })
        },
    },
}
</script>

<style scoped>

</style>
