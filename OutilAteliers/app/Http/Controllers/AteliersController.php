<?php

namespace App\Http\Controllers;
use App\Atelier;
use App\AtelierHoraire;
use App\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AteliersController extends Controller
{
    //Constructeur qui spécifie que seulement les utilisateurs connectés peuvent accéder aux routes
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retourne la liste des ateliers
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin)
        {
            return view('ateliers.index')->with('Ateliers', Atelier::All());
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Montre le formulaire pour créer un atelier si l'utilisateur connecté est un admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isAdmin)
        {
            return view('ateliers.create');
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Insert un atelier si l'utilisateur connecté est un admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->isAdmin)
        {
            // valide des données entrées pour l'atelier 
            $this->validate($request, [
                'nom' => ['Required', 'unique:ateliers'],
                'description' => 'Required',
                'nomCompletResponsable' => 'Required',
                'description_responsable' => 'Required'
            ]);

            // création de l'atelier à insérer
            $atelier = new Atelier;
            $atelier->nom = $request->input('nom');
            $atelier->description = $request->input('description');
            $atelier->nomCompletResponsable = $request->input('nomCompletResponsable');
            $atelier->description_responsable = $request->input('description_responsable');
            $atelier->save();

            return "Atelier ajouté!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Montre les détails de l'atelier donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('ateliers.show')->with('Atelier', Atelier::find($id));
    }

    /**
     * Montre le formulaire pour modifier les informations d'un atelier
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin)
        {
            return view('ateliers.edit')->with('Atelier', Atelier::find($id));
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un UPDATE dans la base de données pour modifier un atelier
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->isAdmin)
        {
            // valide des données entrées pour l'atelier à modifier
            $this->validate($request, [
                'nom' => ['Required', Rule::unique('ateliers')->ignore($id)],
                'description' => 'Required',
                'nomCompletResponsable' => 'Required',
                'description_responsable' => 'Required'
            ]);
            // modifie les valeurs de l'atelier
            $atelier = Atelier::find($id);
            $atelier->nom = $request->input('nom');
            $atelier->description = $request->input('description');
            $atelier->nomCompletResponsable = $request->input('nomCompletResponsable');
            $atelier->description_responsable = $request->input('description_responsable');
            $atelier->save();

            return "Atelier modifié!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }

    /**
     * Effectue un DELETE dans la base de données pour supprimer l'atelier donné en paramètre
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin)
        {
            $user = Atelier::find($id);
            $user->delete();
            foreach(AtelierHoraire::All()->filter(function($atelier_horaire) use ($id){
                return $atelier_horaire->atelier_id == $id;
            }) as $atelier_horaire)
            {
                $atelier_horaire->delete();
                $atelier_horaire_id = $atelier_horaire->id;
                foreach(Inscription::All()->filter(function($inscription) use ($atelier_horaire_id){
                    return $inscription->atelier_horaire_id == $atelier_horaire_id;
                }) as $inscription)
                {
                    $inscription->delete();
                }
            }
            return "Atelier supprimé!";
        }
        else
        {
            return response('Accès non-autorisé.', 403);
        }
    }
}
