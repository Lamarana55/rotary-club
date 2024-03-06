@section('page')
Edition du projet d'agrément de : ({{$media->nom.' | '.$media->type.' '.$media->type_media}})
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
{{-- @endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}"> --}}
<style>
    /* html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {margin: 5px;padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;font-family: Arial, Helvetica, sans-serif; position:relative; line-height: 150%;} */
    article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block; }
    /* body {line-height: 1; } */
    ol, ul {list-style: none; }
    blockquote, q {quotes: none; }
    blockquote {
    &:before, &:after {content: '';content: none; } }
    q {&:before, &:after {content: '';content: none; } }
    table {border-collapse: collapse;border-spacing: 0; }
    a{text-decoration: none;}

    .header {
        text-align: center;
    }

    .title-recu {
        width: 100%;
        border: solid 1px #fff;
    }

    .table-content {
        width: 100%;
    }

    strong {
        font-weight: bold;
    }

    p{
        margin-top:20px;
        margin-bottom:20px;
    }

    table, th {
        border: 1px solid black;
        font-weight: bold;
        text-align: center;
        padding: 10px;
    }
    table, td {
        border: 1px solid black;
        padding: 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .font-bold {
        font-weight: bold;
    }

    .signature {
        float: right;
        margin-top: 50px;
        margin-right: 12px;
    }
    .logo-armoirie {
        width: 10%;
        float:left;
    }

    .content-text {
        width: 100%;
        text-align: center;
        /* float:left; */
    }

    .branding-natianal {
        width: 10%;
        float: left;
    }

    .title-page{
        text-align: center;
        font-weight: bold;
        font-size: 20pt;
        margin-top: 40px;
        margin-bottom: 40px;
        text-transform: uppercase;
        width: 100%;
    }

    .table-head, td, tr {
        border: solid 0 #fff
    }
    .bg-head {
        background-color: #000;
        color: #fff;
        opacity: 0.5;
    }
    .right-text{
        text-align:center;
    }
    .devise {
        font-size: 8pt;
        margin-top:0
    }
    .footer {
        position: absolute;
        bottom:0;
        left:0;
        right:0;
    }
    div.imageDiv {
        position:absolute;
        max-width:45%;
        max-height:45%;
        top:50%;
        left:50%;
        overflow:visible;
        opacity: 0.2;
    }
    img.imageClass {
        position:relative;
        max-width:100%;
        max-height:100%;
        margin-top:-50%;
        margin-left:-50%;
    }

    .content{
        width:95%;
        margin-right: 0px;

    }
    .titre{
        text-decoration: underline;
        text-align:center;
        font-weight:bold;
        font-size: 24px;
    }
    .m-0{
        margin:0
    }
    .table-border{
        border: solid 1px #000;
    }

    .rapport-table th td {
        border: 1px solid black;
        padding: 10px;
    }

    .article {
        width: 80px;
        border-bottom: 1px solid black;
        font-weight:bold;
    }


</style>
@endsection
<div class="row">
        @include('medias.medias.show-modal-projet-agrement')

        <div class="col-md-12">
          <div class="card card-body">
                <div class="card-header">
                    <h3 class="card-title">
                        Editer le projet d'agrément
                    </h3>
                </div>
              {{-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="">Nom complet de ministre <i class="text-danger">*</i></label>
                        <input type="text" wire:model="nomMinistre" class="form-control @error('nomMinistre') is-invalid @enderror">
                        @error("nomMinistre")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="">Nom complet de ministre <i class="text-danger">*</i></label>
                        <input type="date" wire:model="dateDePaiement" id="genreMinistre" name="genreMinistre" class="form-control @error('genreMinistre') is-invalid @enderror">
                        @error("genreMinistre")
                            <span class="text-danger dateDePaiement">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
              </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomMinistre">Nom Ministre <i class="text-danger">*</i></label><br>
                                <input type="text" wire:model='nomMinistre' class="form-control @error('nomMinistre') is-invalid @enderror">
                                @error("nomMinistre")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="genreMinistre">Genre <i class="text-danger">*</i></label><br>
                                <select type="text" wire:model='genreMinistre' class="form-control @error('genreMinistre') is-invalid @enderror">
                                    <option value="">---Selectionner---</option>
                                    <option value="Masculin">Masculin</option>
                                    <option value="Feminin">Feminin</option>
                                </select>
                                @error("genreMinistre")
                                    <span class="text-danger genreMinistre">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div wire:ignore>
                        <textarea id="summernote">
                            <div class="">
                                <div>
                                    @php
                                        use Illuminate\Support\Facades\DB;
                                        $imagePath     = public_path('dist/img/momo.png');
                                        $pathArmoirie = convertBase64('public/assets/dist/img/armoirie.png');
                                        $pathBranding = convertBase64('public/assets/dist/img/branding.jpg');
                                        $flag_guinnea = convertBase64('public/assets/dist/img/flag_guinea.png');
                                        // $media = DB::table('media')->where('id',$media->media_id)->first();
                                        $date = date('d-m-Y');
                                    @endphp
                                    <div class="imageDiv">
                                        <img src="{{ $pathBranding }}" alt="" class="imageClass" width="300"/>
                                    </div>
                                    <div class="header">
                                        <table class="table-head bg-head">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center;">
                                                        <h2>REPUBLIQUE DE GUINEE</h2>
                                                        <p class="devise">
                                                            <span>TRAVAIL</span> – <span> JUSTICE </span> - <span>SOLIDARITE</span>
                                                        </p>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <img src="{{ $pathArmoirie }}" alt="" width="50px">
                                                    </td>
                                                    <td class="right-text">
                                                        Ministère de l'Information et de la <br/>Communication
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="content">
                                        <p style="font-weight:bold; text-align:center;">
                                            ARRÊTE A/2022/ ______  /MIC/CAB/SGG <br>
                                        </p>
                                        <p style="font-weight:bold; text-align:center; margin-top:2px">
                                            PORTANT ATTRIBUTION D’UN AGREMENT POUR L’INSTALLATION ET<br>L’EXPLOITATION D’UNE STATION DE RADIODIFFUSION PRIVEE EN REPUBLIQUE DE GUINEE
                                        </p>
                                        <p style="font-weight:bold; text-align:center;">
                                            {{$genreMinistre && $genreMinistre == 'Masculin' ? 'LE' : 'LA'  }} MINISTRE
                                        </p>

                                        <p style="">
                                            <strong>Vu</strong> la Charte de la Transition ;<br>
                                            <strong>Vu</strong> la Loi Organique LO/2010/002/CNT du 22 juin 2010, portant Liberté de la Presse ;<br>

                                            <strong>Vu</strong> la Loi L/2015/018/AN du 08 septembre 2015, portant réglementation des<br>Télécommunications en République de Guinée ;<br>

                                            <strong>Vu</strong> la Loi Organique LO/2020/010/AN du 03 juillet 2020, portant attributions,<br>organisation, composition et fonctionnement de la Haute Autorité<br>de la Communication ;<br>

                                            <strong>Vu</strong> l’Ordonnance O/2021/001/PRG/CNRD/SGG du 17 septembre 2021, portant<br>prorogation des lois nationales, des conventions, traités et accords internationaux<br>en vigueur au 05 Septembre 2021 ;<br>

                                            <strong>Vu</strong> le Décret D/2005/037/PRG/SGG/ du 20 août 2005, portant conditions<br>d’implantation et d’exploitation de stations de Radiodiffusion et de Télévision Privées<br>en République de Guinée ;<br>

                                            <strong>Vu</strong> le Décret D/2022/0043/PRG/SGG du 20 janvier 2022, portant attributions<br>et organisation du Ministère de l’Information et de la Communication ;<br>

                                            <strong>Vu</strong> le Décret D/2022/387/PRG/CNRD/SGG du 20 août 2022, portant Nomination du<br>Premier Ministre, Chef du Gouvernement de Transition ;<br>

                                            <strong>Vu</strong> le Décret D/2022/548/PRG/CNRD/SGG du 18 novembre 2022, modifiant la<br>Structure du Gouvernement de Transition ;<br>

                                            <strong>Vu</strong> le Décret D/2022/549/PRG/CNRD/SGG du 18 novembre 2022, portant Nomination<br>des membres du Gouvernement de Transition ;<br>

                                            <strong>Vu</strong> l’Arrêté A/2010/4316/MIC/CAB du 30 septembre 2010, portant application du<br>Décret D/2005/037/PRG/SGG/ du 20 août 2005, portant conditions d’implantation et<br>d’exploitation de stations de Radiodiffusion et de Télévision Privées en République de Guinée ;<br>

                                            <strong>Vu</strong> le Communiqué no 01 du 05 septembre 2021, portant prise effective du Pouvoir<br>par les Forces de Défense et de Sécurité ;<br>

                                            <strong>Vu</strong> l’avis favorable de la Haute Autorité de la Communication N°103/HAC/P/2022.<br>
                                        </p>

                                        <br><p style="text-align:center; font-weight:bold;">ARRÊTE</p>

                                        <p> <strong style="width: 90px; border-bottom: 1px solid black; font-weight:bold;">Article 1er :</strong> Une autorisation d’installation et d’exploitation d’une station de <strong>{{$media->type_media}}</strong> dénommée :
                                        « <strong>{{$media->nom}}</strong> » est accordée à {{ $media->user->genre == 'Masculin' ? 'M' : 'Mme'  }}. <strong>{{$media->user->prenom}} {{$media->user->nom}}</strong>,
                                        <strong>{{$media->user->profession}}</strong>, résidant au quartier {{$media->user->adresse}}, Commune urbaine de {{$media->user->commune}} (République de Guinée)</p>
                                        <p> <strong class="article">Article 2 :</strong> Le concessionnaire devra s’acquitter des droits d’agrément et respecter scrupuleusement le contenu du cahier de charges, conformément à la réglementation en vigueur en République de Guinée.</p>
                                        <p> <strong class="article">Article 3 :</strong> Le présent agrément donne droit à l’attribution d’une fréquence par l’Autorité de Régulation des Postes et Télécommunications (ARPT) en fonction de la disponibilité des fréquences, après avis favorable de la Haute Autorité de la Communication (HAC).</p>
                                        <p> <strong class="article">Article 4 :</strong> La délivrance de cet agrément se formalise par la signature d’une convention d’établissement entre le Ministre en charge de l’Information et de la Communication d’une part et le concessionnaire d’autre part.</p>
                                        <p> <strong class="article">Article 5 :</strong> Nul ne peut détenir plus d’une station de radiodiffusion et/ou de télévision privée à la fois. Cependant en cas de nécessité, les demandes de stations de réémissions à l’intérieur du pays sont autorisées après évaluation et accord du Ministre.</p>
                                        On entend par station de réémission, tout émetteur qui diffuse en temps réel les mêmes programmes provenant directement et strictement de la station de base dans une autre zone de couverture sur la fréquence déportée.</p>
                                        <p> <strong class="article">Article 6 :</strong> Le concessionnaire dispose de six (6) mois pour commencer l’exploitation de sa station, sous peines de retrait du présent agrément.</p>
                                        <p> <strong class="article">Article 7 :</strong> Le présent arrêté qui a une durée de trois (3) ans renouvelables après évaluation du respect des obligations contenues dans le cahier de charges et des conditions d’exploitation par la commission de contrôle des stations de radiodiffusion et de télévision privées, prend effet à compter de sa date de signature et sera enregistré et publié au Journal Officiel de la République.</p>

                                    </div>
                                    <div class="content d-none">
                                        <table class="table-head">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:left; padding: 0;">
                                                    <strong class="article">AMPLIATIONS :</strong><br>
                                                        HAC...................1<br>
                                                        SGG/JO................3<br>
                                                        MIC...................2<br>
                                                        MEFP..................1<br>
                                                        {{$media->nom}}............1<br>
                                                        ARCHIVES............1/9<br>
                                                    </td>
                                                    <td style="text-align:center; font-weight:none;">
                                                        Conakry, le______________<br><br><br>
                                                        <strong>{{$nomMinistre?? '$nomMinistre'}}</strong><br>
                                                        Ministre de l'information et<br> de la communication
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="mt-4 d-none">
                                    <table class="table-head">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:center; padding: 0;">
                                                    <img src="{{ $flag_guinnea }}" alt="" width="50px"  style="margin-top:5px;" />
                                                </td>
                                                <td style="text-align:center; border-left: solid 2px #000; border-right: solid 2px #000; padding: 0;">
                                                    <p style="font-size:8pt;">Boulbinet,Commune de Kaloum - BP : 617 - Conakry, République de Guinée</p>
                                                    <p style="font-size:8pt;">Email: <a href="contact@mic.gov.gn">contact@mic.gov.gn</a> - Site internet : <a href="www.mic.gov.gn">www.mic.gov.gn</a></p>
                                                </td>
                                                <td class="right-text; padding: 0;">
                                                    <img src="{{ $pathBranding }}" alt="" width="50px" style="margin-top:5px;" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </textarea>
                    </div>
                    @error("projet_agrement")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="card-footer mt-3">
                        @if($isEdit)
                        <button type="button" data-toggle="modal" data-target="#showModalProjetAgrement" wire:click="showProjetAgrement({{$media->id}})" class="btn btn-dark float-right">
                            Générer
                        </button>
                    @endif
                    <button type="button" wire:click='genererAgrement' class="btn btn-success float-right mr-4">{{$isEdit ? 'Modifier' : 'Enregistrer'}} </button>
                    <button type="button" wire:click='terminerBtn' class="btn btn-danger float-left mr-4">Fermer </button>
                    </div>
                </div>
          </div>
    </div>
</div>

{{-- @section('js') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
   $(document).ready(function() {
       $('#summernote').summernote({
       tabsize: 2,
    //    height: 100,
       toolbar: [
       ['style', ['style']],
       ['font', ['bold', 'underline', 'clear']],
       ['color', ['color']],
       ['para', ['ul', 'ol', 'paragraph']],
       ['table', ['table']],
       ['insert', ['link', 'picture', 'video']],
       ['view', ['fullscreen', 'codeview', 'help']]
       ],
       callbacks: {
           onChange: function(e) {
               @this.set('projet_agrement', e);
           }
       }
   });
   $('.dropdown-toggle').dropdown();
   });
</script>
{{-- @endsection --}}
<script>
    window.addEventListener("showEditModalRejetDocumentCommentaire", event=>{
       $("#editModalRejetDocumentCommentaire").modal('show')
    })

    window.addEventListener("showConfirmTerminerExamenDocuments", event=>{
       Swal.fire({
        title: "Terminer l'examen du dossier technique",
        text: "Confirmez-vous la fin de l'examen du dossier technique du média "+event.detail.message ,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.terminerEtudeDocumentsTechniques()
            }
        })
    })

    window.addEventListener("showSuccessMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
        })
    })

    window.addEventListener("showConfirmAccepteExamenDocuments", event=>{
       Swal.fire({
        title: 'Examen du dossier',
        text: "Confirmez-vous la validation des documents du média "+event.detail.message ,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.accepteFavorable()
            }
        })
    })

    window.addEventListener("showSuccessPersoMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showErrorMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })


    window.addEventListener("showErrorsPersoMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })
</script>

