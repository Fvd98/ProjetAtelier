<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Modifier un atelier') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('ateliers.update', ['atelier' => $Atelier->id]) }}" data-ajax-success="CloseModal();Alert('success',xhr.responseText);AjaxFill('{{ route('ateliers.index') }}', '#app', false);" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:90%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

       <!-- NOM -->
       <div class="form-group row">
            <label for="nom">{{ __('Nom') }}</label>

            <input id="nom" name="nom" value="{{ $Atelier->nom }}" type="text" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-nom"></strong>
            </span>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group row">
                <label for="description">{{ __('Description') }}</label>

                <textarea id="summary-ckeditor" name="description" type="text" class="form-control">{!! $Atelier->description !!}</textarea>

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-description"></strong>
                </span>
        </div>

        <!-- NOM COMPLET DU RESPONSABLE -->
        <div class="form-group row">
            <label for="nomCompletResponsable">{{ __('Nom complet du responsable') }}</label>

            <input id="nomCompletResponsable" name="nomCompletResponsable" value="{{ $Atelier->nomCompletResponsable }}" type="text" class="form-control" />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-nomCompletResponsable"></strong>
            </span>
        </div>

        <!-- DESCRIPTION DU RESPONSABLE -->
        <div class="form-group row">
            <label for="description_responsable">{{ __('Description du responsable') }}</label>

            <textarea id="summary-ckeditor2" name="description_responsable" type="text" class="form-control">{{ $Atelier->description_responsable }}</textarea>

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-description_responsable"></strong>
            </span>
        </div>

        <!-- _METHODE -->
        <input name="_method" value="PUT" type="hidden" />

        <div class="form-group row">           
            <input value="Modifier" type="submit" style="margin-top:14px;" class="btn btn-primary form-control"  />
        </div>                 
    </form>
</div>
<script>CKReplace();</script>