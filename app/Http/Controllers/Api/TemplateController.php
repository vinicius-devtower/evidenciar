<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        return Template::forUser(auth()->user())->with('versions')
            ->where('is_active', true)
            ->get();
    }
}