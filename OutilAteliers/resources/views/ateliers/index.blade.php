<h2 style="display:flex;flex-wrap:wrap;">Liste des ateliers<div style="text-align:right;flex-grow:1;"><a class="btn btn-primary" style="color:white;float:right;padding: 3.5px 9px; border-radius: 55px; line-height: 0px; margin-left:9px; margin-top: 7px;" data-ajax-url="{{ route('atelier_horaires.rappel') }}" data-ajax="true" data-ajax-method="POST" data-ajax-success="Alert('success', xhr.responseText)" data-ajax-failure="Alert('error', xhr.responseText)"><span style="font-size: 16px;" class="fa fa-envelope"></a></span><span style="text-align:center; width: 256px;" class="btn btn-primary" onclick="AjaxFill('{{ route('ateliers.create') }}', '#ModalContainer', false);">Ajouter un atelier</span></div></h2>
@if ($Ateliers->count() == 0)
    <br />
    <br />
    <br />
    <br />
    <p style="font-weight:bold; font-size:20px; text-align:center;">Aucun atelier...</p>
    <br />
@else
    <div style="height:7px;"></div>
    @foreach ($Ateliers->sortBy('nom') as $Atelier)
        <div style="box-shadow:rgba(86, 64, 158, 0.7) 0px 0px 10px 0px;border-radius: 4px;">
            <button class="btn btn-light" style="border:0;box-shadow:none;overflow:hidden;width:calc(100% - 102px); padding:6px; position:relative; border-radius:4px 0 0 4px; color: #745ac9;" data-toggle="collapse" data-target="#collapse_{{ $Atelier->id }}" aria-controls="collapse_{{ $Atelier->id }}">
            <span style="font-weight:bold; width: 100%; overflow:hidden; font-size:1.05em;">{{ $Atelier->nom }}</span>
            <div style="width:100px; height:100%;position:absolute; right:0px; top:0; font-size:10px; padding:2px 5px; float:right; background-image:linear-gradient(to right, rgba(255, 255, 255,0) , rgba(255, 255, 255,1) 80%);"></div>
            </button>
            <button title="Ajouter un horaire" onclick="AjaxFill('{{ route('atelier_horaires.create', ['atelier' => $Atelier->id]) }}', '#ModalContainer', false);" style="box-shadow:none;font-size: 15.12px; width:34px; border-radius: 0 4px 4px 0; float:right; border:0; text-align:center; padding:6px 0;" class="btn btn-primary btn-collapsible"><span class="fa fa-plus"></span></button>
            <button title="Modifier un atelier" onclick="AjaxFill('{{ route('ateliers.edit', ['atelier' => $Atelier->id]) }}', '#ModalContainer', false);" style="box-shadow:none;font-size: 15.12px; width:34px; border-radius: 0; float:right; border:0; text-align:center; padding:6px 0;" class="btn btn-primary btn-collapsible"><span class="fa fa-pencil"></span></button>
            <a title="Supprimer un atelier" data-ajax-url="{{ route('ateliers.destroy', ['atelier' => $Atelier->id]) }}" data-ajax="true" data-ajax-method="DELETE" data-ajax-success="Alert('success',xhr.responseText);AjaxFill('{{ route('ateliers.index') }}', '#app', false);" data-ajax-failure="Alert('error', 'Oups! une erreur est survenue...')" style="box-shadow:none;font-size: 15.12px; width:34px; border-radius: 0; float:right; border:0; text-align:center; padding:6px 0;color:white;" class="btn btn-primary btn-collapsible"><span class="fa fa-trash"></span></a>
        </div>
        <div class="collapse" id="collapse_{{ $Atelier->id }}">
            <div style="background-color: rgba(244, 240, 255, 0.5); margin:0 2px 2px 2px; padding: 0 15px 15px 15px;  border-radius: 0 0 4px 4px;">
                <div style="border: 0.5px solid #c9c2dc;padding: 8px;border-radius: 0 0 4px 4px;margin-bottom: 15px;background-color: #eae3ff;color: #403075;">
                    {!! $Atelier->description !!}
                </div>
                @if ($Atelier->atelier_horaires->count() ==0)                       
                    <p style="font-weight:bold; font-size: 14px; color: #47415d; text-align:center; margin:0; border-radius: 4px; background-color: #c3b7e8;">Aucun horaire pour cet atelier...</p>
                @else
                    <table class="ombre">
                        @foreach ($Atelier->atelier_horaires->sortBy('dateAtelier') as $Horaire)
                            <tr>
                                <td>
                                    @php
                                        //https://www.webdeveloper.com/forum/d/212775-converting-034554-format-time-into-seconds-quick-way-to-do-it
                                        list($h, $m, $s) = explode(':', $Horaire->duration);
                                        $timeSeconds = ($h * 3600) + ($m * 60) + $s;
                                    @endphp
                                    <span class="badge badge-dark" style="background-color:#56409e;width: 140px; margin-bottom: 4px; border-radius:3px;">{{ substr($Horaire->dateAtelier, 0, -3) }} à {{ substr(date("Y-m-d H:i:s", strtotime('+'. $timeSeconds .' seconds', strtotime($Horaire->dateAtelier))), -8, -3) }}</span>
                                    <span class="badge badge-dark" style="background-color:#56409e;width: 45px; border-radius:3px; margin-bottom: 4px;">{{ $Horaire->inscriptions->where('isCanceled', false)->where('meNotifier', false)->count() }} / {{ $Horaire->nombrePlace }}</span>
                                    <span style="color: #56409e; margin-left: 7px;">
                                        {{ $Horaire->etablissement->nom }} - {{ $Horaire->salle_local }}
                                    </span>
                                    <span title="Liste des étudiants inscrits" onclick="window.open('{{ route('inscriptions.index', ['atelier_horaire' => $Horaire->id]) }}', '_blank');event.stopPropagation();" style="float:right; font-size:10px; padding: 4px 3.5px; margin-top: 2px; color:white;" class="btn btn-primary fa fa-list"></span>
                                    <span title="Modifier l'horaire" onclick="AjaxFill('{{ route('atelier_horaires.edit', ['atelier_horaire' => $Horaire->id]) }}', '#ModalContainer', false);event.stopPropagation();" style="float:right; font-size:10px; padding:4px 4.5px; margin-top: 2px; margin-right:3px; margin-left:3.5px; color:white;" class="btn btn-primary fa fa-pencil"></span>
                                    <a title="Supprimer l'horaire" data-ajax-url="{{ route('atelier_horaires.destroy', ['atelier_horaire' => $Horaire->id]) }}" data-ajax="true" data-ajax-method="DELETE" data-ajax-success="AjaxFill('{{ route('ateliers.index') }}', '#app', false)" data-ajax-failure="Alert('error', xhr.responseText)" style="float:right; font-size:10px; padding:4px 5px; margin-top: 2px; color:white;" class="btn btn-primary fa fa-trash"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        <div style="height:7px;"></div>
    @endforeach
</div>
@endif
