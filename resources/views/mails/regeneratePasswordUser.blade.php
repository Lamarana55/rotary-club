@component('mail::message')
# Reinitialisation

Votre mot a été reinitialisé par l'adiministrateur

Veuillez vous connecter a votre compte <br>
En cliquant sur le button ci-dessous

@component('mail::button', ['url' => $url])
Cliquez ici
@endcomponent
Puis entrez <br> Adresse mail: <b>{{$data_user->email}}</b> <br>
                 Mot de passe: <b>{{$reinit_password}}</b> <br>


À bientôt,<br>
Ministère de l'information et de la communication
@endcomponent
