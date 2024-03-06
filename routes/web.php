<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\notificationUsers;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\SGGController;
use App\Http\Controllers\{ARTVController, ParametrageController,SignatureController, DisponibiliteController, MeetingController,MembreCommissionController};

use App\Http\Controllers\PaiementController;
use App\Http\Controllers\profileUtilisateur;
use App\Http\Livewire\{
    RolePermission,
    Utilisateurs,
    AddUtilisateur,
    AsignationRolePermission,
    ChronologieMediaComponent,
    CodeMarchandComponent,
    DashoardComponent,
    EtudeDocumentComponent,
    FormeJuridique,
    GestionDelaisTraitementComponent,
    GestionDetailPromoteurComponent,
    GestionMediaComponent,
    MediaPromoteur,
    GestionRapportCommissionComponent,
    GestionStatistiqueComponent,
    MembreCommission,
    Messages,
    ModifierProjetAgrementComponent,
    PayementMontant,
    Stepper,
    TypeDocuments,
    TypeMedia,
    TypesPaiement,
    PageNotPermissionComponent,
};
Route::get('/email_verified', function () {
    return view('auth.verify');
})->name('email_verified');

/* Route::get('files', [UserController::class, 'files'])->name('files');  */

Route::get('get_new_password_user_active/{number}', [UserController::class, 'get_new_password_user_active'])->name('get_new_password_user_active');

Route::get('/prefectures', [ARTVController::class, 'getPrefectures'])->name('prefectures');
Route::get('/communes', [ARTVController::class, 'getCommunes'])->name('communes');

Route::get('get_new_password/{number}', [UserController::class, 'get_new_password'])->name('get_new_password');
Route::get('save_new_password/{email}', [UserController::class, 'save_new_password'])->name('save_new_password');
Route::post('save_email', [UserController::class, 'save_email'])->name('save_email');

Route::get('/inscription', [UserController::class, 'formAddPromoteur'])->name('inscription');
Route::post('/enregistrement_promoteur', [UserController::class, 'inscriptionPromoteur'])->name('enregistrement_promoteur');

Route::middleware(['auth', 'permission','statusCompte'])->group(function () {
    Route::get('/',DashoardComponent::class, 'index')->name('home');
    Route::get('/statistique',GestionStatistiqueComponent::class, 'index')->name('statistique');
    Route::get('chronologie-media/{id}',ChronologieMediaComponent::class)->name('chronologie-media');
    Route::get('/mes-medias', MediaPromoteur::class)->name('mesmedias');
    Route::get('/edit-projet-agrement/{id}', ModifierProjetAgrementComponent::class)->name('edit-projet-agrement');
    Route::get('page-not-permission',PageNotPermissionComponent::class)->name('page-not-permission');
    // Route Utilisateur livewire save-agrement-signer
    Route::get('liste-medias',GestionMediaComponent::class, 'index')->name('liste-medias');

    // Route Utilisateur livewire
    Route::get('/detail-media/{id}', GestionDetailPromoteurComponent::class)->name('detail-media');
    Route::get('liste-medias',GestionMediaComponent::class, 'index')->name('liste-medias');
    Route::get('/etude-document/{id}', EtudeDocumentComponent::class)->name('etude-document');
    Route::get('rapport-commission/{id}/{type_commission}',GestionRapportCommissionComponent::class, 'index')->name('rapport-commission');

    // Route::resource('messages', MessageController::class);

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::any('/details-media/{id}', [MediaController::class, 'details'])->name('details');
    Route::any('/detele-medias', [MediaController::class, 'detele_medias'])->name('detele_medias');

    Route::get('recu-paiement-cahier-charge/{id}', [MediaController::class, 'recu_paiement_cahier_charge'])->name('recu-paiement-cahier-charge');
    Route::get('description-type-document/{id}', [MediaController::class, 'description_type_document'])->name('description-type-document');
    Route::post('activeStepper', [MediaController::class, 'activeStepper'])->name('activeStepper');
    Route::get('/description-media/{id}', [MediaController::class, 'showDescription'])->name('description-media');
    Route::put('/update-media/{id}', [MediaController::class, 'update'])->name('update-media');
    Route::get('/edit-media/{id}', [MediaController::class, 'getMediaById'])->name('edit-media');
    Route::post('/save-media', [MediaController::class, 'save'])->name('save-media');
    Route::post('/save-paiement-cahier-charge', [MediaController::class, 'save_paiement_cahier_charge'])->name('save-paiement-cahier-charge');
    Route::post('/save-importation-document-technique', [MediaController::class, 'save_importation_document_technique'])->name('save-importation-document-technique');
    Route::post('/depot-dossier-technique', [MediaController::class, 'soumissionDossier'])->name('depot-dossier-technique');
    Route::post('/confirme-rendez-vous', [MediaController::class, 'confirmerRendezVous'])->name('confirme-rendez-vous');

    Route::get('/mes-medias/{id}', [MediaController::class, 'details'])->name('details-medias');



    Route::get('/medias', [MediaController::class, 'listeMedia'])->name('liste_media');
    Route::get('/medias/agres', [MediaController::class, 'mediasAgres'])->name('medias_agres');

    Route::get('/mes-medias/{id}/processus', [MediaController::class, 'processus'])->name('processus');
    Route::get('/api/medias/{id}', [DossierController::class, 'detailsMedia'])->name('api_details-medias');

    Route::get('document-by-id/{id}', [MediaController::class, 'document_by_id'])->name('document-by-id');

    Route::get('show-projet-agrement/{id}', [MediaController::class, 'show_projet_agrement'])->name('show-projet-agrement');
    Route::post('/mes-medias/{id}/import-document-technique', [MediaController::class, 'importationDocumentTechnique'])->name('importation_document_technique')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/documents/{id}/supprimer', [MediaController::class, 'suppressionDocumentTechnique'])->name('suppression_dossier')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/mes-medias/{id}/depot-dossier', [MediaController::class, 'depotDossier'])->name('depot_dossier')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/documents/{id}/validation', [MediaController::class, 'validationDocumentTechnique'])->name('validation_document_technique')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/paiement-frais-agrement', [MediaController::class, 'paiementFraisAgrement'])->name('paiement-frais-agrement');
    Route::get('/medias/{id}/etudes-documents', [MediaController::class, 'etudeDocuments'])->name('etude_documents_techniques');
    Route::post('/medias/{id}/validation-etudes-documents', [MediaController::class, 'validationEtudeDocumentsTechniques'])->name('validation_etude_documents_techniques')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/medias/{id}/terminer-etude-documents', [MediaController::class, 'terminerEtudeDocumentsTechniques'])->name('terminer_etude_documents_techniques')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route::post('/documents/{id}/remplacer', [MediaController::class, 'remplacerDocument'])->name('remplacer_document')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    // PAIEMENTS
    Route::get('/paiements/cahier-de-charges', [PaiementController::class, 'paiementsCahierCharges'])->name('paiements_cahier_charges');
    Route::get('/paiements/cahier-de-charges/filtre/{statut}', [PaiementController::class, 'filtrePaiementsCahierCharges'])->name('filtres_paiements_cahier_charges');
    Route::get("code-paiement", CodeMarchandComponent::class)->name('codeMarchant');


    Route::post('/mes-medias/{id}/paiement-cahier-charge', [PaiementController::class, 'enregistrementPaiementCahierCharge'])->name('paiement_cahier_charge')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/mes-medias/{id}/paiement-cahier-charge', [PaiementController::class, 'paiementCahierCharger'])->name('form_paiement_cahier_charge');
    Route::post('/paiements/paiement-cahier-charge/{id}/validation', [PaiementController::class, 'validationPaiementCahierCharger'])->name('validation_paiement_cahier_charge')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/mes-medias/{id}/paiement-frais-agrement', [PaiementController::class, 'paiementFraisAgrement'])->name('paiement_frais_agrement')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    Route::get('/paiements/frais-agrement/en-attente', [PaiementController::class, 'fraisAgrementEnAttente'])->name('frais_agrement_en_attente');
    Route::get('/paiements/frais-agrement/acceptes', [PaiementController::class, 'fraisAgrementAcceptes'])->name('frais_agrement_acceptes');
    Route::get('/paiements/frais-agrement/rejetes', [PaiementController::class, 'fraisAgrementRejetes'])->name('frais_agrement_rejetes');

    Route::get('/dossiers/en-cours-etude', [DossierController::class, 'dossiersEnCoursEtude'])->name('dossiers_en_cours_etude');
    // Route::get('/dossiers/acceptes', [DossierController::class, 'dossiersAcceptes'])->name('dossiers_acceptes');
    Route::get('/dossiers/rejetes', [DossierController::class, 'dossiersRejetes'])->name('dossiers_rejetes');

    // redaction du rapport de la Hac
    // Route::post('/dossiers/redaction-rapport-commission',[DossierController::class,'postRedactionRapport'])->name('post-redaction-rapport-commission');
    Route::get('/dossiers/redaction-rapport-hac/{dosser_id}/hac',[DossierController::class,'redactionRapportView'])->name('redaction-rapport-hac');

    //Membre de commission
    Route::post('/membres/commissions',[MembreCommissionController::class,'store'])->name('membre-commission-store');
    Route::get('/membres/commissions/create',[MembreCommissionController::class,'create'])->name('membre-commission-create');
    Route::get('/membres/commissions/{id}/edit',[MembreCommissionController::class,'edit'])->name('membre-commission-edit');
    Route::get('/membres/commissions/delete',[MembreCommissionController::class,'destroy'])->name('membre-commission-destroy')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/membres/commissions/{id}',[MembreCommissionController::class,'update'])->name('membre-commission-update');
    Route::post('/membres/commissions-store',[MembreCommissionController::class,'storeMembreForCommission'])->name('membre-commission-presence');
    Route::get('/membres/commissions/list',MembreCommission::class)->name('membre-commission-index');

    // AGRÉMENT
    Route::get('/demandes-agrement', [SGGController::class, 'demandesAgrement'])->name('demandes_agrement');
    Route::post('/demandes-agrement/{id}/agree', [SGGController::class, 'agreeMedia'])->name('agree_media')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/medias-agrees', [SGGController::class, 'mediasAgrees'])->name('medias_agrees');

    Route::get('/demandes-agrement/agree', [SGGController::class, 'listeMedias'])->name('liste_medias_sgg');
    Route::get('/medias/etudes/sgg/filtre/{statut}', [SGGController::class, 'filtreMedias'])->name('filtre_liste_medias_sgg');
    Route::get('/medias/rapports/{id}', [SGGController::class, 'rapports'])->name('rapport_hac_commission');


    // SIGNATURE AGREMENT

    Route::resource('disponibilites', DisponibiliteController::class);
    Route::post('/disponibilites/{uuid}/update', [DisponibiliteController::class, 'update']);

    Route::resource('meetings', MeetingController::class);
    Route::get('/meeting/{id}/signature', [SignatureController::class, 'importAgrementForm']);
    Route::get('/meeting/{id}/cancel', [SignatureController::class, 'meetingCancelForm']);
    Route::post('/meeting/{id}/cancel', [SignatureController::class, 'meetingCancelPost']);
    Route::get('/meeting/{id}/preview', [SignatureController::class, 'previewAgrementReiceip']);

    Route::get('/rendez-vous', [SignatureController::class, 'listeRendezVous'])->name('rendez_vous');
    Route::get('/create-programme', [SignatureController::class, 'createProgrammeForm']);

    Route::get('/rendez-vous/disponibles', [SignatureController::class, 'disponibles'])->name('rendez_vous_disponibles');

    Route::get('/rendez-vous/pris', [SignatureController::class, 'pris'])->name('rendez_vous_pris');
    Route::post('/rendez-vous/programme', [SignatureController::class, 'ajouterProgramme'])->name('ajouter_programme')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/rendez-vous/programme/{id}/supprimer', [SignatureController::class, 'supprimerProgramme'])->name('supprimer_programme')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/mes-medias/{id}/prise-rendez-vous', [SignatureController::class, 'priseRendezVous'])->name('prise_rendez_vous')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/rendez-vous/programme/{id}/confirmer-rendez-vous', [SignatureController::class, 'confirmerRendezVous'])->name('confirmer_rendez_vous')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/meeting/{id}/annuler', [SignatureController::class, 'annulerRendezVous'])->name('annuler_rendez_vous')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/meeting/{id}/signature', [SignatureController::class, 'signatureAgrement'])->name('signature_grement')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    ////Roles permissions
    Route::get('roles',RolePermission::class, 'index')->name('roles');
    Route::get('asigne-role-permission/{id}',AsignationRolePermission::class)->name('asigne-role-permission');
    Route::get('utilisateurs',Utilisateurs::class, 'index')->name('utilisateur');
    Route::get('add-utilisateurs',AddUtilisateur::class, 'index')->name('add-utilisateur');
    Route::get('/notifications', [notificationUsers::class, 'getAllNotificationsPromoteurs'])->name('notificationPromoteur');

    Route::get('/previewPromoteur/{id}', [notificationUsers::class, 'previewPromoteur'])->name('promoteur');
    Route::get('/dafPreview/{id}/', [notificationUsers::class, 'dafPreview']);
    Route::get('/previewCommission/{id}', [notificationUsers::class, 'previewCommission']);
    Route::get('/previewHAC/{id}', [notificationUsers::class, 'previewHAC']);
    Route::get('/previewDirection/{id}', [notificationUsers::class, 'previewDirectionMedias']);
    Route::get('/previewSGG/{id}', [notificationUsers::class, 'previewSGG']);
    Route::get('/previewRDV/{id}', [notificationUsers::class, 'previewRDV']);
    Route::get('/previewADMIN/{id}', [notificationUsers::class, 'previewADMIN']);

    Route::put('/notification/{id}/lecture', [notificationUsers::class,'notificationLus']);

    ////Roles permissions
    Route::get('roles',RolePermission::class, 'index')->name('roles');
    Route::get('types-media',TypeMedia::class, 'index')->name('types-media');
    Route::get('types-document',TypeDocuments::class, 'index')->name('types-document');
    Route::get('parametre-paiement',PayementMontant::class, 'index')->name('parametre-paiement');
    Route::get('types-paiement',TypesPaiement::class, 'index')->name('types-paiement');
    Route::get('types-paiement',TypesPaiement::class, 'index')->name('types-paiement');
    Route::get('messages',Messages::class, 'index')->name('messages');
    Route::get('forme-juridiques',FormeJuridique::class, 'index')->name('forme-juridiques');
    Route::get('steppers',Stepper::class, 'index')->name('steppers');
    Route::get('delais-traitement',GestionDelaisTraitementComponent::class, 'index')->name('delais-traitement');


    Route::get('cahier-de-charge',[ParametrageController::class, 'cahier_de_charge'])->name('cahier-de-charge');
    Route::post('save-cahier-de-charge',[ParametrageController::class, 'save_cahier_de_charge'])->name('save-cahier-de-charge');

    // Profile
    Route::get('/profile', [profileUtilisateur::class, 'profile'])->name("profile");
    Route::get('retour', [profileUtilisateur::class, 'calback'])->name('calBack');
    Route::get('/modificationProfile', [profileUtilisateur::class, 'updateProfile']);
    Route::put('/sauvegarder/{id}', [profileUtilisateur::class, 'sauvegarderModificationProfil']);
    Route::get('/ChangerMotDePasse',[profileUtilisateur::class, 'updatePasseword'])->name("updatePassword");
    Route::put('/ChangerMotDePasse', [profileUtilisateur::class, 'reinitialisationDuMotDePasse']);
    // activation/desactivation d'utilisateur

    Route::get('/isvalideuser', [UserController::class, 'isvalideuser'])->name('isvalideuser');
    //Dashboard
    Route::get('statistiques/en-attente/{niveau}', [HomeController::class, 'statistiquesAttente'])->name('statistiques-attente');
    Route::get('statistiques/en-etude/{niveau}', [HomeController::class, 'statistiquesEnEtude'])->name('statistiques-en-etude');
    Route::get('statistiques/rejetes/{niveau}', [HomeController::class, 'statistiquesRejetes'])->name('statistiques-rejete');
});

Auth::routes();
