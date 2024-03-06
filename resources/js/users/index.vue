<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/Accueil"></router-link> </li>
                            <li class="breadcrumb-item active">utilisateurs</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-gradient-default d-flex align-items-center">
                                <div class="card-tools d-flex align-items-center ">
                                    <a class="btn bg-dark text-white mr-4 d-block" @click.prevent="goToAdd">
                                        <i class="fas fa-plus"></i> Nouvel Utilisateur
                                    </a>
                                </div>
                                <h3 class="card-title flex-grow-1"></h3>
                                <div class="card-tools d-flex ">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control float-right" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body table-responsive p-0 table-striped">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Telephone</th>
                                            <th>Role</th>
                                            <th class="text-center">Action.s</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users.data" :key="user.id_user">
                                            <td>{{ user.nom }}</td>
                                            <td>{{ user.prenom }}</td>
                                            <td>{{ user.telephone }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user?.role?.nom }}</td>
                                            <td class="text-center">
                                                <a @click.prevent="getEdit(user.id_user)"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <Pagination :data="users" @pagination-change-page="getResults" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    name: 'client',
    components: {
        'Pagination': LaravelVuePagination
    },
    data() {
        return {
            users: [],
            editUser: '',
            terme: '',
            id: '',
        }
    },
    async created() {
        const t = this
        setTimeout(function () {
            axios.get('/api/users')
                .then(response => {
                    t.users = response.data
                    t.loaderStatus = false
                })
                .catch(error => {
                    t.loaderStatus = false
                });
        }, 500)
    },

    methods: {
        goToAdd() {
            this.$router.push('/add-utilisateur');
        },
        getEdit(id) {
            axios.get('api/user/' + id)
                .then(response => this.editUser = response.data)
                .catch(error => {
                    if (error.response?.data?.message == 'Token has expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                })
        },
        getResults(page = 1) {
            axios.get(`api/users?page=` + page)
                .then(response => this.users = response.data)
                .catch(error => {
                    if (error.response?.data?.message == 'Token has expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                })
        },
        search() {
            if (this.terme.length >= 2) {
                axios.get('api/users/' + this.terme)
                    .then(response => this.users = response.data.users)
                    .catch(error => {
                        if (error.response?.data?.message == 'Token has expired') {
                            this.$store.commit('logout');
                            this.$router.push('/login');
                        }
                    });
            } else {
                axios.get('api/users')
                    .then(response => this.users = response.data)
                    .catch(error => {
                        if (error.response?.data?.message == 'Token has expired') {
                            this.$store.commit('logout');
                            this.$router.push('/login');
                        }
                    });
            }
        },
        refresh(users) {
            this.users = users.data
            this.showAdd = false;
        }
    }
}
</script>
