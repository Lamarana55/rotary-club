@extends("emails.layout")

@php
    $message = explode("|", $message);
@endphp
@section("content")
    <table id="u_content_heading_2" style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
                <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:50px 50px 0px;font-family:'Open Sans',sans-serif;" align="left">
                    <h1 class="v-text-align v-line-height v-font-size" style="margin: 0px; line-height: 140%; text-align: left; word-wrap: break-word; font-size: 24px; "><strong>{{ $objet }}</strong></h1>
                </td>
            </tr>
        </tbody>
    </table>

    <table id="u_content_text_3" style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
                <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 50px;font-family:'Open Sans',sans-serif;" align="left">
                    <div class="v-text-align v-line-height v-font-size" style="line-height: 170%; text-align: justify; word-wrap: break-word;">
                        @if(!is_array($message))
                            <p style="line-height: 170%;">{!! $message !!}</p>
                        @else
                            @foreach ($message as $msg)
                                <p style="line-height: 170%;">{!! $msg !!}</p>
                            @endforeach
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    @if ($url)
        <table id="u_content_button_1" style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
            <tbody>
                <tr>
                    <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 50px 50px;font-family:'Open Sans',sans-serif;" align="left">
                        <!--[if mso]><style>.v-button {background: transparent !important;}</style><![endif]-->
                        <div class="v-text-align" align="left">
                            <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://www.unlayer.com" style="height:37px; v-text-anchor:middle; width:162px;" arcsize="11%"  stroke="f" fillcolor="#0b6445"><w:anchorlock/><center style="color:#FFFFFF;font-family:'Open Sans',sans-serif;"><![endif]-->
                            <a href="{{ $url }}" target="_blank" class="v-button v-size-width v-font-size" style="box-sizing: border-box;display: inline-block;font-family:'Open Sans',sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #0b6445; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:30%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;">
                                <span class="v-line-height" style="display:block;padding:10px 20px;line-height:120%;"><span style="line-height: 16.8px;">Connexion</span></span>
                            </a>
                            <!--[if mso]></center></v:roundrect><![endif]-->
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

@endsection
