<?php

namespace App\Http\Controllers;
use App\Inscription;
use App\AtelierHoraire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionsController extends Controller
{
    /**
     * Constructeur qui spécifie que seulement les utilisateurs connectés peuvent accéder aux routes
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retourne la liste des atelier_horaires pour afficher leurs inscriptions
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $AtelierHoraires;
        // récupère l'atelier_horaire donné en paramètre
        if(isset($id) && Auth::user()->isAdmin)
        {
            $AtelierHoraires = AtelierHoraire::where('id', $id)->get();
        }
        // récupère tous les atelier_horaires
        else if(!isset($id) && Auth::user()->isAdmin)
        {
            $AtelierHoraires = AtelierHoraire::all()->filter(function($atelier_horaire){
                return date('Y', strtotime($atelier_horaire->dateAtelier)) == date('Y', time());
            });
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
        // retourne la liste des atelier_horaires 
        return view('inscriptions.index')->with('AtelierHoraires', $AtelierHoraires->sortBy(function ($horaire) {
            return $horaire->dateAtelier;
        })
        ->sortBy(function ($horaire) {
            return $horaire->atelier->nom;
        })); 
    }

    /**
     * Insert ou update une inscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $AtelierHoraire = AtelierHoraire::find($id);
        $Inscriptions = $AtelierHoraire->inscriptions->where('user_id', Auth::id());
        $PlaceDisponible = ($AtelierHoraire->inscriptions->where('isCanceled', false)->where('meNotifier', false)->count() < $AtelierHoraire->nombrePlace);
        $Inscription;

        // si l'utilisateur n'a pas d'inscription pour l'atelier_horaire donné en paramètre, on créer une nouvelle inscription
        if($Inscriptions->isEmpty())
        {
            $Inscription = new Inscription;
            $Inscription->isCanceled = false;
            $Inscription->atelier_horaire_id = $id;
            $Inscription->user_id = Auth::id();
            // si l'atelier_horaire est plein, on met la colonne meNotifier à true
            $Inscription->meNotifier = !$PlaceDisponible;  
            $Inscription->save();

            return  $Inscription->meNotifier ? "Vous serez notifié si une place se libère." : "Inscription confirmée!";
        }
        // si l'utilisateur a une inscription pour l'atelier_horaire donné en paramètre, on modifie cette inscription
        else
        {
            $Inscription = $Inscriptions->first();
            $IsCanceled = $Inscription->isCanceled;
            $MeNotifier = $Inscription->meNotifier;
            // si l'utilisateur n'a pas annulé sont inscription, que meNotifier est à false, ça veut dire qu'il veut annulé son inscription 
            if(!$IsCanceled && !$MeNotifier)
            {
                // modification de l'inscription à annulé
                $Inscription->isCanceled = true;
                $Inscription->meNotifier = false;
                $Inscription->save();
                // envoi des courriels à ceux qui veulent être notifié quand une place se libère pour cet atelier_horaire
                if($PlaceDisponible != ($AtelierHoraire->inscriptions->where('isCanceled', false)->where('meNotifier', false)->count() < $AtelierHoraire->nombrePlace))
                {
                    $Inscriptions = Inscription::All()->filter(function ($inscription, $key) {
                        return $inscription->meNotifier == true && $inscription->atelier_horaire_id == $id;
                    });
            
                    foreach($Inscriptions as $inscription)
                    {
                        $inscription->user->notify(new AtelierNotification());
                        $inscription->delete();
                    }
                }
                
                return "Inscription annulée!";
            }
            // si l'utilisateur a préalablement annulé son inscription, on traite son inscription comme une nouvelle
            else if($IsCanceled && !$MeNotifier)
            {               
                $Inscription->meNotifier = !$PlaceDisponible;               
                $Inscription->isCanceled = false;
                $Inscription->save();
                return $Inscription->meNotifier ? "Vous serez notifié si une place se libère." : "Inscription confirmée!";
            }
            // si l'utilisateur ne veut plus être notifié si une place se libère pour cette atelier_horaire
            else if(!$IsCanceled && $MeNotifier)
            {              
                $Inscription->meNotifier = false;               
                $Inscription->isCanceled = true;
                $Inscription->save();              
                return "Vous ne serez plus notifié pour cet atelier.";
            }

        }             
        $Inscription->save();
        return "Oups! Une erreur est survenue.";
    }
}
