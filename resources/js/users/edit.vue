<template>
    <!-- Modal -->
    <div class="modal fade" id="editModalUser" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header primary-breadcrumb">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <i class="fa fa-save fa-1x"></i> Modification des Utilisateurs
                    </h5>
                </div>
                <div class="modal-body">
                    <form class="md-float-material">
                        <div class="auth-box card-block">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" v-model="editUser.nom" class="form-control"
                                        :class="{ 'border-danger': errors.nom }" placeholder="Nom">
                                </div>
                                <div class="text-danger" v-if="errors.nom" v-text="errors.nom[0]"></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" v-model="editUser.prenom" class="form-control"
                                        :class="{ 'border-danger': errors.prenom }" placeholder="prenom">
                                </div>
                                <div class="text-danger" v-if="errors.prenom" v-text="errors.prenom[0]"></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" v-model="editUser.telephone" class="form-control"
                                        :class="{ 'border-danger': errors.telephone }" placeholder="telephone">
                                </div>
                                <div class="text-danger" v-if="errors.telephone" v-text="errors.telephone[0]"></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" v-model="editUser.email" class="form-control"
                                        :class="{ 'border-danger': errors.email }" placeholder="email">
                                </div>
                                <div class="text-danger" v-if="errors.email" v-text="errors.email[0]"></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" v-model="editUser.adresse" class="form-control"
                                        :class="{ 'border-danger': errors.adresse }" placeholder="adresse">
                                </div>
                                <div class="text-danger" v-if="errors.adresse" v-text="errors.adresse[0]"></div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <select v-model="editUser.id_role" placeholder="Role" class="form-control"
                                        :class="{ 'border-danger': errors.role }">
                                        <option v-for="role in roles" :value="role.id_role" v-bind:key="role.id_role">
                                            {{ role.nom }}
                                        </option>
                                    </select>
                                    <span class="md-line"></span>
                                </div>
                                <div class="text-danger" v-if="errors.role" v-text="errors.role[0]"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="icofont icofont-close m-r-5"></i> Fermer</button>
                    <button type="button" class="btn btn-primary float-right" @click.prevent="updateUser"
                        :disabled="isSave" :loading="isSave">
                        <i class="icofont icofont-save m-r-5"></i>
                        {{ isSave ? 'Modification...' : 'Modifier' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'user',
    props: ['editUser'],
    data() {
        return {
            roles: [],
            isSave: false,
            errors: {},
        };
    },

    async created() {
        axios.get('/api/roleRelation')
            .then(response => this.roles = response.data)
            .catch(error => {
                console.log(error);
            });
    },

    methods: {
        async updateUser() {
            this.isSave = true
            axios.put('/api/user/' + this.editUser.id_user, {
                'nom': this.editUser.nom,
                'role': this.editUser.id_role,
                'prenom': this.editUser.prenom,
                'telephone': this.editUser.telephone,
                'email': this.editUser.email,
                'adresse': this.editUser.adresse,
            })
                .then(response => {
                    this.$emit('edit-user', response)
                    this.errors = {}
                    this.isSave = false
                    this.showAlertSuccess("Modification effectué avec success")
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.isSave = false;
                        this.errors = error.response.data.errors;
                    } else if (error.response.status == 500) {
                        this.isSave = false
                    }
                    this.errors = error.response.data.errors
                    this.isSave = false
                })
        }
    }
}
</script>
