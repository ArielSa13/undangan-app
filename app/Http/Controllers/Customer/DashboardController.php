<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $invitations = $user->invitations()
            ->with('template')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_invitations' => $user->invitations()->count(),
            'published' => $user->invitations()->where('status', 'published')->count(),
            'total_views' => $user->invitations()->sum('view_count'),
            'total_guests' => $user->invitations()
                ->withCount('guests')
                ->get()
                ->sum('guests_count'),
        ];

        return view('customer.dashboard', compact('invitations', 'stats'));
    }
}
