<template>
    <!-- Modal -->
    <div class="modal fade" id="showByProduit" style="z-index: 1050;" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" style="max-width:900px;" role="document">
            <div class="modal-content">
                <div class="modal-header primary-breadcrumb">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <i class="fa fa-list fa-1x"></i> Detail d'une vente
                    </h5>
                </div>
                <div class="modal-body scan">
                    <div class="row">
                        <div class="col-md-12">
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
                                        <tr v-for="detail in details.details" :key="detail.id_detailvente">
                                            <td>{{ detail.produit.nom }}</td>
                                            <td>
                                                {{ Number(detail.quantite).toLocaleString() }}
                                            </td>
                                            <td>{{ Number(detail?.produit?.prixVente).toLocaleString() }} GNF</td>
                                            <td>{{ Number(detail?.total).toLocaleString() }} GNF</td>
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
                                                    {{ Number(details.montant).toLocaleString() }} GNF
                                                </h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-primary float-right" @click.prevent="saveVente">
                                <i class="icofont icofont-print m-r-5"></i>
                                Imprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'unite',
    props: ['details'],
    data() {
        return {
            errors: {},

        };
    },


    methods: {
    }
}

</script>
