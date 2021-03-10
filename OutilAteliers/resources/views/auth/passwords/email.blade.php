<br/>
<h2 style="text-align:center;padding: 10px 0;color: white;background-color: rgb(86, 64, 158);">{{ __('Oublié votre mot de passe?') }}</h2>
<div class="card-body">
    <form data-ajax-url="{{ route('password.email') }}" data-ajax-success="Alert('success', 'Le lien pour réinitialiser votre mot de passe vous a été envoyé par courriel.' );CloseModal();" data-ajax="true" data-ajax-method="POST" data-ajax-failure="if(xhr.responseText.includes('The given data was invalid.')){ ShowErrors(xhr.responseText); } else{ Alert('error', 'Oups! Une erreur s\'est produite...'); }" data-ajax-begin="ClearErrors();" style="width:50%; max-width:500px; margin:auto; margin-bottom:45px;">
        @csrf

        <!-- COURRIEL -->
        <div class="form-group row">
            <label for="courriel">{{ __('Courriel') }}</label>

            <input id="courriel" name="courriel" type="email" class="form-control" autofocus />

            <span class="invalid-feedback" role="alert">
                <strong id="invalid-courriel"></strong>
            </span>
        </div>

        <div class="form-group row"> 
            <input value="M'envoyer un courriel" type="submit" style="margin-top:14px;"  class="btn btn-primary form-control"  />
        </div>                 
    </form>
</div>
