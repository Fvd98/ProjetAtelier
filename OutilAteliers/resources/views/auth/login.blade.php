<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Se connecter') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('login') }}" data-ajax-success="location.reload();" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
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
            <label for="password">{{ __('Mot de passe') }}</label>

                <input id="password" name="password" type="password" class="form-control" />

                <span class="invalid-feedback" role="alert">
                    <strong id="invalid-password"></strong>
                </span>
        </div>

        <!-- SE SOUVENIR DE MOI -->
        <div class="form-group row">
            <div class="form-check">
                <input id="remember" name="remember" type="checkbox" class="form-check-input" />

                <label class="form-check-label" for="remember">
                    {{ __('Se souvenir de moi?') }}
                </label>
                
            </div>              
        </div>
        <div class="form-group row">
            @if (Route::has('password.request'))
                <a href="javascript:void(0)" style="cursor:pointer;" onclick="AjaxFill('{{ route('password.request') }}', '#ModalContainer', false)">{{ __('Oublié mot de passe?') }}</a>
            @endif
            </div>
        <div class="form-group row"> 
            <input value="Se connecter" type="submit" style="margin-top:14px;"  class="btn btn-primary form-control"  />
        </div>                 
    </form>
</div>