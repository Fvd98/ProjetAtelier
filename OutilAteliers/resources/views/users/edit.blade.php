<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">Modifier {{ Auth::id()!=$User->id?'un utilisateur':'mon compte' }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('users.update', ['user' => $User->id]) }}" data-ajax-success="CloseModal();Alert('success',xhr.responseText);AjaxFill('{{ $Profil?route('users.show', ['user' => $User->id]):route('users.index') }}', '#app', false);" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

        <!-- COURRIEL -->
        <div class="form-group row">
            <label for="courriel">{{ __('Courriel') }}</label>

            <input readonly id="courriel" name="courriel" value="{{ $User->courriel }}" type="email" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-courriel"></strong>
            </span>
        </div>

        <!-- NUMÉRO -->
        <div class="form-group row">
                <label for="numero">{{ __('Numéro') }}</label>

                <input id="numero" name="numero" value="{{ $User->numero }}" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-numero"></strong>
                </span>
        </div>

        <!-- PRÉNOM -->
        <div class="form-group row">
                <label for="prenom">{{ __('Prénom') }}</label>

                <input id="prenom" name="prenom" value="{{ $User->prenom }}" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-prenom"></strong>
                </span>
        </div>

        <!-- NOM -->
        <div class="form-group row">
                <label for="nom">{{ __('Nom') }}</label>

                <input id="nom" name="nom" value="{{ $User->nom }}" type="text" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-nom"></strong>
                </span>
        </div>

        <!-- PROGRAMME ID -->
        <div class="form-group row">
                <label for="programme_id">{{ __('Programme') }}</label>

                <select id="programme_id"  name="programme_id" value="{{ $User->programme_id }}" type="dropdown" class="form-control">
                        @foreach ($Programmes as $item)
                            <option value="{{$item->id}}" >{{$item->nom}}</option>
                        @endforeach
                </select>

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-programme_id"></strong>
                </span>
        </div>

        @if(Auth::user()->isAdmin && Auth::id() != $User->id)
            <!-- EST UN ADMIN -->
            <div class="form-group row">
                <label for="isAdmin">{{ __('Administrateur') }}</label>

                <input name="isAdmin" type="checkbox" {{ $User->isAdmin?"checked":"" }} class="form-control" />
                        
                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-isAdmin"></strong>
                </span>
            </div>
        @endif

        <!-- _METHODE -->
        <input name="_method" value="PUT" type="hidden" />

        <div class="form-group row">           
            <input value="Modifier" type="submit" style="margin-top:14px;" class="btn btn-primary form-control" />
        </div>                 
    </form>
</div>