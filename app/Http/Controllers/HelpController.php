<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }

    public function help_center(Request $request)
    {
        return view('helps.index');
    }

    public function help_center_post(Request $request)
    {

    }

    public function help_center_admin(Request $request)
    {

    }
}
