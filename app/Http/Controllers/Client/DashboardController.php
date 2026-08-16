<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sites = $user->sites()->get();
        return view('client.dashboard', compact('user', 'sites'));
    }
}
