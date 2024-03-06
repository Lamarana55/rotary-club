<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Rapport HAC</title>
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
            width: 100%;
        }

        strong {font-weight: bold;}

        table, th { border: 1px solid black; font-weight: bold; text-align: center; padding: 10px;}
        .font-bold {font-weight: bold;}

        .signature {
            float: right;
            margin-top: 50px;
            margin-right: 12px;
        }
        .logo-armoirie {
            width: 10%;
            float:left;
        }

        .branding-natianal {width: 10%;float: left;}

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
            width: 100%;
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
        img.imageClass { position:relative; max-width:100%; max-height:100%;margin-top:-50%; margin-left:-50%;}
        .content{width:100%; margin-right: 20px;}
        .rapport-table, th, td {
            text-align: center;
            padding: 10px;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <table class="table-head" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="text-align:center;">
                            <img src="{{$logo_hac}}" alt="" width="80px">
                        </td>
                        <td style="text-align:center;">
                            <h2>REPUBLIQUE DE GUINEE</h2>
                            <p class="devise"><span style="color:red;">TRAVAIL</span> – <span style="color:yellow"> JUSTICE </span>- <span style="color:green">SOLIDARITE</span></p>
                            <h3>HAUTE AUTORITE DE LA COMMUNICATION</h3>
                        </td>
                        <td class="right-text">
                            <img src="{{$pathArmoirie}}" alt="" width="50px">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p style="text-align:center; font-weight:bold;">
                SYNTHESE DES
                RAPPORTS D’EVALUATION DES DEMANDES D’AUTORISATION D’IMPLANTATION DE RADIOS ET DE
                TELEVISIONS PRIVEES
            </p>
        </div>
        <div class="content">
            <table class="rapport-table" style="font-weight:none;" >
                <tbody>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;font-weight:bold;text-align:center">Parties</td>
                        <td style="border: solid 1px #000;text-align:left;font-weight:bold;text-align:center" >Paramètres d'evaluation du projet</td>
                        <td style="border: solid 1px #000;font-weight:bold;text-align:center" > Normes des Cahiers de Charges</td>
                        <td style="border: solid 1px #000;font-weight:bold;text-align:center" >Données du projet présentés</td>
                    </tr>
                    <tr>
                        <td rowspan="7">IDENTIFICATION DU PROMOTEUR </td>
                        <td style="border: solid 1px #000;text-align:left; " >Forme juridique</td>
                        <td style="border: solid 1px #000;text-align:left; "> {{ $rapport_hac->forme_juridique }} </td>
                        <td style="border: solid 1px #000;text-align:left; "> {{ $rapport_hac->forme_juridique }}  </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Capital social</td>
                        <td style="border: solid 1px #000;text-align:left; "> {{ $rapport_hac->capital_social }} </td>
                        <td style="border: solid 1px #000;text-align:left; "> {{ $rapport_hac->capital_montant }} {{$rapport_hac->capital_unite}}  </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de part</td>
                        <td style="border: solid 1px #000;text-align:left;" > {{ $rapport_hac->nombre_depart }} </td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->nombre_part_value }} </td>

                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Pourcentage réservé aux investisseurs locaux</td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->pourcentage_investisseur_signe }}{{$rapport_hac->pourcentage_investisseur_label_value}} %</td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->pourcentage_investisseur_value }} %</td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de Certificat de nationalités des principaux dirigeants</td>
                        <td style="border: solid 1px #000;text-align:left;"> 1 à 3 </td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->nombre_certificat }} </td>

                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de Certificat de résidence des principaux dirigeants</td>
                        <td style="border: solid 1px #000;text-align:left;">1 à 3</td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->nombre_certificat }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Nombre de casiers judiciaires des principaux dirigeants</td>
                        <td style="border: solid 1px #000;text-align:left;">1 à 3 </td>
                        <td style="border: solid 1px #000;text-align:left;"> {{ $rapport_hac->nombre_certificat_resident }} </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000;text-align:left;" >Conclusion</td>
                        <td style="border: solid 1px #000;text-align:left;" colspan="3"> {{ $rapport_hac->conclusion }} </td>
                    </tr>
                </tbody>
            </table>
             {{-- ======================== --}}
            <div style="display: flex; flex-wrap: wrap; margin-left: 10px; margin-top: 30px; width: 100%">
                <div style="display: inline-block; flex-grow: 1;margin-right: 70%; ">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " height="95px" width="100px"/>
                </div>
            </div>
            <p style="margin-top:-15px; margin-left: 15px; ">Ce rapport est certifié, unique et securisé</p>
             {{-- ======================== --}}
           <p style="text-align:right; font-weight:bold; margin-top:-30px;">Conakry le, {{ dateFormat($date,"table") }} </p>
            <table class="table-head" style="width:100%;">
                <tbody>
                    <!-- <tr>
                        <td>Le Rapporteur</td>
                        <td>Le Président de la Commission NTIC</td>
                    </tr> -->
                     @foreach($membre_commissions as $membre)
                        <tr>
                            <td style="border: solid 1px #000;text-align:left;"><br/> {{ $membre->membre->fonction }} </td>
                            <td style="border: solid 1px #000;text-align:left;"><br/> {{ $membre->membre->full_name }} </td>
                            <td style="border: solid 1px #000;text-align:left; width:30px;"><br/></td>
                        </tr>
                     @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <div class="footer">
        <table class="table-head" style="width: 100%">
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
