<?php
namespace App\Http\Controllers;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
class SiteController extends Controller
{
    public function index()
    {
        // Quais usuários existem no banco que atendem a esse critério?
        $sites = Auth::user()->sites()->with('domain')->get();
        return view('sites.index', compact('sites'));
    }
    public function show(Site $site)
    {
        abort_unless(
            Auth::user()->hasAccessToSite($site),
            403
        );
        return view('sites.show', compact('site'));
    }
}
