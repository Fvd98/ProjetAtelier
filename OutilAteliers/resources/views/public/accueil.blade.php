@extends('layouts.app')
@section('content')
    <div style="position: relative;text-align: center;color: white;top:15px; ">
        <div style="background-image:url('{{ asset('Cegep.PNG') }}'); width: 95%; height:550px; background-size:100% 100%; margin:auto;"></div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:50px; text-shadow: 5px 5px 3px black;">Outil d'inscription aux ateliers du Cégep de l'Outaouais</div>
    </div>
    <br /><br />
    <h2 style="text-align:center;">Présentation de l'application</h2>
    <div class="row" style="margin:10px; font-size:16px;">
        <div class="col-md-6" style="border-right:1px solid rgba(123, 69, 169, 0.5); border-top:1px solid rgba(123, 69, 169, 0.5); padding:10px;">
            <p>Bienvenue sur l'outil d'inscription aux ateliers du Cégep de l'Outaouais produit dans le cadre du cours Base de données II de la technique en informatique de gestion par l'équipe « Pharmascript ».</p>
            <p>Cet outil vous permettra de consulter la liste des ateliers qui seront disponibles pendant la semaine des Sciences Humaines et de vous y inscrire.</p>
        </div>
        <div class="col-md-6" style="border-top:1px solid rgba(123, 69, 169, 0.5); padding:10px;">
            <p>Membres de l'équipe de développement :</p>
            <ul>
                <li>
                    Marika Groulx ;
                </li>
                <li>
                    Francis Vermette-David.
                </li>
            </ul>
        </div>
    </div>
@endsection

@isset($token)
    @section('Scripts')
        <script>
            AjaxFill('{{route('password.reset', ['token' => $token])}}', '#ModalContainer', false, function() { $("#token").val('{{$token}}'); } );
        </script>
    @endsection
@endisset
