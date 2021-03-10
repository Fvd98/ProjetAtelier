<h2 style="display:flex;flex-wrap:wrap;">Liste des ateliers<div style="text-align:right;flex-grow:1;"></div></h2>
@if ($AtelierHoraires->count() == 0)
    <br />
    <br />
    <br />
    <br />
    <p style="font-weight:bold; font-size:20px; text-align:center;">Aucun atelier...</p>
    <br />
@else
    <div style="height:7px;"></div>
    @foreach ($AtelierHoraires as $Etablissement => $Jours)
        <div style="box-shadow:rgba(86, 64, 158, 0.7) 0px 0px 10px 0px;">
            <button class="btn btn-light" style="border-radius:0;border:0;box-shadow:none;overflow:hidden;width: 100%; padding:6px; position:relative; color: #745ac9;" data-toggle="collapse" data-target="#collapse_{{ $Etablissement }}" aria-controls="collapse_{{ $Etablissement }}">
                <span style="font-weight:bold; width: 100%; overflow:hidden; font-size:1.05em;">{{ $Etablissement }}</span>
                <div style="width:100px; height:100%;position:absolute; right:0px; top:0; font-size:10px; padding:2px 5px; float:right; background-image:linear-gradient(to right, rgba(255, 255, 255,0) , rgba(255, 255, 255,1) 80%);"></div>
            </button>
        </div>
        <div class="collapse" id="collapse_{{ $Etablissement }}">
            <div style="background-color: rgba(244, 240, 255, 0.5); margin:0 2px 2px 2px; padding: 15px 25px 25px 25px;  border-radius: 0 0 4px 4px;">
                @foreach ($Jours as $Jour => $Horaires)
                @php
                setlocale(LC_ALL, 'fr_FR', 'fr', 'FR')
                @endphp
                    <h3>{{ ucfirst(Carbon\Carbon::createFromTimeStamp(strtotime($Jour))->formatLocalized("%A %e %B")) }}</h3>
                    
                        @foreach ($Horaires as $Horaire)
                            <div style="display:table; width:100%; margin-bottom:3.5px; position: relative;">
                                <tr style="display:flex;">
                                    <div style="display:table-cell; vertical-align: middle;width:60px;height:96px; text-align: center;font-size: 34px;background-color: #56409e;color: white;"><span class="fa fa-file-image-o"></span></div>
                                    <div class="card-body" style="display:table-cell;background-color:white;flex-grow:1;">
                                        @php
                                            //https://www.webdeveloper.com/forum/d/212775-converting-034554-format-time-into-seconds-quick-way-to-do-it
                                            list($h, $m, $s) = explode(':', $Horaire->duration);
                                            $timeSeconds = ($h * 3600) + ($m * 60) + $s;
                                        @endphp
                                        <h5 class="card-title" style="display:inline-block;">{{ substr($Horaire->dateAtelier, -8, 5) }} à {{ substr(date("Y-m-d H:i:s", strtotime('+'. $timeSeconds .' seconds', strtotime($Horaire->dateAtelier))), -8, -3) }} - {{ $Horaire->salle_local}}</h5>
                                        <span class="badge badge-dark" style="float:right;background-color:#56409e;width: 45px; border-radius:3px; margin-top:2px;">{{ $Horaire->inscriptions->where('isCanceled', false)->where('meNotifier', false)->count() }} / {{ $Horaire->nombrePlace }}</span>
                                        <span onclick="AjaxFill('{{ route('ateliers.show', ['atelier' => $Horaire->atelier->id]) }}', '#ModalContainer',false);" class="btn btn-primary" style="float:left;padding: 3.5px 9px; border-radius: 55px; line-height: 0px; margin-right:9px; margin-top:-3.5px;"><span style="font-size: 16px;" class="fa fa-info"></span></span>
                                        <br/>
                                        
                                        <p class="card-text" style="margin:0;max-width:calc(100% - 60px); display:inline-block;">{{ $Horaire->atelier->nom }}</p>
                                        <a class="btn btn-primary" data-ajax-url="{{ route('inscriptions.store', ['atelier_horaire' => $Horaire->id]) }}" data-ajax="true" data-ajax-method="POST" data-ajax-success="AjaxFill('{{ route('atelier_horaires.index') }}', '#temp', false, function(){ KeepOpen('#collapse_{{ $Etablissement }}','#app'); }); Alert('success', xhr.responseText);" data-ajax-failure="Alert('error', xhr.responseText)" style="color:white;position:absolute;top:41px;right:20px;width: 45px;padding: 4px 0 2px 0;"><span style="font-size: 25px;" class="fa fa-{{ $Horaire->inscriptions->where('user_id', Auth::id())->where('isCanceled', false)->isEmpty() ? $Horaire->inscriptions->where('isCanceled', false)->where('meNotifier', false)->count() < $Horaire->nombrePlace ? "pencil" : "bell" : ($Horaire->inscriptions->where('user_id', Auth::id())->where('meNotifier', true)->isNotEmpty() ? "bell-slash":"times")  }}"></span></a>
                                    </div>
                                </tr>
                            </div>
                        @endforeach
                    
                    <div style="height:7px;"></div>
                    <div style="height:7px;"></div>
                @endforeach
            </div>
        </div>
        <div style="height:7px;"></div>
    @endforeach
</div>
@endif
