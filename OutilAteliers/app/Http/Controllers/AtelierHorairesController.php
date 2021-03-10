<?php

namespace App\Http\Controllers;
use App\AtelierHoraire;
use App\Etablissement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Inscription;
use App\Notifications\RappelNotification;

class AtelierHorairesController extends Controller
{
    //Constructeur qui spécifie que seulement les utilisateurs connectés peuvent accéder aux routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retourne la liste des atelier_horaires
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // liste des horaires des ateliers futurs
        $AtelierHoraires = AtelierHoraire::whereYear('dateAtelier', '>=', Carbon::today()->toDateString())->get();
        // liste des horaires en ordre de date croissant
        $AtelierHoraires = $AtelierHoraires->sortBy('dateAtelier');
        // liste des horaires groupés par jour
        $AtelierHoraires = $AtelierHoraires->groupBy([
        function($item) {
            return $item->etablissement->nom;
        },
        function($item) {
            return date("Y-m-d", strtotime($item->dateAtelier));
        }
        ]);
        return view('atelier_horaires.index')->with('AtelierHoraires', $AtelierHoraires);
    }

    /**
     * Montre le formulaire pour créer un atelier_horaires si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(Auth::user()->isAdmin)
        {
            return view('atelier_horaires.create')->with('atelier_id', $id)->with('Etablissements',Etablissement::All()); 
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Insert un atelier_horaires si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            // valide les données entrées pour créer l'atelier_horaire
            $this->validate($request, [
                'atelier_id' => 'required',
                'etablissement_id' => 'required',
                'dateAtelier' => ['Required', 'date'],
                'duration' => ['Required'],
                'salle_local' => 'required',
                'nombrePlace' => ['Required','integer'],
            ]);
            // créer l'atelier_horaire
            $atelier_horaire = new AtelierHoraire;
            $atelier_horaire->atelier_id = $request->input('atelier_id');
            $atelier_horaire->etablissement_id = $request->input('etablissement_id');
            $atelier_horaire->dateAtelier = $request->input('dateAtelier');
            $atelier_horaire->duration = $request->input('duration');
            $atelier_horaire->salle_local = $request->input('salle_local');
            $atelier_horaire->nombrePlace = $request->input('nombrePlace');
            $atelier_horaire->save();

            return "Horaire ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Montre les détails de l'atelier_horaire donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        return view('atelier_horaires.create')->with('AtelierHoraire', AtelierHoraire::find($id));
    }

    /**
     * Montre le formulaire pour modifier les informations d'un atelier_horaire
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            return view('atelier_horaires.edit')->with('AtelierHoraire', AtelierHoraire::find($id))->with('Etablissements',Etablissement::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un UPDATE dans la base de données pour modifier un atelier_horaire
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->isAdmin)
        {
            // valide les données de l'atelier_horaire modifié
            $this->validate($request, [
                'etablissement_id' => 'Required',
                'dateAtelier' => ['Required', 'date'],
                'duration' => ['Required'],
                'salle_local' => 'Required',
                'nombrePlace' => ['Required','integer'],
            ]);
            // modifier les données de l'atelier_horaire
            $atelier_horaire = AtelierHoraire::find($id);
            $atelier_horaire->etablissement_id = $request->input('etablissement_id');
            $atelier_horaire->dateAtelier = $request->input('dateAtelier');
            $atelier_horaire->duration = $request->input('duration');
            $atelier_horaire->salle_local = $request->input('salle_local');
            $atelier_horaire->nombrePlace = $request->input('nombrePlace');
            $atelier_horaire->save();

            return "Horaire modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer l'atelier_horaire donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $atelierHoraire = AtelierHoraire::find($id);
            $atelierHoraire->delete();

            foreach(Inscription::All()->filter(function($inscription) use ($id){
                return $inscription->atelier_horaire_id == $id;
            }) as $inscription)
            {
                $inscription->delete();
            }
    
            return "Horaire supprimé!";      
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Méthode qui envoie un courriel de rappel pour l'évènement 
     *
     * @return \Illuminate\Http\Response
     */
    public function rappel()
    {
        if(Auth::user()->isAdmin)
        {
            // récupère les inscriptions non annulées et dont la colonne meNofifier est à false
            $Inscriptions = Inscription::All()->filter(function ($inscription, $key) {
                return $inscription->meNotifier == false && $inscription->isCanceled == false;
            });

            // envoi le courriel aux utilisateurs ayant des inscriptions
            foreach($Inscriptions as $inscription)
            {
                $inscription->user->notify(new RappelNotification());
            }

            return "Courriels envoyés.";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }
}
