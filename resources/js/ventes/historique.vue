<template>
    <div class="page-wrapper">
        <div class="page-header horizontal-layout-icon">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Gestion des historiques des ventes</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item" style="float: left;">
                                <a href="#!">
                                    <i class="icofont icofont-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item" style="float: left;">
                                <a href="#!">Accueil</a>
                            </li>
                            <li class="breadcrumb-item" style="float: left;">
                                <a>historiques ventes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="card page-header">
                <div class="card-block front-icon-breadcrumb row align-items-end p-3 m-b-9">
                    <div class="card-tools col-lg-8">

                    </div>
                    <div class="card-tools d-flex align-items-center col-lg-4">
                        <div class="input-group input-group-sm">
                            <input type="date" v-model="form.dateDebut" class="form-control" placeholder="Date début">
                            <input type="date" v-model="form.dateFin" class="form-control" placeholder="Date Fin">
                            <button type="button" @click.prevent="filtreDate()"
                                class="btn hor-grd btn-grd-inverse btn-out btn-mini text-center">
                                <i class="fa fa-filter"></i> Filtrer date
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card borderless-card">
                        <div class="card-block primary-breadcrumb d-flex align-items-center">
                            <h3 class="card-title flex-grow-1">
                                <i class="fa fa-list fa-1x"></i> Liste des ventes ({{ this.ventes?.total }})
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-head-fixed table-bordered table-striped table-xs">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date de vente</th>
                                        <th>Gerant</th>
                                        <th>Montant</th>
                                        <th class="text-center">Action.s</th>
                                    </tr>
                                </thead>
                                <template v-if="this.loaderStatus">
                                    <loader-component></loader-component>
                                </template>
                                <template v-else>
                                    <tbody>
                                        <tr v-for="(prod, index) in ventes.data" :key="prod.id_vente">
                                            <td>{{ index + 1 }} </td>
                                            <td>{{ prod?.date }}</td>
                                            <td>{{ prod?.user?.prenom + ' ' + prod?.user?.nom }}</td>
                                            <td>{{ Number(prod?.montant).toLocaleString() }} GNF</td>
                                            <td class="text-center">
                                                <a @click.prevent="showDetail(prod.id_vente)" data-toggle="modal"
                                                    data-target="#showByProduit"
                                                    class="btn btn-mini btn-outline-info btn-info">
                                                    <i class="fa fa fa-list"></i>
                                                </a>
                                                <a @click.prevent="printVente(prod.id_vente)"
                                                    class="btn btn-mini btn-outline-success btn-success">
                                                    <i class="fa fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <Pagination :data="ventes" @pagination-change-page="getResults" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <show-produit v-bind:details="details"></show-produit>
        </div>
    </div>
</template>
<script>
import autoTable from 'jspdf-autotable';
import LaravelVuePagination from 'laravel-vue-pagination';
import showProduit from './showDetail.vue'

export default {
    name: 'unite',
    components: {
        showProduit,
        'Pagination': LaravelVuePagination
    },
    data() {
        return {
            form: {
                dateDebut: '',
                dateFin: ''
            },
            events: [],
            details: '',
            ventes: [],
            date: '',
            terme: '',
            showEdit: false,
            id: '',
        }
    },
    async created() {
        this.getVentes()
    },

    methods: {
        test() {
            axios.get('api/test')
                .then(response => {
                    console.log('test');
                    // this.ventes = response.data.ventes
                })
                .catch(error => {
                    if (error.response?.data?.message == 'Token has expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                });
        },
        printVente(id) {

            axios.get('/api/getDetailByVente/' + id)
                .then(response => {
                    this.details = response.data.data

                    // var tables = Array.from(this.details.details, (item, index) => ([
                    //     index + 1,
                    //     item.produit.nom,
                    //     item.quantite,
                    //     Number(item?.produit?.prixVente).toLocaleString(['ban', 'id']),
                    //     Number(item.total).toLocaleString(['ban', 'id'])
                    // ]))
                    // var doc = new jsPDF();
                    // doc.addImage("/files/assets/images/logo-blue.png", "png", 15, 15, null, null);
                    // var head = [['ID', 'Produit', 'Quantite', 'Prix', 'sous-total']]

                    // autoTable(doc, {
                    //     head: head,
                    //     body: tables,
                    //     foot: [
                    //         ['Montant HT', '', '', '', Number(this.details.montant).toLocaleString(['ban', 'id']) + ' GNF'],
                    //         ['TVA', '', '', '', '0'],
                    //         ['Montant TTC', '', '', '', '' + Number(this.details.montant).toLocaleString(['ban', 'id']) + ' GNF'],
                    //     ],
                    //     footStyles: {
                    //         textColor: [0, 0, 0],
                    //         fillColor: [192, 192, 192],
                    //     },
                    //     margin: { left: 15, right: 18, top: 100 }
                    // });

                    // doc.setFontSize(20);
                    // doc.text("Reçu ", 105, 50, null, null, "center");

                    // doc.setFont("Arial", "normal");
                    // doc.setFontSize(12);
                    // doc.text('Reference : ' + this.details?.vente?.code + '\nDate : ' + this.details.vente.date, 180, 60, null, null, "right");

                    // doc.setFont("Times New Roman", "Times", "serif");
                    // doc.setFontSize(14);
                    // doc.text("Le gerant", 170, 260, null, null, "right");


                    // doc.save('facture.pdf');

                }).catch(error => {
                })
        },
        filtreDate() {
            const t = this
            if (this.form.dateDebut != '' && this.form.dateFin != '') {
                axios.post('api/filter-vente', {
                    'dateDebut': this.form.dateDebut,
                    'dateFin': this.form.dateFin
                })
                    .then(response => {
                        this.ventes = response.data.ventes
                    })
                    .catch(error => {
                        if (error.response?.data?.message == 'Token has expired') {
                            this.$store.commit('logout');
                            this.$router.push('/login');
                        }
                    });
            } else {
                this.getVentes()
            }


        },
        showDetail(id) {
            axios.get('/api/getDetailByVente/' + id)
                .then(response => {
                    this.details = response.data.data
                }).catch(error => {

                })
            this.id = id
        },
        getVentes() {
            const t = this
            setTimeout(function () {
                axios.get('/api/historique-ventes')
                    .then(response => {
                        t.ventes = response.data.ventes
                        t.loaderStatus = false
                    })
                    .catch(error => {
                        t.loaderStatus = false
                    });
            }, 500)
        },
        getResults(page = 1) {
            axios.get(`api/historique-ventes/?page=` + page)
                .then(response => this.ventes = response.data.ventes)
                .catch(error => {
                    if (error.response?.data?.status == 'Token is Expired') {
                        this.$store.commit('logout');
                        this.$router.push('/login');
                    }
                })
        },
        refresh(ventes) {
            this.ventes = ventes.data
        },
    }
}
</script>

