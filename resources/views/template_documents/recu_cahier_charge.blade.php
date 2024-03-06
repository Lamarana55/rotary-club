<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reçu paiement cahier de charge</title>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {margin: 0;padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;font-family: Arial, Helvetica, sans-serif; position:relative; line-height: 150%;}
        article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block; }
        body {line-height: 1; }
        ol, ul {list-style: none; }
        blockquote, q {quotes: none; }
        blockquote {
        &:before, &:after {content: '';content: none; } }
        q {&:before, &:after {content: '';content: none; } }
        table {border-collapse: collapse;border-spacing: 0; }
        a{text-decoration: none;}

        .container-fluid {
            margin: 30px;
        }

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
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="imageDiv">
            <img  src="{{ $pathBranding }}"  alt="" class="imageClass" width="300"/>
        </div>
        <div class="header">
            <table class="table-head bg-head">
                <tbody>
                    <tr>
                        <td style="text-align:center;">
                            <h2>REPUBLIQUE DE GUINEE</h2>
                            <p class="devise">
                                <span>TRAVAIL</span> – <span> JUSTICE </span>- <span>SOLIDARITE</span>
                            </p>
                        </td>
                        <td style="text-align:center;">
                            <img  src="{{ $pathArmoirie }}"  alt="" width="50px">
                        </td>
                        <td class="right-text">
                            Ministère de l'Information et de la <br/>Communication
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="title-recu">
            <h1 class="title-page">Reçu de paiement</h1>
        </div>

        <p>
            <strong>Relatif : </strong>
            AUX CONDITIONS D'IMPLANTATION ET D'EXPLOITATION DES RADIOS
            DIFFUSIONS ET TELEVISIONS EN REPLUBLIQUE DE GUINEE
        </p>

        <p style="text-align:right">
            <span>Conakry, le  {{ $date }} </span>
        </p>

        <p> <strong>Béneficiaire:</strong>  {{ $media->nom ??null }} </p>
        <p> <strong>Mode de paiement:</strong>  {{ $mode }} </p>

        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th>N° Ordre</th>
                        <th>Désignation</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: solid 1px #000;" height="18">1</td>
                        <td style="border: solid 1px #000;">Cahier des charges</td>
                        <td  style="text-align: center; font-weight:none; border: solid 1px #000;">1</td>
                        <td style="text-align: right; font-weight:none; border: solid 1px #000;"> {{ formatGNF($montant)}}  </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:left; border: solid 1px #000;"><strong>Montant total </strong></td>
                        <td style="text-align: right; border: solid 1px #000;"> {{ formatGNF($montant) }} </td>
                    </tr>
                </tbody>
            </table>

        </div>
        {{-- <div style="display: flex; flex-wrap: wrap; margin-left: 10px; margin-top: 30px; width: 100%">
            <div style="display: inline-block; flex-grow: 1;margin-right: 70%; ">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " height="95px" width="100px"/>
            </div>

            <div style="text-align:right;  display: inline-block; flex-grow: 1; padding-top:0 ">
                <strong>Signature</strong>
            </div>
        </div> --}}
        <p style="text-align:right; margin-top: 30px;">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " height="95px" width="100px"/>
        </p>
        <p style="margin-top:-10px; text-align:right; ">Ce reçu est certifié, unique et securisé</p>


        <div class="footer">
            <table class="table-head">
                <tbody>
                    <tr>
                        <td style="text-align:center; padding: 0;">
                            <img  src="{{$flag_guinnea}}"  alt="" width="50px"  style="margin-top:5px;" />
                        </td>
                        <td style="text-align:center; border-left: solid 2px #000; border-right: solid 2px #000; padding: 0;">
                            <p style="font-size:8pt;">Boulbinet,Commune de Kaloum - BP : 617 - Conakry, République de Guinée</p>
                            <p style="font-size:8pt;">Email: <a href="contact@mic.gov.gn">contact@mic.gov.gn</a> - Site internet : <a href="www.mic.gov.gn">www.mic.gov.gn</a></p>
                        </td>
                        <td class="right-text; padding: 0;">
                            <img  src="{{ $pathBranding }}"  alt="" width="50px" style="margin-top:5px;" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
