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
                                <h3 class="card-title flex-grow-1">
                                    <i class="fa fa-save"></i> Enregistrement des utilisateurs
                                </h3>
                            </div>
                            <div class="card-body">
                                <form class="md-float-material">
                                    <div class="auth-box card-block">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" v-model="form.nom" class="form-control"
                                                    :class="{ 'border-danger': errors.nom }" placeholder="Nom">
                                            </div>
                                            <div class="text-danger" v-if="errors.nom" v-text="errors.nom[0]"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" v-model="form.prenom" class="form-control"
                                                    :class="{ 'border-danger': errors.prenom }" placeholder="prenom">
                                            </div>
                                            <div class="text-danger" v-if="errors.prenom" v-text="errors.prenom[0]">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" v-model="form.telephone" class="form-control"
                                                    :class="{ 'border-danger': errors.telephone }"
                                                    placeholder="telephone">
                                            </div>
                                            <div class="text-danger" v-if="errors.telephone"
                                                v-text="errors.telephone[0]"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="email" v-model="form.email" class="form-control"
                                                    :class="{ 'border-danger': errors.email }" placeholder="email">
                                            </div>
                                            <div class="text-danger" v-if="errors.email" v-text="errors.email[0]"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <Select v-model="form.role" placeholder="Role"
                                                    :class="{ 'border-danger': errors.role }">
                                                    <Option v-for="role in roles" :value="role.id_role"
                                                        v-bind:key="role.id_role">
                                                        {{ role.nom }}
                                                    </Option>
                                                </Select>
                                                <span class="md-line"></span>
                                            </div>
                                            <div class="text-danger" v-if="errors.role" v-text="errors.role[0]"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="button" @click.prevent="goToListe()" class="btn btn-secondary"
                                    data-dismiss="modal">
                                    <i class="fa fa-times m-r-5"></i> Fermer</button>
                                <button type="button" class="btn btn-primary float-right" @click.prevent="saveUser"
                                    :disabled="isSave" :loading="isSave">
                                    <i class="fa fa-save m-r-5"></i>
                                    {{ isSave? 'Enregistrement...': 'Enregistrer' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'user',
    data() {
        return {
            roles: [],
            form: {
                nom: '',
                role: '',
                prenom: '',
                telephone: '',
                email: '',
            },
            isSave: false,
            errors: {},
        };
    },

    async created() {
        axios.get('/api/roleRelation')
            .then(response => this.roles = response.data)
            .catch(error => {
                if (error.response?.data?.message == 'Token has expired') {
                    this.$store.commit('logout');
                    this.$router.push('/login');
                }
            });
    },

    methods: {
        goToListe() {
            this.$router.push('/utilisateur');
        },
        async saveUser() {
            this.isSave = true
            axios.post('/api/user', {
                'nom': this.form.nom,
                'role': this.form.role,
                'prenom': this.form.prenom,
                'telephone': this.form.telephone,
                'email': this.form.email,
            })
                .then(response => {//vider les champ
                    this.$emit('add-user', response) //c'est evenement
                    this.form.prenom = "" //fin vider
                    this.form.telephone = ""
                    this.form.nom = ""
                    this.form.role = ""
                    this.form.email = ""
                    this.errors = {}
                    this.isSave = false
                    this.showAlertSuccess("Enregistrement effectué avec success");

                    this.$router.push('/utilisateur');
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.isSave = false;
                        this.errors = error.response.data.errors;
                    } else if (error.response.status == 500) {
                        this.isSave = false
                    } else if (error.response?.data?.message == 'Token has expired') {
                        //verifie si le tocken n'est pas expirer
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                    this.errors = error.response.data.errors
                    this.isSave = false
                })
        }
    }
}
</script>
