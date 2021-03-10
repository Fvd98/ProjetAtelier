<h2 style="display:flex;flex-wrap:wrap;">Liste des établissements<div style="text-align:right;flex-grow:1;"><span style="text-align:center; width: 256px;" class="btn btn-primary" onclick="AjaxFill('{{ route('etablissements.create') }}', '#ModalContainer', false);">Ajouter un établissement</span></div></h2>
@if ($Etablissements->count() == 0)
    <br />
    <br />
    <br />
    <br />
    <p style="font-weight:bold; font-size:20px; text-align:center;">Aucun établissement...</p>
    <br />
@else
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Adresse</th>
                <th scope="col" style="text-align:center;"><span class="fa fa-cog"></span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Etablissements as $Etablissement)
                <tr>
                    <td>{{ $Etablissement->nom }}</td>
                    <td>{{ $Etablissement->adresse }}</td>
                    <td style="width: 256px; padding-top: 0.25rem;">
                        <div style="display:flex; flex-wrap:wrap;">
                            <span style="flex-grow:1; margin-left: 3.5px; margin-top:3.5px" class="btn btn-outline-warning" onclick="AjaxFill('{{ route('etablissements.edit', ['etablissement' => $Etablissement->id]) }}', '#ModalContainer', true);"><span style="margin-right:7px;" class="fa fa-pencil"></span>Modifier</span>
                            <a style="flex-grow:1; margin-left: 3.5px; margin-top:3.5px" class="btn btn-outline-danger" data-ajax-url="{{ route('etablissements.destroy', ['etablissement' => $Etablissement->id]) }}" data-ajax="true" data-ajax-method="DELETE" data-ajax-success="Alert('success',xhr.responseText);AjaxFill('{{ route('etablissements.index') }}', '#app', false);" data-ajax-failure="Alert('error', 'Oups! une erreur est survenue...')"><span style="margin-right:7px;" class="fa fa-trash"></span>Supprimer</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
