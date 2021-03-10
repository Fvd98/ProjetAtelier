<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programme;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProgrammesController extends Controller
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
     * Retourne la liste des programmes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
            return view('programmes.index')->with('Programmes', Programme::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }       
    }

    /**
     * Montre le formulaire pour créer un programme si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin)
        {
            return view('programmes.create');
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }   
    }

    /**
     * Insert un programme si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'code' => ['Required', 'unique:programmes'],
                'nom' => 'Required'
            ]);
    
            $programme = new Programme;
            $programme->code = $request->input('code');
            $programme->nom = $request->input('nom');
            $programme->save();
    
            return "Programme ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }   
    }

    /**
     * Montre le formulaire pour modifier les informations d'un programme
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            $programme = Programme::find($id);
            return view('programmes.edit')->with('Programme', $programme);
        }
        else
        {
            return response('Accès non-autorisé.', 403);
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
        if(Auth::user()->isAdmin)
        {
            $this->validate($request, [
                'code' => ['Required', Rule::unique('programmes')->ignore($id)],
                'nom' => 'Required'
            ]);

            $programme = Programme::find($id);
            $programme->code = $request->input('code');
            $programme->nom = $request->input('nom');
            $programme->save();

            return "Programme modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
        
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer le programme donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            
            $programme = Programme::find($id);
            $programme->users()->where('programme_id', $id)->each(function ($user) {
                $user->programme_id = null;
                $user->save();
            });
            $programme->delete();

            return "Programme supprimé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }  
    }
}
