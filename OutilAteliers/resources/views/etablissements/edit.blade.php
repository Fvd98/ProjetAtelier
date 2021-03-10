<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Modifier un programme') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('etablissements.update', ['etablissement' => $Etablissement->id]) }}" data-ajax-success="CloseModal();Alert('success',xhr.responseText);AjaxFill('{{ route('etablissements.index') }}', '#app', false);" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

        <!-- NOM -->
        <div class="form-group row">
            <label for="nom">{{ __('Nom') }}</label>

            <input id="nom" name="nom" value="{{ $Etablissement->nom }}" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-nom"></strong>
            </span>
        </div>

        <!-- ADRESSE -->
        <div class="form-group row">
            <label for="adresse">{{ __('Adresse') }}</label>

            <input id="adresse" name="adresse" value="{{ $Etablissement->adresse }}" class="form-control" />
            
            <span class="invalid-feedback" role="alert">
                <strong id="invalid-adresse"></strong>
            </span>
        </div>

        <!-- _METHODE -->
        <input name="_method" value="PUT" type="hidden" />

        <div class="form-group row">           
            <input value="Modifier" type="submit" style="margin-top:14px;" class="btn btn-primary form-control" />
        </div>                 
    </form>
</div>