<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-primary ">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>Admin</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Connectez-vous pour démarrer votre session</p>
                    <form class="md-float-material form-material">
                        <div class="input-group mb-3">
                            <input type="text" v-model="form.email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-12">
                                <button type="button"
                                    class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20"
                                    @click.prevent="authenticate" :disabled="isSave" :loading="isSave">
                                    {{ isSave? 'Connexion...': 'Connecter' }}
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>
<script>
import { login } from '../../helpers/auth';
export default {
    name: "Login",
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            error: null,
            isSave: false,
        };
    },

    methods: {
        async authenticate() {
            this.isSave = true
            this.$store.dispatch('login');

            login(this.$data.form)
                .then((res) => {
                    this.$store.commit("loginSuccess", res);
                    window.location = "/"
                })
                .catch((error) => {
                    this.$store.commit("loginFailed", { error });
                    this.showAlertError(error)
                    this.isSave = false
                })
        }
    },

    computed: {
        authError() {
            return this.$store.getters.authError;
        }
    }
}
</script>
