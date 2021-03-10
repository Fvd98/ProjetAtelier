<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Description de l\'atelier') }}</h2>
<div class="card-body">
    <div style="width:90%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

       <!-- NOM -->
       <div class="form-group">         
            <h4 style="color:#56409e;text-align:center;" id="nom">{{ $Atelier->nom }}</h4>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <h5  style="color:#56409e" for="description">{{ __('Description') }}</h5>
            <div id="description">{!! $Atelier->description !!}</div>
        </div>

        <!-- NOM COMPLET DU RESPONSABLE -->
        <div class="form-group">
            <h5  style="color:#56409e" for="nomCompletResponsable">{{ __('Nom du responsable') }}</h5>

            <div id="nomCompletResponsable">{{ $Atelier->nomCompletResponsable }}</div>
        </div>

        <!-- DESCRIPTION DU RESPONSABLE -->
        <div class="form-group">
            <h5  style="color:#56409e" for="description_responsable">{{ __('Description du responsable') }}</h5>
            <div id="description_responsable">{!! $Atelier->description_responsable !!}</div>
        </div>
        
    </div>
</div>