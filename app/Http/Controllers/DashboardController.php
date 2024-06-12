<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Faculte;
use App\Models\Seance;
use App\Models\Universite;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(){
        $universites = count(Universite::all());
        $seances = count(Seance::all());
        $facultes = count(Faculte::all());
        $enseignants = count(Enseignant::all());

        return view("dashboard.index", compact('universites', 'seances', 'facultes', 'enseignants'));
    }
}
