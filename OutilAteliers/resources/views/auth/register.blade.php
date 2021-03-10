<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('S\'enregister') }}</h2>
<div class="card-body">
    <form action="{{ route('register') }}" data-ajax-url="register" data-ajax="true" data-ajax-method="POST" data-ajax-success="location.reload();" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

        <!-- COURRIEL -->
        <div class="form-group row">
            <label for="courriel">{{ __('Courriel') }}</label>

            <input id="courriel" name="courriel" type="email" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-courriel"></strong>
            </span>
        </div>

        <!-- NUMÉRO -->
        <div class="form-group row">
                <label for="numero">{{ __('Numéro') }}</label>

                <input id="numero" name="numero" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-numero"></strong>
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

        <!-- PRÉNOM -->
        <div class="form-group row">
                <label for="prenom">{{ __('Prénom') }}</label>

                <input id="prenom" name="prenom" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-prenom"></strong>
                </span>
        </div>

        <!-- NOM -->
        <div class="form-group row">
                <label for="nom">{{ __('Nom') }}</label>

                <input id="nom" name="nom" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-nom"></strong>
                </span>
        </div>

        <!-- PROGRAMME ID -->
        <div class="form-group row">
                <label for="programme_id">{{ __('Programme') }}</label>

                <select id="programme_id" name="programme_id" type="dropdown" class="form-control">
                        @foreach ($Programmes as $item)
                            <option value="{{$item->id}}" >{{$item->nom}}</option>
                        @endforeach
                </select>

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-programme_id"></strong>
                </span>
        </div>
        <div class="form-group row">             
            <input value="S'enregister" type="submit" style="margin-top:14px;" class="btn btn-primary form-control" />
        </div>
    </form>
</div>
