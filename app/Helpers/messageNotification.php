<?php



function message_email($attribut_message, $media=null, $motif = null) {

    $nom = $media ? $media->nom : "" ;
    $type = $media? $media->type :"";
    $type_media =  $media? $media->type." ".$media->type_media : "";
    $motif = $motif ? $motif : "" ;
    $message_emails = [
        "delais_traitement" => ["Bonjour Mme/Mr","la licence signé est disponible sur la plateforme."],
        "reception_licence_promoteur_et_direction" => ["Bonjour Mme/Mr","la licence signé est disponible sur la plateforme."],

        "reception_projet_d_agrement_promoteur_et_direction" => ["Bonjour Mme/Mr","le projet d'agrement signé est disponible dans le plateforme."],

        "inscription" => ["Bonjour Mme/Mr,","Vous avez reçu une demande de création de compte.","Veuillez vous connecter sur la plateforme pour examiner la demande."],

        "demande_creation_compte" => ["Votre demande de création de compte a été enregistrée avec succès.","Elle est en cours de vérification.","Veuillez patienter, vous recevrez une confirmation dans les plus brefs délais."],

        "activation_compte" => ["Votre compte a été validé avec succès.","Rendez-vous dans votre espace pour finaliser votre demande.","À bientôt."],

        "reinitialisation_password" => ["Votre mot de passe a été reinitialisation avec succès.","Veuillez vous connecter pour la modification de votre mot de passe.","À bientôt."],

        "paiement_agrement" =>  ["Un nouveau reçu de paiement d'agrément a été ajouté par le promoteur de la <b> $type_media $nom </b>","Veuillez vous connecter pour vérifier ce reçu."],

        "msg_de_verification_de_paiement_agrement" => ["Votre paiement est en cours de verification par la Direction Nationale de la Communication et des Relations avec les Médias Privés (DNCRMP)."],

        "paiement_cahier_de_charge" => ["Un nouveau paiement du cahier des charges a été effectué par le promoteur de la <b>$type_media $nom.</b>","Veuillez vérifier ce paiement."],

        "confirmation_de_paiement_cahier_de_charge" => ["Votre paiement a bien été effectué.","Veuillez patienter il est en cours de vérification à la division des affaires financières du Ministère de l’Information et de la Communication."],

        "soummission_de_dossier" => ["Une nouvelle soumission de dossier technique a été éffectuée par le promoteur de la <b> $type_media $nom </b>.","Prière de bien vouloir démarrer l'examen des documents."],

        "examen_terminer" => ["L’examen de votre dossier technique est terminé par la commission en charge.","Merci de bien vouloir vous connecter sur la plateforme pour plus d’information sur l’examen."],

        "avis_consultatif" => ["L'examen du dossier technique de la <b> $type_media  $nom </b> par la HAC est terminé.","Veuillez vous connecter pour plus d'informations."],

        "transmission_projet_d_agrement" => ["Votre projet d'agrément a été transmis au Secrétariat Général du Gouvernement pour enregistrement et publication."],

        "reception_projet_d_agrement_sgg" => ["Bonjour Mme/Mr","Un nouveau projet d'agrément de la <b> $type_media $nom </b> vous a été envoyé","Veuillez vous connecter pour plus d'informations."],

        "transmission_document_hac" => ["Nous vous informons que la commission technique de demande d'agrément vous a transmis le dossier de la <b> $type_media $nom </b> à analyser.","La direction nationale de la communication et des relations avec les médias privés est dans l'attente de retour.","Veuillez vous connecter pour démarrer l'examen."],

        "Avis_consultatif_pour_promoteur" => [ "La Haute Autorité de Communication (HAC) a donné un avis favorable à votre demande d'agrément.","Vous avez 48 heures pour effectuer votre versement sur le compte du trésor et joindre le reçu à votre dossier sur la plateforme.","<h2>Numéro de compte:</h2>"],

        "confirmation_rdv" => ["Bonjour Mme/Mr","Votre rendez-vous pris pour le ".dateFormat($media ? $media->date : "")." a été confirmé.","Veuillez vous présenter à l'heure."], //comment gerer cette variable ici

        "enregistrement_pour_direction" => ["Le Secrétariat général du Gouvernement a enregistré et publié l’agrément de la  <b> $type_media  $nom </b>."],

        "enregistrement_pour_promoteur" => ["Votre agrément de la <b> $type_media  $nom </b> est disponible sur la plateforme","Veuillez vous connecter afin de le télécharger et pour plus d’informations"],

        "prise_de_rdv" => [" Une demande de rendez-vous vous a été envoyé pour la signature de la convention d’établissement de la <b> $type_media $nom </b>.", "Veuillez vous connecter pour valider le rendez-vous."],

        "signature_agrement" => ["Bonjour Mme/Mr","Votre agrément signé est disponible sur la plateforme.", "Veuillez vous connecter afin de le télécharger et pour plus d’informations"],

        "annulation_rdv" => ["Bonjour Mme/Mr","Votre rendez-vous pris pour le ".dateFormat($media ? $media->date : "")." a été annuler","Veuillez vous connecter pour choisir une autre date."],

        "rejet_paiement_cahier_de_charge_montant_incorrect" => ["La transaction ne correspond pas au montant forfaitaire.","Prière de bien vouloir recommencer.","Veuillez vous connecter via ce lien."],

        "rejet_paiement_cahier_de_charge_autre" => ["La division des affaires financières du ministère de l’information et de la communication a rejeté votre paiement pour motif suivant <b> $motif </b>","Veuillez refaire le paiement pour continuer le processus de demande d'agrément.","Veuillez vous connecter via ce lien."],

        "validation_paiement_cahier_de_charge_autre" => ["La division des affaires financières du ministère de l’information et de la communication a validé votre paiement.", "Votre cahier des charges pour  la <b> $type_media $nom </b> est maintenant disponible sur la plateforme.", "Veuillez vous connecter pour plus d'informations."],

        "validation_recu_de_paiement_agrement" => ["Votre reçu a été validé.","Votre projet d'agrément est en cours de préparation par la Direction Nationale de la Communication et des Relations avec les Médias Privés (DNCRMP)."],

        "rejet_recu_de_paiement_agrement" => ["Le réçu de paiement que vous aviez importé a été rejeté par la direction nationale de la communication et des relations avec les medias privées.", "Veuillez vous connecter pour plus d'informations."],

        "mot_de_passe_oublier" => ["Pour mettre à jour votre mot de passe", "Veuillez cliquer le lien"],

        "information_create_media" => ["Merci de recevoir l'information portant sur de la création d'une nouvelle [type media] [commerciale/Comminautaire] nommé: [Media] "]
    ];

    return $message_emails[$attribut_message];
}
