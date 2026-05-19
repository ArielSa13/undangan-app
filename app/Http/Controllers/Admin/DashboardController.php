<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_invitations' => Invitation::count(),
            'published_invitations' => Invitation::where('status', 'published')->count(),
            'total_revenue' => Payment::where('status', 'paid')->sum('total_amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
        ];

        $recentPayments = Payment::with(['user', 'package'])
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::where('role', 'customer')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPayments', 'recentUsers'));
    }
}
