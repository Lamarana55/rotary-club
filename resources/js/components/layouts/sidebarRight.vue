<template>
    <aside class="control-sidebar control-sidebar-dark">
        <div class="card bg-dark">
            <div class="card-body bg-dark box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" :src="'assets/dist/img/user2-160x160.jpg'"
                        alt="User profile">
                </div>
                <h3 class="profile-username text-center ellipsis">
                    {{ currentUser.nom + ' ' + currentUser.prenom }}
                </h3>
                <p class="text-muted text-center">Admin</p>
                <ul class="list-group bg-dark mb-3">
                    <li class="list-group-item">
                        <a href="" class="d-flex align-items-center">
                            <i class="fa fa-user pr-2"></i><b>Profile</b>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="" class="d-flex align-items-center">
                            <i class="fa fa-lock pr-2"></i><b>Mot de passe</b>
                        </a>
                    </li>

                </ul>
                <a href="" @click.prevent="logout" class="btn btn-primary btn-block">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    Déconnexion
                </a>
            </div>
        </div>
    </aside>
</template>
<script>
export default {
    name: 'home',
    methods: {
        logout() {
            this.$store.commit('logout');
            this.$router.push('/login');
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    }
}
</script>
