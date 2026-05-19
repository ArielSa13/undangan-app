<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Invitation::with(['user', 'template']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('groom_name', 'like', "%{$search}%")
                    ->orWhere('bride_name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invitations = $query->latest()->paginate(20);

        return view('admin.invitations.index', compact('invitations'));
    }

    public function show(Invitation $invitation): View
    {
        $invitation->load(['user', 'template', 'guests', 'guestbooks', 'payments']);
        return view('admin.invitations.show', compact('invitation'));
    }
}
