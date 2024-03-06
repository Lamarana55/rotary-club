<div class="card">
    <div class="card-header bg-dark">
        <h3 class="card-title">Mme/Mr {{$data['user']['nom']}} {{$data['user']['prenom']}}</h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body">
        @if ($data['type']=='VALIDE_USER')
        <p>Votre compte a été validé avec succès, rendez-vous dans votre espace pour finaliser votre demande. <strong><a href="{{$data['url']}}">Cliquer ici</a></strong></p><br>

        @else
        <p>Votre compte a été activé avec succès</p>
        @endif

    </div>
</div>

À bientôt,<br>
Ministère de l'information et de la communication
