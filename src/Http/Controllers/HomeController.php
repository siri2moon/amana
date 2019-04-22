<?php

namespace Herode\Amana\Http\Controllers;

use Herode\Amana\Amana;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('amana::layout', [
            'cssFile' => 'app.css',
            'amanaScriptVariables' => Amana::scriptVariables(),
        ]);
    }
}
