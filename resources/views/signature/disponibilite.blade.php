@extends('layouts.default')
@section('page')
Mes disponibilités pour les rendez-vous
@endsection

@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#saveDialog" data-href="{{ route("disponibilites.create") }}">
                        Ajouter une plage de disponibilité
                    </button>
                </div>
            </div>


            <div class="card-body">
                <table class="table table-bordered table-responsives">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Heures de disponibilité</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="disponibilite-tbody">
                        @forelse($disponibilites as $disponibilite)
                            <tr>
                                <td>{{ $disponibilite->jour }}</td>
                                <td>{{ $disponibilite->heure_debut }}H - {{ $disponibilite->heure_fin }}H</td>
                                <td class="text-right">
                                    @if($disponibilite->canDelete())
                                        <a class="btn btn-primary btn-sm link-update mb-1" href="#" data-href="{{ route('disponibilites.edit', $disponibilite->uuid) }}">
                                            {{ __('Modifier') }}
                                        </a>
                                        <a href="javascript: void(0);" class="btn btn-danger btn-sm btn-delete mb-1" data-href="{{ route('disponibilites.destroy', $disponibilite->uuid ?? 1) }}">
                                            {{ __('Supprimer') }}
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                        <tr class="information">
                            <td colspan="3">
                                <div class="alert alert-info">
                                <h5><i class="icon fas fa-ban"></i> Information!</h5>
                                Aucune donnée trouvée par rapport aux éléments de recherche entrés.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="card-footer clearfix">
                {{ $disponibilites->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div style="display: none;" id="tr-template">
    <table>
        <tbody>
            <tr>
                <td class="r-2"></td>
                <td class="r-3"></td>
                <td class="text-right">
                    <a class="btn btn-primary btn-sm link-update mb-1" href="#" data-href="">
                        {{ __('Modifier') }}
                    </a>
                    <a href="javascript: void(0);" class="btn btn-danger btn-sm btn-delete mb-1" data-href="">
                        {{ __('Supprimer') }}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" id="saveDialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Création d'une plage de disponibilité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include("signature.rdv.create")
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger fermerModal" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success add-disponibilite">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-keyboard="false" role="dialog" id="updateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mise a jour d'une plage de disponibilité</h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success update-disponibilite">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{ asset("backend/assets/js/custom.js") }}"></script>
    <script>
        $(document).ready(function(){
            $('.fermerModal').on('click', function (e) {
                e.preventDefault();
                document.getElementById('jour').value=""
                document.getElementById('heure_debut').value=""
                document.getElementById('heure_fin').value=""
            });

            $('.add-disponibilite').on('click', function (e) {
                e.preventDefault();

                var form = $(e.target).parents(".modal-content").find("form");

                ajax(
                    form.attr("action"),
                    "POST",
                    form[0],
                    function (data) {
                        if(data.status == true) {
                            var template = $("#tr-template tr").clone(true);
                            template.find(".r-2").text(data.programme.jour);
                            template.find(".r-3").text(data.programme.heure_debut+"H - " + data.programme.heure_fin+"H");
                            template.find(".link-update").attr("data-href", `/disponibilites/${data.programme.uuid}/edit`);
                            template.find(".btn-delete").attr("data-href", `/disponibilites/${data.programme.uuid}`);
                            $('.information').remove();
                            $(".disponibilite-tbody").append(template);

                            form[0].reset();
                        }
                    }
                );
            });

            var row = null;

            //Mise a jour de la disponibilite
            $('.link-update').on('click', function (e) {
                e.preventDefault();
                row = $(e.target).parents("tr");

                $("#updateModal .modal-body").load($(e.target).attr('data-href'));

                $('#updateModal').modal('show');
            });

            $('.update-disponibilite').on('click', function (e) {
                e.preventDefault();

                var form = $(e.target).parents(".modal-content").find("form");

                ajax(
                    form.attr("action"),
                    "POST",
                    form[0],
                    function (data) {
                        setTimeout(function () {
                            document.location.reload();
                        }, 100);
                    }
                );
            });

            $(".btn-close").on("click", function (e) {
                $('#updateModal').modal('hide');
            });
        });
    </script>
@endsection

