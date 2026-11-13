<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fact;
use App\Models\Player;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'players' => Player::count(),
            'categories' => Category::count(),
            'facts' => Fact::count(),
        ];

        $recentPlayers = Player::with('category')->latest()->limit(5)->get();

        return view('dashboard', compact('stats', 'recentPlayers'));
    }
}
