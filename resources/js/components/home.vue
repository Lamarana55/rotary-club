<template>
    <div class="wrapper">
        <!-- Navbar -->
        <NavBar />
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-2">
            <!-- Brand Logo -->
            <router-link to="/" class="brand-link">
                <img :src="'assets/dist/img/AdminLTELogo.png'" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AGREMENT RTV</span>
            </router-link>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img :src="'assets/dist/img/user2-160x160.jpg'" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ currentUser.prenom + ' ' + currentUser.nom }} </a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <SideBar />
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->

        <router-view></router-view>
        <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <SidebarRight />
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <Footer />
    </div>
</template>
<script>
import NavBar from './layouts/sidbar.vue'
import SideBar from './layouts/menu.vue'
import SidebarRight from './layouts/sidebarRight.vue'
import Footer from './layouts/footer.vue'
export default {
    name: 'home',
    components: {
        NavBar,
        SideBar,
        SidebarRight,
        Footer
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    }
}
</script>
