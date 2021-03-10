<?php

namespace App\Http\Controllers;
use App\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Departement;

class ProfesseursController extends Controller
{
    //Constructeur qui spécifie que seulement les utilisateurs connectés peuvent accéder aux routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retourne la liste des professeurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
             return view('professeurs.index')->with('Professeurs', Professeur::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        } 
    }

    /**
     * Montre le formulaire pour créer un professeur si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(Auth::user()->isAdmin)
        {
            return view('professeurs.create')->with('Departements', Departement::All()); 
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Insert un professeur si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            // valide les données entrées pour créer le professeur
            $this->validate($request, [
                'numero' => ['required', 'string', 'unique:professeurs', 'size:5'],
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'departement_id' => ['required', 'integer'],
            ]);
            // créer l'atelier_horaire
            $professeur = new Professeur();
            $professeur->numero = $request->input('numero');
            $professeur->nom = $request->input('nom');
            $professeur->prenom = $request->input('prenom');
            $professeur->departement_id = $request->input('departement_id');
            $professeur->save();

            return "Professeur Créé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Montre les détails du professeur donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        return view('professeurs.create')->with('Professeur', Professeur::find($id));
    }

    /**
     * Montre le formulaire pour modifier les informations d'un professeur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            return view('professeurs.edit')->with('Professeur', Professeur::find($id))->with('Departements', Departement::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un UPDATE dans la base de données pour modifier un professeur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->isAdmin)
        {
            // valide les données du professeur modifié
            $this->validate($request, [
                'numero' => ['required', 'string', 'unique:professeurs', 'size:5'],
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'departement_id' => ['required', 'integer'],
            ]);
            // modifier les données du professeur
            $professeur = Professeur::find($id);
            $professeur->numero = $request->input('numero');
            $professeur->nom = $request->input('nom');
            $professeur->prenom = $request->input('prenom');
            $professeur->departement_id = $request->input('departement_id');
            $professeur->save();

            return "Professeur modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer le professeur donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $professeur = Professeur::find($id);
            if($professeur->user()->where('professeur_id', $id)->isNotEmpty())
            {
                return response('Oups! Un compte est associé à ce professeur, il ne peut donc pas être suprimmé.', 403);
            }
            else if($professeur->atelier_horaires()->where('professeur_id', $id)->isNotEmpty())
            {
                return response('Oups! Ce professeur anime un atelier, il ne peut donc pas être suprimmé.', 403);
            }
            else
            {
                $professeur->delete();
                return "Professeur supprimé!";
            }
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }
}
