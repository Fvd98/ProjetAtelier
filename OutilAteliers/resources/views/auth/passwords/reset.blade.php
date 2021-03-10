<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Réinitialiser le mot de passe') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('password.update') }}" data-ajax-success="location.replace('{{ route('Accueil') }}');" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

        <!-- COURRIEL -->
        <div class="form-group row">
            <label for="courriel">{{ __('Courriel') }}</label>

            <input id="courriel" name="courriel" type="email" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-courriel"></strong>
            </span>
        </div>

        <!-- MOT DE PASSE -->
        <div class="form-group row">
            <label for="motDePasse">{{ __('Mot de passe') }}</label>

            <input id="motDePasse" name="motDePasse" type="password" class="form-control" />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-motDePasse"></strong>
            </span>
        </div>

        <!-- CONFIRMER MOT DE PASSE -->
        <div class="form-group row">
            <label for="motDePasse-confirm">{{ __('Confirmer le mot de passe') }}</label>

            <input id="motDePasse-confirm" name="motDePasse_confirmation" type="password" class="form-control" />
        </div>

        <!-- TOKEN -->
        <input type="hidden" name="token" id="token">

        <div class="form-group row"> 
            <input value="Réinitialiser le mot de passe" type="submit" style="margin-top:14px;"  class="btn btn-primary form-control"  />
        </div>                 
    </form>
</div>
