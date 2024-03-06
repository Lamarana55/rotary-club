<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Rapport Commission</title>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {margin: 5px;padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;font-family: Arial, Helvetica, sans-serif; position:relative; line-height: 150%;}
        article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block; }
        body {line-height: 1; }
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


    </style>
</head>
<body>
    <div class="container-fluid">
        <div>
            <div class="imageDiv">
                <img src="{{$pathBranding}}" alt="" class="imageClass" width="300"/>
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
                                <img src="{{$pathArmoirie}}" alt="" width="50px">
                            </td>
                            <td class="right-text">
                                Ministère de l'Information et de la <br/>Communication
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="content">
                <h1 class="titre">Rapport</h1>
                <p style="font-weight:bold; text-align:center; margin:0">d'examen d'une demandes d'autorisation d'implantation de radios privée</p>
                <p style="text-align: justify;"> {{dateFormat($rapport_commission->date_debut,"table") }} , la Commission d'examen des demandes d'autorisation d'implantation de
                    radios et de télévisions en République de Guinée, s'est réunie au Ministère de l'information et de la Communication (MIC),
                    sous la présidence de
                    <span>
                         @foreach($membre_commissions as $membre)
                            @if ($membre->fonction == "Président")
                                <span style="font-weight:bold">  {{$membre->membre->full_name }}  ,</span>  {{$membre->membre->fonction }}  de la Commission;.
                             @endif
                        @endforeach
                    </span>
                </p>
                <p>Début de la réunion: <span style="font-weight:bold">{{dateFormat($rapport_commission->date_debut,"table") }} à {{dateFormat($rapport_commission->heure_debut,"only_time")}} </span></p>
                <p>Fin de la réunion: <span style="font-weight:bold">{{dateFormat($rapport_commission->date_fin,"table")}} à {{dateFormat($rapport_commission->heure_fin,"only_time")}} </span></p>
                <p>Lieu de la réunion: <span style="font-weight:bold">Ministère de l'Information et de la Communication</span></p>
                <p>Ordre du jour : <span style="font-weigth:bold">Examen du média  {{$media->nom}} .</span></p>
                <p>Etaient présents: <span style="font-weight:bold">  {{count($membre_commissions)}}  membres de la Commission d'examen sur  {{$member_lenght}} , qui
                sont :</span></p>
                <ol start="4" type="1" >
                    <?php $i = 1;?>
                     @foreach($membre_commissions as $membre)
                        <li>  {{$i++ }} . <span style="font-weight:bold">Monsieur  {{$membre->membre->full_name }}  </span>  {{$membre->membre->fonction }} de la Commission;</li>
                     @endforeach
                Membre.</li>
                </ol>
                <p >
                    Le quorum étant atteint a plus de 70%, le Président de séance a introduit les travaux
                    en citant les trois (03) projets à examiner et a donné la parole au Rapporteur afin de
                    rappeler la méthodologie de travail.
                </p>

                <div class="container">
                    <div>
                        <p class="cell cell-3" style="text-align:center">
                            Conakry, le  {{ dateFormat($date,"table") }} <br>
                        </p>
                    </div>
                    <p style="text-align:center; margin:0">
                        <span style="text-decoration:underline;">Ont signé</span>
                    </p>
                    <table class="table-head" style="margin-top:0">
                        <tbody>
                            <tr>
                                <td class="m-0"  style="text-align:center;">
                                    <p>Le Rapporteur</p>
                                    <br>
                                    <p>Guealé Gbato DORE</p>
                                    <p>Directeur Général du BSD</p>
                                </td>
                                <td class="m-0"  style="text-align:center;">

                                </td>
                                <td class="m-0"  class="right-text">
                                    <p>Le Président de la Commission</p>
                                    <br>
                                    <p>Souleymane Bah</p>
                                    <p>Secrétaire Général</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table >
                    <tbody>
                         @foreach($membre_commissions as $membre)
                        <tr class="table-border">
                            <td class="m-0 table-border" style="border: solid 1px #000;" width="50%" >
                                 {{$membre->membre->full_name }}
                            </td>
                            <td class=" table-border m-0" style="border: solid 1px #000;" width="50%" >
                                 {{$membre->membre->fonction }}
                            </td>
                            <td class="m-0 table-border" style="border: solid 1px #000;" width="50%" >

                            </td>
                        </tr>
                         @endforeach

                    </tbody>
                </table>
            </div>
            <p style="font-weight:bold; text-align:center; margin:0">Synthèse du rapports d'évaluation de demande d'autorisation d'implantation de  {{$media->type_media}} </p>

            <table class="rapport-table">
                <tbody>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;font-weight:bold" >Parametre d'evaluation du projet</td>
                        <td style="border: solid 1px #000;font-weight:bold" >Norme du cahier de charge</td>
                        <td style="border: solid 1px #000;font-weight:bold" >Donnees du projet</td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left; " >Forme juridique</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->forme_juridique }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->forme_juridique }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Capital social</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->capital_social }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->capital_montant }} {{ $rapport_commission->capital_unite }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de part</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_depart }}  </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_part_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Pourcentage réservé aux investisseurs locaux</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->pourcentage_investisseur_signe }}{{ $rapport_commission->pourcentage_investisseur_label_value }} %</td>
                        <td style="border: solid 1px #000;" >  {{ $rapport_commission->pourcentage_investisseur_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de Certificat de nationalités des principaux dirigeants</td>
                        <td style="border: solid 1px #000;" >1 à 3</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_certificat }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de Certificat de résidence des principaux dirigeants</td>
                        <td style="border: solid 1px #000;" >1 à 3 </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_certificat_resident }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de casiers judiciaires des principaux dirigeants</td>
                        <td style="border: solid 1px #000;" > 1 à 3 </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_certificat_casier_dirigeant }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de diplôme des journalistes qualifiés</td>
                        <td style="border: solid 1px #000;" >3</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->nombre_journaliste }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de diplôme detechniciens professionnels</td>
                        <td style="border: solid 1px #000;" > 2 </td>
                        <td style="border: solid 1px #000;" >  {{ $rapport_commission->nombre_diplome_technicien }}  </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Catégorie de la chaine</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->categorie_chaine}} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->categorie_chaine}} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Orientation de la chaine</td>
                        <td style="border: solid 1px #000;" > {{$rapport_commission->orientation_chaine }} </td>
                        <td style="border: solid 1px #000;" > {{$rapport_commission->orientation_chaine }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Public cible</td>
                        <td style="border: solid 1px #000;" >{{ 'Au choix' }}</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->public_cible }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Équipements de réception</td>
                        <td style="border: solid 1px #000;" >{{ '500-1000 watts' }}</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->equipement_reception }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Équipement de studio</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->equipement_studio }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->equipement_studio }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Équipement d'émission (emetteur)</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->equipement_emission }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->equipement_emission }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Part reservé aux programmes provenant de l'extérieur</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->programme_provenant_exterieur }} {{ $rapport_commission->programme_provenant_exterieur_value }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->programme_provenant_exterieur }} {{ $rapport_commission->programme_provenant_exterieur_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Productions internes</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->production_interne_signe }} {{ $rapport_commission->production_interne_label_value }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->production_interne_signe }} {{ $rapport_commission->production_interne_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Coproductions</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->coproduction_signe }}{{ $rapport_commission->coproduction_label_value }} </td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->coproduction_signe }}{{ $rapport_commission->coproduction_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Échanges de programmes</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->echange_programme_signe }}{{ $rapport_commission->echange_programme_label_value }} %</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->echange_programme_value }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Respect des exigences de l'unité nationale et l'ordre public</td>
                        <td style="border: solid 1px #000;" >{{ 'OUI/NON' }}</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->exigence_unite_nationale }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Capacités financières</td>
                        <td style="border: solid 1px #000;" > {{$rapport_commission->capacite_financiere}} </td>
                        <td style="border: solid 1px #000;" > {{$rapport_commission->etat_financier}} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Capacités financières preuve</td>
                        <td style="border: solid 1px #000;" >{{$rapport_commission->capacite_financiere_preuve}}</td>
                        <td style="border: solid 1px #000;" >{{$rapport_commission->etat_financier}}</td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Etats financiers prévisionnels</td>
                        <td style="border: solid 1px #000;" > {{ $rapport_commission->etat_financier }} </td>
                        <td style="border: solid 1px #000;" >  {{ $rapport_commission->etat_financier }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" colspan="2" > Conclusion de la commission</td>
                        <td style="border: solid 1px #000;" >  {{ $rapport_commission->conclusion }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
         {{-- ======================== --}}
        <div style="display: flex; flex-wrap: wrap; margin-left: 10px; margin-top: 30px; width: 100%">
            <div style="display: inline-block; flex-grow: 1;margin-right: 70%; ">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " height="95px" width="100px"/>
            </div>
        </div>
        <p style="margin-top:-15px; margin-left: 15px; ">Ce rapport est certifié, unique et securisé</p>
         {{-- ======================== --}}
        <div class="footer">
            <table class="table-head">
                <tbody>
                    <tr>
                        <td style="text-align:center; padding: 0;">
                            <img src="{{$flag_guinnea}}" alt="" width="50px"  style="margin-top:5px;" />
                        </td>
                        <td style="text-align:center; border-left: solid 2px #000; border-right: solid 2px #000; padding: 0;">
                            <p style="font-size:8pt;">Boulbinet,Commune de Kaloum - BP : 617 - Conakry, République de Guinée</p>
                            <p style="font-size:8pt;">Email: <a href="contact@mic.gov.gn">contact@mic.gov.gn</a> - Site internet : <a href="www.mic.gov.gn">www.mic.gov.gn</a></p>
                        </td>
                        <td class="right-text; padding: 0;">
                            <img src="{{$pathBranding}}" alt="" width="50px" style="margin-top:5px;" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
     <script type="text/php">
        $watermark = $pdf->open_object();
        $w = $pdf->get_width();
        $h = $pdf->get_height();
        $pdf->text(110, $h - 240, "DELETED", Font_Metrics::get_font("helvetica", "bold"),110, array(0.85, 0.85, 0.85), 0, -52);
        $pdf->close_object();
        $pdf->add_object($watermark, "all");
    </script>
</body>
</html>
