<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Programme;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Professeur;

class UsersController extends Controller
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
     * Retourne la liste des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
             return view('users.index')->with('Users', User::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        } 
    }

    /**
     * Montre le formulaire pour créer un utilisateur si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin)
        {
            return view('users.create');
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Insert un utilisateur si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'courriel' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'motDePasse' => ['required', 'string', 'min:6', 'confirmed'],
                'professeur_numero' => ['required', 'string', 'size:5'],
                'isAdmin' => ['required', 'boolean'],
            ]);
            $professeur = Professeur::where('numero', $request->input('professeur_numero'))->first();
            if(!isset($professeur))
            {
                return view('professeurs.create')->with('professeur_numero', $request->input('professeur_numero'));
            }
            $user = new User;
            $user->courriel = $request->input('courriel');
            $user->motDePasse = Hash::make($request->input('motDePasse'));
            $user->professeur_id = $professeur->id;
            $user->isAdmin = $request->input('isAdmin') == "on";
            $user->save();

            return "Utilisateur ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
        
    }

    /**
     * Montre les détails de l'utilisateur donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $evenements = Auth::user()->evenement_inscriptions->map(function ($inscription) {
            return $inscription->evenement;
        });
        $inscriptions = Auth::user()->atelier_inscriptions()->where('meNotifier', false)->where('isCanceled', false)->filter(function ($inscription) {
            return Carbon::parse($inscription->atelier_horaire->bloc->evenement->date_evenement)->gt(Carbon::today());
        });
        $atelier_horaires = $inscriptions->map(function ($inscription) {
            return $inscription->atelier_horaire;
        });
        // liste des horaires en ordre d'heures
        $atelier_horaires = $atelier_horaires->sortBy('heure');
        // liste des horaires groupés par jour
        return view('users.show')->with('User', Auth::user())->with('Evenements', $evenements)->with('AtelierHoraires', $atelier_horaires);
    }

    /**
     * Montre le formulaire pour modifier les informations d'un utilisateur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $profil = false)
    {
        if(Auth::id() == $id || Auth::user()->isAdmin)
        {
            return view('users.edit')->with('User', User::find($id))->with('Programmes', Programme::All())->with('Profil', $profil);
        }
        else
        {
            response(403, 'Accès non-autorisé.');
        }
        
    }

    /**
     * Met à jour un programme si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::id() == $id || Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'numero' => ['required', 'string', 'max:255'],
                'courriel' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'programme_id' => 'Required',
            ]);

            $user = User::find($id);
            $user->courriel = $request->input('courriel');
            $user->numero = $request->input('numero');
            $user->prenom = $request->input('prenom');
            $user->nom = $request->input('nom');
            $user->programme_id = $request->input('programme_id');
            if(Auth::user()->isAdmin)
            {
                $user->isAdmin = $request->input('isAdmin') == "on";
            }
            $user->save();
            return (Auth::id()==$id?"Votre compte":"Le compte")." a été modifié avec succès!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer l'utilisateur donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $user = User::find($id);
            $user->delete();
    
            return "Compte supprimé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }
}
