<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultsController extends Controller
{
    public function index()
    {
        return view('admin.results.index');
    }

    public function viewers()
    {
        return view('admin.results.viewers');
    }
}
