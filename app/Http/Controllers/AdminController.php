<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPVolleyParser;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $parser = new CPVolleyParser();
// TODO:        $parser->downloadTournamentResults();

        return view('admin.index');
    }
}
