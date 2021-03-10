<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departement;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepartementsController extends Controller
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
     * Retourne la liste des departements
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
            return view('departements.index')->with('Departements', Departement::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }       
    }

    /**
     * Montre le formulaire pour créer un departement si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin)
        {
            return view('departements.create');
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }   
    }

    /**
     * Insert un departement si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'nom' => ['required', 'unique:departements']
            ]);
    
            $departement = new Departement;
            $departement->nom = $request->input('nom');
            $departement->save();
    
            return "Departement ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }   
    }

    /**
     * Montre le formulaire pour modifier les informations d'un departement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            $departement = Departement::find($id);
            return view('departements.edit')->with('Departements', $departement);
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }   
       
    }

    /**
     * Met à jour un departement si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'nom' => ['required', 'unique:departements']
            ]);

            $departement = Departement::find($id);
            $departement->nom = $request->input('nom');
            $departement->save();

            return "Departement modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
        
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer le departement donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $departement = Departement::find($id);
            $departement->professeurs()->where('departement_id', $id)->each(function ($user) {
                $user->departement_id = null;
                $user->save();
            });
            $departement->delete();

            return "Departement supprimé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }
}
