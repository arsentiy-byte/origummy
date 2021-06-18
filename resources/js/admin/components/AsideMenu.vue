<template>
    <aside
        v-show="isAsideVisible"
        class="aside is-placed-left is-expanded">
        <aside-tools :is-main-menu="true">
            <span slot="label" style="display:flex; align-items: center;">
                <img src="/images/logo.svg" alt="Origummy.kz" style="margin-right: 10px;">
                <b>Origum</b>my
            </span>
        </aside-tools>
        <div class="menu is-menu-main">
            <template v-for="(menuGroup, index) in menu">
                <p v-if="typeof menuGroup === 'string'" :key="index" class="menu-label">
                    {{ menuGroup }}
                </p>
                <aside-menu-list
                    v-else
                    :key="index"
                    :menu="menuGroup"
                    @menu-click="menuClick"
                />
            </template>
        </div>
    </aside>
</template>

<script>
import {mapState} from 'vuex'
import AsideTools from "./AsideTools";
import AsideMenuList from "./AsideMenuList";
import UserAvatar from "./UserAvatar";

export default {
    name: 'AsideMenu',
    components: {AsideTools, AsideMenuList, UserAvatar},
    props: {
        menu: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        ...mapState([
            'isAsideVisible'
        ])
    },
    methods: {
        menuClick(item) {
            //
        }
    }
}
</script>
