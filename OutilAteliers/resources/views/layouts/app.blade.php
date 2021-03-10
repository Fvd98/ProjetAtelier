<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/needim/noty/77268c46/lib/noty.min.js"></script>
    <script src="{{ asset('js/jquery.unobtrusive-ajax.js') }}"></script>
    <script src="{{ asset('../vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.rawgit.com/needim/noty/77268c46/lib/noty.css" />  
</head>
<body style="background-image: url('{{ asset('Design_Black.png') }}'); background-size:17.3vh 10vh; background-position-x:7vw; overflow-x:hidden;background-attachment: fixed; padding:0;">
    <div style="background-image:linear-gradient(rgba(0,0,0,0),rgba(123, 69, 169, 0.8)); padding:0 2.5vw;">
        <nav style="min-height:50px;border-color:#101010;" class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
            <div style="margin:0; max-width:initial;padding: 0;" class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span style="margin-right:7px; font-size: 22px;" class="fa fa-home"></span>{{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item"><a class="nav-link" style="cursor:pointer;" onclick="AjaxFill('{{ route('atelier_horaires.index') }}', '#app', true)">Ateliers</a></li>
                            @if(Auth::user()->isAdmin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                    Administation
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" style="cursor:pointer;" onclick="AjaxFill('{{ route('ateliers.index') }}', '#app', true)">Ateliers</a>
                                    <a class="dropdown-item" style="cursor:pointer;" onclick="AjaxFill('{{ route('users.index') }}', '#app', true)">Utilisateurs</a>
                                    <a class="dropdown-item" style="cursor:pointer;" onclick="AjaxFill('{{ route('programmes.index') }}', '#app', true)">Programmes</a>
                                    <a class="dropdown-item" style="cursor:pointer;" onclick="AjaxFill('{{ route('etablissements.index') }}', '#app', true)">Établissements</a>
                                </div>
                            </li>
                            @endif
                        </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" style="cursor:pointer" onclick="AjaxFill('register', '#ModalContainer', false);">{{ __('S\'inscrire') }}<span style="margin-left:7px;" class="fa fa-user-plus"></span></a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="cursor:pointer" onclick="AjaxFill('login', '#ModalContainer', false);">{{ __('Se connecter') }}<span style="margin-left:7px;" class="fa fa-sign-in"></span></a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" style="cursor:pointer;" onclick="AjaxFill('{{ route('users.show', ['user' => Auth::id()]) }}', '#app', true)">Bonjour {{ Auth::user()->prenom }} <span style="margin-left:7px;" class="fa fa-user-circle"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Se déconnecter') }}<span style="margin-left:7px;" class="fa fa-sign-out"></span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>                                                      
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="body-content" style="width:100%; padding:15px; min-height: calc(100vh - 51px);background-color: rgba(255,255,255,0.8); position:relative;padding-bottom:60px;"> 
            <main id="app">
                @yield('content')
            </main>

            <footer style="bottom:0; position:absolute; width: calc(100% - 30px);">
                <hr style="margin-top:5px;" />
                <p style="float:left">&copy; 2018 - Inscription aux ateliers</p>
            </footer>
            <div style="background-image: url('{{ asset('Logo.png') }}'); position:absolute;bottom:5px; right:15px; width:162.04px; height:35px; background-size: 162.04px 35px;"></div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div id="ModalContainer" class="modal-content">
             
            </div>
        </div>
    </div>
    <div id="temp" style="display:none;"></div>
</body>
</html>
<script>
    function ShowErrors(ErrorMessagesJSON)
    {
        var ErrorObject = JSON.parse(ErrorMessagesJSON);
        Object.keys(ErrorObject.errors).forEach(key => {
            $("#invalid-" + key).text(ErrorObject.errors[key].slice(ErrorObject.errors[key].indexOf(',')));
            $("#" + key).addClass("is-invalid");
        });
    }

    function ClearErrors()
    {
        $(".is-invalid").each(function()
        {
            $(this).removeClass("is-invalid");
        });
    }

    function AjaxFill(URL, IDBalise, isAlert, callback) {
        $.ajax({
            url: URL,
            type: "GET",
            cache: false,
            success: function (data, status) {
                $(IDBalise).html(data);
                if (IDBalise == "#ModalContainer") {
                    $("#myModal").modal({ backdrop: true });
                }
                if (typeof (callback) === typeof (Function)) {
                    callback();
                }
            },
            error: function (data, status, error) {
                if (isAlert) {
                    Alert('error', data.responseText)
                }
                else {
                    switch(data.status)
                    {
                        case 401:
                            AjaxFill('log33in', '#ModalContainer', false);
                            break;
                        case 404:
                            AjaxFill('{{ route('404') }}', '#app', false);
                            break;

                    }
                }
            }
        });
    }

    function Ajax(URL, Success, Error)
    {
        $.ajax({
            url: URL,
            type: "GET",
            cache: false,
            success: Success,
            error: Error
        });
    }

    function UpFileForm(This, success, error) {
        var Form = $(This);
        $.ajax({
            type: "POST",
            url: Form.attr("action"),
            data: new FormData(This),
            contentType: false,
            cache: false,
            processData: false,
            success: success,
            error: error
        });
    }

    function CloseModal() {
        $('#myModal').modal('toggle');
    }

    function Alert(type, text) {
        var icone;
        switch(type)
        {
            case 'success':
                icon = 'check-circle'
            break;
            case 'error':
                icon = 'exclamation-circle'
            break;
            default:
                icon = 'question-circle'
            break;

        }

        new Noty({
            type: type, //alert (default), success, error, warning, info
            layout: 'topRight', //top, topLeft, topCenter, topRight (default), center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight
            theme: 'metroui', //relax, mint (default), metroui
            text: '<div style="display:flex;"><div style="width:15%; font-size:25px; line-height:25px; margin-right:7px;" class="fa fa-'+icon+'"></div><div style="flex-grow:1; line-height:25px; font-size:16px; float:left;">' + text + '</div></div>',
            timeout: 4000,
            progressBar: true, //Default, progress before fade out is displayed
        }).show();
    }

    function KeepOpen(idCollapse, idFill){
        
        $(idFill).html($('#temp').html());
        $(idCollapse).addClass('show');
    }

    function TextAreaAdjust(o) {
        o.style.height = "1px";
        o.style.height = (25 + o.scrollHeight) + "px";
    }

    function TextAreasAdjust() {
        $('textarea').each(function() {
            $(this).css('height', '1px');
            $(this).css('height', (35 + this.scrollHeight) + 'px');    
        })
    }
    // Source: https://stackoverflow.com/questions/17461682/calling-a-function-on-bootstrap-modal-open
    $("#myModal").on('shown.bs.modal', function (e) {
        if ($(e.target).html().includes('textarea')) {
            TextAreasAdjust();
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function CKReplace()
    {
        CKEDITOR.replace( 'summary-ckeditor', {
            language: 'fr'
        });

        CKEDITOR.replace( 'summary-ckeditor2', {
            language: 'fr'
        });
    }
</script>
@yield('Scripts')