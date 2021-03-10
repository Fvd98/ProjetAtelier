<?php

namespace App\Http\Controllers;
use App\Etablissement;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtablissementsController extends Controller
{
    //Constructeur qui spécifie que seulement les utilisateurs connectés peuvent accéder aux routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retourne la liste des établissements
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
            return view('etablissements.index')->with('Etablissements', Etablissement::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }    
    }

    /**
     * Montre le formulaire pour créer un établissement si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin)
        {
            return view('etablissements.create');
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }

    /**
     * Insert un établissement si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'nom' => ['Required', 'unique:etablissements'],
                'adresse' => 'Required'
            ]);
    
            $etablissement = new Etablissement;
            $etablissement->nom = $request->input('nom');
            $etablissement->adresse = $request->input('adresse');
            $etablissement->save();
    
            return "Établissement ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }

    /**
     * Montre le formulaire pour modifier les informations d'un établissement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            $etablissement = Etablissement::find($id);
            return view('etablissements.edit')->with('Etablissement', $etablissement);
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }

    /**
     * Effectue un UPDATE dans la base de données pour modifier un établissement
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
                'nom' => ['Required', Rule::unique('etablissements')->ignore($id)],
                'adresse' => 'Required'
            ]);
    
            $etablissement = Etablissement::find($id);
            $etablissement->nom = $request->input('nom');
            $etablissement->adresse = $request->input('adresse');
            $etablissement->save();
    
            return "Établissement modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer l'établissement donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $etablissement = Etablissement::find($id);
            $etablissement->delete();

            return "Établissement supprimé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }
}
