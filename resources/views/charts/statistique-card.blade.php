
<div class="col-lg col-6">
    <div class="small-box bg-danger text-white">
        <div class="inner">
            <h3 class="nombreMediaAttente">{{$nbMediaCreer}}</h3>
            <p>Médias en cours de création</p><br>
        </div>
        <div class="icon">
            <i class="fas fa-broadcast-tower"></i>
        </div>
  </div>
</div>

<div class="col-lg col-6">
    <div class="small-box bg-orange">
        <div class="inner text-white">
            <h3 class="nombreMediaAttente">{{$en_attente}}</h3>
            <p>Medias en attente de validation <br> (Paiement cahier des charges)</p>
        </div>
        <div class="icon">
            <i class="fas fa-pause"></i>
        </div>
  </div>
</div>

<div class="col-lg col-6">
    <div class="small-box bg-yellow">
        <div class="inner text-white">
            <h3 class="nombreMediaAttente">{{$fraisAgrementAttente}}</h3>
            <p>Paiement de frais d’agrément en attente <br></p>
        </div>
        <div class="icon">
            <i class="fas fa-pause"></i>
        </div>
  </div>
</div>

<div class="col-lg col-6">
    <div class="small-box" style="background-color: rgb(230, 126, 0)">
        <div class="inner text-white ">
            <h3 class="nombreMediaEnCours">{{$en_cours}} </h3>
            <p>Médias en cours d’examination</p><br>
        </div>
        <div class="icon">
            <i class="fas fa-sync-alt"></i>
        </div>
        {{-- <select class="form-control small-box-footer" wire:model='filterEncours'>
            <option value="" selected>Tout</option>
            <option value="Commission" >Commission</option>
            <option value="Hac" >Hac</option>
        </select> --}}
    </div>
</div>


<div class="col-lg col-6">
    <div class="small-box bg-success">
        <div class="inner text-white">
            <h3>{{$agree}} </h3>
            <p>Média agrée</p><br>
        </div>
        <div class="icon">
            <i class="fa fa-check-circle"></i>
        </div>
        {{-- <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-righ"></i></a> --}}
    </div>
</div>
