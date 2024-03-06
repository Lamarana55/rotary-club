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
            <div class="">
                <div>
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
                                        <strong>{{$nomMinistre?? 'nomMinistre'}}</strong><br>
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
                            </td>
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
</body>
</html>
