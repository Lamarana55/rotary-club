<div class="card-body p-0">
    <div class="bs-stepper m-0">
        @include('medias.stepper.header')
        <div class="bs-stepper-content">
            {{-- etape 1 --}}
            @include('medias.stepper.etape_cahier_charge_paiement')

            {{-- etape 2 --}}
            @include('medias.stepper.etape_depot_dossier_technique')

            {{-- etape 3 --}}
            @include('medias.stepper.etape_etude_dossier_hac')

            {{-- etape 4 --}}
            {{-- @include('medias.stepper.etape_paiement_frais_agrement') --}}

            {{-- etape 5 --}}
            {{-- @include('medias.stepper.etape_transmission_agrement') --}}

            {{-- etape 6 --}}
            {{-- @include('medias.stepper.etape_sgg') --}}

            {{-- etape 7 --}}
            {{-- @include('medias.stepper.etape_prise_rdv') --}}

            {{-- etape 8 --}}
            {{-- @include('medias.stepper.etape_telecharge_document') --}}

            {{-- etape 9 --}}
            {{-- @include('medias.stepper.etape_sommaire') --}}

        </div>
    </div>
</div>
