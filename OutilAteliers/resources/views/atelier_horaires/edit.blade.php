<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Modifier un horaire') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('atelier_horaires.update', ['atelier_horaire' => $AtelierHoraire->id]) }}" data-ajax-success="CloseModal();Alert('success',xhr.responseText);AjaxFill('{{ route('ateliers.index') }}', '#app', false);" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:90%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

       <!-- DATE DE L'ATELIER -->
       <div class="form-group row">
            <label for="dateAtelier">{{ __('Date et heure de l\'atelier') }}</label>

            <input id="dateAtelier" name="dateAtelier" value="{{ date("Y-m-d\TH:i:s", strtotime($AtelierHoraire->dateAtelier)) }}" type="datetime-local" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-dateAtelier"></strong>
            </span>
        </div>

        <!-- DURATION -->
        <div class="form-group row">
            <label for="duration">{{ __('Durée de l\'atelier') }}</label>

            <input class="without form-control" type="time" id="duration" name="duration" value="{{ date("H:i:s", strtotime($AtelierHoraire->duration)) }}" step="60">

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-duration"></strong>
            </span>
        </div>

        <!-- ETABLISSEMENT -->
        <div class="form-group row">
                <label for="etablissement_id">{{ __('Lieu (Établissement)') }}</label>

                <select id="etablissement_id" name="etablissement_id" value="{{ $AtelierHoraire->etablissement_id }}" type="text" class="form-control">
                    @foreach ($Etablissements as $Etablissement)         
                        <option value="{{$Etablissement->id}}">{{$Etablissement->nom}}</option>
                    @endforeach
                </select>

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-description"></strong>
                </span>
        </div>

        <!-- SALLE/LOCAL -->
        <div class="form-group row">
            <label for="salle_local">{{ __('Lieu (Salle/Local)') }}</label>

            <input id="salle_local" name="salle_local" value="{{ $AtelierHoraire->salle_local }}" type="text" class="form-control" />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-salle_local"></strong>
            </span>
        </div>

        <!-- NOMBRE DE PLACE -->
        <div class="form-group row">
            <label for="nombrePlace">{{ __('Nombre de place') }}</label>

            <input id="nombrePlace" name="nombrePlace" value="{{ $AtelierHoraire->nombrePlace }}" type="text" class="form-control" />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-nombrePlace"></strong>
            </span>
        </div>

        <!-- _METHODE -->
        <input name="_method" value="PUT" type="hidden" />

        <div class="form-group row">           
            <input value="Modifier" type="submit" style="margin-top:14px;" class="btn btn-primary form-control"  />
        </div>                 
    </form>
</div>