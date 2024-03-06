<template>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- <nav-bar></nav-bar> -->
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- <side-bar></side-bar> -->
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div>
                                    <router-view></router-view>
                                </div>
                                <div id="styleSelector"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import NavBar from './layouts/navbar.vue'
import SideBar from './layouts/menu.vue'
export default {
    name: 'home',
    components: {
        NavBar,
        SideBar
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    }
}
</script>
