<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function accueil(){
        return view('public.accueil');
    }
}
