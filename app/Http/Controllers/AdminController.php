<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatParser;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        StatParser::parsePage();

        return view('admin.index');
    }
}
