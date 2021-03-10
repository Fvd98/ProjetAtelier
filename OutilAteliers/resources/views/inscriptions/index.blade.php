<style>
    @page { size: auto;  margin: 0mm; }
</style>

<html>
    <body style="padding:20px;margin-top:25px">
            <script src="{{ asset('js/app.js') }}" defer></script>
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
            @php
                setlocale(LC_ALL, 'fr_FR', 'fr', 'FR')
            @endphp
            @foreach($AtelierHoraires as $AtelierHoraire)
                @php
                    //https://www.webdeveloper.com/forum/d/212775-converting-034554-format-time-into-seconds-quick-way-to-do-it
                    list($h, $m, $s) = explode(':', $AtelierHoraire->duration);
                    $timeSeconds = ($h * 3600) + ($m * 60) + $s;
                @endphp
                
                <h2 style="text-align:center; font-weigth:bold;">Liste des inscriptions pour l'atelier {{ $AtelierHoraire->atelier->nom }}<br/> ({{ ucfirst(Carbon\Carbon::createFromTimeStamp(strtotime($AtelierHoraire->dateAtelier))->formatLocalized("%A %e %B")) }} de {{ substr($AtelierHoraire->dateAtelier, -8, -3) }} à {{ substr(date("Y-m-d H:i:s", strtotime('+'. $timeSeconds .' seconds', strtotime($AtelierHoraire->dateAtelier))), -8, -3) }})</h2>
                @if($AtelierHoraire->inscriptions->count() != 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:center;">Nom complet</th>
                                <th scope="col" style="text-align:center;">Programme</th>
                                <th scope="col" style="text-align:center;">Présent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($AtelierHoraire->inscriptions
                            ->filter(function($inscription){
                                return !$inscription->isCanceled && !$inscription->meNotifier;
                            })
                            ->sortBy(function ($inscription) {
                                return $inscription->user->programme->nom;
                            }) as $Inscription)
                                <tr>
                                    <td>{{ $Inscription->user->prenom }} {{ $Inscription->user->nom }}</td>
                                    <td>{{ $Inscription->user->programme->nom }}</td>
                                    <td style="text-align:center;"><input style="width:25px;height:25px;" type="checkbox" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <br />
                    <p style="font-weight:bold; font-size:20px; text-align:center;">Aucune inscriptions pour cet atelier horaire...</p>
                    <br />
                @endif
            @endforeach
    </body>
</html>

    
