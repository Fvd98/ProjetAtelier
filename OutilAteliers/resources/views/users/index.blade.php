<h2 style="display:flex;flex-wrap:wrap;">Liste des utilisateurs<div style="text-align:right;flex-grow:1;"><span style="text-align:center; width: 256px;" class="btn btn-primary" onclick="AjaxFill('{{ route('users.create') }}', '#ModalContainer', false);">Ajouter un utilisateur</span></div></h2>
@if ($Users->count() == 0)
    <br />
    <br />
    <br />
    <br />
    <p style="font-weight:bold; font-size:20px; text-align:center;">Aucun utilisateur...</p>
    <br />
@else
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>             
                <th scope="col">Courriel</th>
                <th scope="col">Numéro étudiant</th>
                <th scope="col">Nom</th>
                <th scope="col">Programme</th>
                <th scope="col">Administrateur</th>
                <th scope="col" style="text-align:center;"><span class="fa fa-cog"></span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Users as $User)
                <tr>
                    <td>{{ $User->courriel }}</td>
                    <td>{{ $User->numero }}</td>
                    <td>{{ $User->prenom.' '.$User->nom }}</td>
                    <td>{{ $User->programme!=null?$User->programme->nom:"Aucun" }}</td>
                    <td style="text-align: center;"><span style="color:{{ $User->isAdmin?"green":"red" }}; font-size:15px;" class="fa fa-{{ $User->isAdmin?"check":"times" }}"></span></td>
                    <td style="width: 256px; padding-top: 0.25rem;">
                        <div style="display:flex; flex-wrap:wrap;">
                            <span style="flex-grow:1; margin-left: 3.5px; margin-top:3.5px" class="btn btn-outline-warning" onclick="AjaxFill('{{ route('users.edit', ['user' => $User->id, 'profil' => false]) }}', '#ModalContainer', true);"><span style="margin-right:7px;" class="fa fa-pencil"></span>Modifier</span>
                            <a style="flex-grow:1; margin-left: 3.5px; margin-top:3.5px" class="btn btn-outline-danger" data-ajax-url="{{ route('users.destroy', ['user' => $User->id]) }}" data-ajax="true" data-ajax-method="DELETE" data-ajax-success="Alert('success',xhr.responseText);AjaxFill('{{ route('users.index') }}', '#app', false);" data-ajax-failure="Alert('error', 'Oups! une erreur est survenue...')"><span style="margin-right:7px;" class="fa fa-trash"></span>Supprimer</a>
                        </div>     
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

