<style>
.flipswitch {
    position: relative;
    background: rgb(81, 247, 225);
    width: 120px;
    height: 40px;
    -webkit-appearance: initial;
    border-radius: 3px;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    outline: none;
    font-size: 14px;
    font-family: Trebuchet, Arial, sans-serif;
    font-weight: bold;
    cursor: pointer;
    border: 1px solid #ddd;
}

.flipswitch:after {
    position: absolute;
    top: 5%;
    display: block;
    line-height: 32px;
    width: 45%;
    height: 90%;
    background: #fff;
    box-sizing: border-box;
    text-align: center;
    transition: all 0.3s ease-in 0s;
    color: black;
    border: #888 1px solid;
    border-radius: 3px;
}

.flipswitch:after {
    left: 2%;
    content: "OFF";
}

.flipswitch:checked:after {
    left: 53%;
    content: "ON";
}
</style>
<template>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalVente" style="z-index: 1050;" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" style="max-width:950px;" role="document">
            <div class="modal-content">
                <div class="modal-header primary-breadcrumb">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <i class="fa fa-list fa-1x"></i> Panier des vente produits
                    </h5>
                </div>
                <div class="modal-body scan" v-on:keyup="barcode">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed table-bordered table-striped table-xs">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantite</th>
                                            <th>Prix</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detail in details" :key="detail.id_detailvente">
                                            <td>{{ detail.produit.nom }}</td>
                                            <td>
                                                <a v-if="(detail.quantite > 1)"
                                                    @click.prevent="moinQuantite(detail.id_detailvente)"
                                                    class="btn btn-mini btn-outline-warning btn-warning">
                                                    <i class="fa fa fa-minus"></i>
                                                </a>
                                                {{ Number(detail.quantite).toLocaleString() }}
                                                <a @click.prevent="plusQuantite(detail.id_detailvente)"
                                                    class="btn btn-mini btn-outline-success btn-success">
                                                    <i class="fa fa fa-plus"></i>
                                                </a>
                                            </td>
                                            <td>{{ Number(detail?.produit?.prixVente).toLocaleString() }} GNF</td>
                                            <td>{{ Number(detail?.total).toLocaleString() }} GNF</td>
                                            <a @click.prevent="deleteDetailVente(detail.id_detailvente)"
                                                class="btn btn-mini btn-outline-danger btn-danger">
                                                <i class="fa fa fa-trash"></i>
                                            </a>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="">
                                <table class="table table-responsive invoice-table invoice-total">
                                    <tbody>
                                        <tr class="text-info">
                                            <td>
                                                <h5 class="text-primary">Total :</h5>
                                            </td>
                                            <td>
                                                <h5 class="text-primary">
                                                    {{ Number(data.montant).toLocaleString() }} GNF
                                                </h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="auth-box card-block">
                                <h5 class="text-danger" v-if="this.form.scan == false">Activer
                                </h5>
                                <h5 class="text-success" v-if="this.form.scan">Désactiver</h5><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" v-model="form.scan" checked="" class="flipswitch" />
                                    </div>
                                </div>

                                <div class="form-group" v-if="this.form.scan == false">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="form.id"
                                            placeholder="Code de produit">
                                    </div>
                                </div>

                                <div class="form-group" v-if="this.form.scan">
                                    <div class="input-group">
                                        <input type="text" id="douchette" v-model="form.code" @keyup="codeBar"
                                            class="form-control" placeholder="Scanner">
                                    </div>
                                </div>

                                <button v-if="this.form.scan == false" type="button"
                                    class="btn btn-primary float-right block" @click.prevent="ajouteQuantite"
                                    :disabled="isSave" :loading="isSave">
                                    <i class="icofont icofont-plus m-r-5"></i>
                                    {{ isSave ? 'ajout...' : 'Ajouter' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger " data-dismiss="modal"><i
                                    class="icofont icofont-close m-r-5"></i> Fermer</button>
                        </div>
                        <div class="col-sm-6" v-if="this.data.montant">
                            <button type="button" class="btn btn-primary float-right" @click.prevent="saveVente"
                                :disabled="isSave2" :loading="isSave2">
                                <i class="icofont icofont-save m-r-5"></i>
                                {{ isSave2 ? 'Enregistrement...' : 'Enregistrer' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
$(function () {
    var f = function () {
        $(this).next().text($(this).is(':checked') ? '' : '');
    };
    $('input').change(f).trigger('change');
});
function lectureDouchette() {
    // contenu du champ douchette
    var vals = ''
    vals = $('#douchette').val();
    //console.log();
    //On affiche ce qui a ete tapé dans la div resultat
    if (vals.length > 0) {
        $('#resultat').append(vals + '<br>');
    }
    //on efface le contenu du champ douchette
    $('#douchette').val('');
    $('#douchette').focus();

}

$(document).ready(function () {
    //lecture des donnée
    //setInterval(lectureDouchette, 3000);
})

export default {
    name: 'unite',
    data() {
        return {
            form: {
                scan: true,
                id: '',
                code: '',
                quantite: ''
            },
            data: {
                montant: 0,
            },
            code: '',
            details: [],
            prod: {},
            unites: [],
            produits: [],
            isSave: false,
            isSave2: false,
            errors: {},

        };
    },

    async created() {
        this.getDetailVente()
    },

    methods: {
        plusQuantite(id) {
            axios.get('api/plus-quantite/' + id)
                .then(response => {
                    this.getDetailVente()
                })
                .catch(error => {
                    if (error.response?.data?.status == 'Token is Expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        moinQuantite(id) {
            axios.get('api/moin-quantite/' + id)
                .then(response => {
                    this.getDetailVente()
                })
                .catch(error => {
                    if (error.response?.data?.status == 'Token is Expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        async ajouteQuantite() {
            if (this.form.id == '') return this.showAlertError('saisir le code produit')
            this.isSave = true
            axios.get('api/ligne-id/' + this.form.id)
                .then(response => {
                    if (response.data.statut == 200) {
                        this.getDetailVente()
                        this.form.id = ""
                        this.isSave = false
                        this.showAlertSuccess("Enregistrement effectué avec success")
                    } else if (response.data.statut == 100) {
                        this.isSave = false
                        this.showAlertInfo(response.data.message)
                    }
                })
                .catch(error => {
                    if (error.response?.data?.status == 'Token is Expired') {
                        this.isSave = false
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        async codeBar() {
            if (this.form.code.length == 13) {
                axios.get('api/ligne/' + this.form.code)
                    .then(response => {
                        if (response.data.statut == 200) {
                            this.getDetailVente()
                            this.showAlertSuccess("Enregistrement effectué avec success")
                        } else if (response.data.statut == 100) {
                            this.showAlertInfo(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response?.data?.status == 'Token is Expired') {
                            this.$store.commit('logout');
                            this.$router.push('/login');
                        }
                    });
            }

        },
        getDetailVente() {
            axios.get('/api/ligne-vente')
                .then(response => {
                    this.details = response.data.details
                    this.data.montant = response.data.montant
                }).catch(error => {
                })
        },
        async saveVente() {
            this.isSave2 = true
            axios.post('/api/vente', this.data)
                .then(response => {
                    this.$emit('add-vente', response)
                    this.data.montant = ""
                    this.errors = {}
                    this.isSave2 = false
                    this.getDetailVente()
                    this.showAlertSuccess("Enregistrement effectué avec success")

                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.isSave2 = false;
                        this.errors = error.response.errors
                    } else if (error.response.status == 500) {
                        this.isSave2 = false;
                        this.errors = error.response.errors
                    } else if (error.response?.data?.status == 'Token is Expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                    this.errors = error.response.data.errors
                    this.isSave2 = false
                })
            this.isSave2 = false;

        },

        deleteDetailVente(id) {
            this.$swal.fire({
                title: 'Vous êtes sur le point de supprimer ce produit',
                text: 'Êtes-vous sûr de continuer ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OUI',
                cancelButtonText: 'NON'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('api/delete-ligne-vente/' + id)
                        .then(response => {
                            this.getDetailVente()
                            this.showAlertSuccess("suppression effectué avec success");
                        })
                        .catch(error => {
                            if (error.response?.data?.status == 'Token is Expired') {
                                this.$store.commit('logout');
                                this.$router.push('/login');
                            }
                        });
                }
            })
        },
    }
}

</script>
