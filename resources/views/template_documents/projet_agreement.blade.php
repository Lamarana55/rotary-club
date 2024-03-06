<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Projet d'agreement</title>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {margin: 5px; padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;font-family: Arial, Helvetica, sans-serif; position:relative; line-height: 150%;}
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
            text-align: center;
        }

        /* div.footer {
            display: block;
            text-align: center;
            position: running(footer);
        } */

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
            margin-top: 5%;
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

        .custom-footer-page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div>
            {!! $projet_agrement !!}
            <div class="content">
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
                                {{-- <p style="text-align:right; margin-top: 30px; display: inline-block; flex-grow: 1;margin-right: 70%; ">
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " height="60px" width="60px"/>
                                    Ce reçu est certifié, unique et securisé
                                </p> --}}
                                Conakry, le______________<br><br><br>
                                <strong>{{$nomMinistre??null}}</strong><br>
                                Ministre de l'information et<br> de la communication
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="footer" class="footer">
            <table class="table-head">
                <tbody>
                    <tr>
                        <td style="text-align:center; padding: 0;">
                            <img src="{{ $flag_guinnea }}" alt="" width="50px"  style="margin-top:5px;" />
                        </td>
                        <td style="text-align:center; border-left: solid 2px #000; border-right: solid 2px #000; padding: 0;">
                            <td style="text-align:center; padding: 0;">
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Nom : '.$media->nom.' | '.'Type de media : '.$media->type_media)) !!} " width="50px"  style="margin-top:5px;"/>
                                {{-- <img src="{{ $flag_guinnea }}" alt="" width="50px"  style="margin-top:5px;" /> --}}
                            </td>
                            <p style="font-size:8pt;">Boulbinet,Commune de Kaloum - BP : 617 - Conakry, République de Guinée</p>
                            <p style="font-size:8pt;">Email: <a href="contact@mic.gov.gn">contact@mic.gov.gn</a> - Site internet : <a href="www.mic.gov.gn">www.mic.gov.gn</a></p>
                            {{-- <p style="text-align:left; padding: 0;">Ce reçu est certifié, unique et securisé</p> --}}
                        </td>
                        <td class="right-text; padding: 0;">
                            <img src="{{ $pathBranding }}" alt="" width="50px" style="margin-top:5px;" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
