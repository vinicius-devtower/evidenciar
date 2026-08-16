<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
class TemplateController extends Controller
{
    public function index()
    {
        $templates = Auth::user()
            ->client
            ->templates()
            ->with('versions')
            ->get();
        return view('templates.index', compact('templates'));
    }
}

