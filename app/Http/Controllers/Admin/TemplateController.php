<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        $templates = Template::withCount('invitations')->orderBy('sort_order')->paginate(20);
        return view('admin.templates.index', compact('templates'));
    }

    public function edit(Template $template): View
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string'],
            'tier' => ['required', 'string'],
            'is_active' => ['boolean'],
            'is_premium' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ]);

        $template->update($validated);

        return back()->with('success', 'Template berhasil diperbarui.');
    }

    public function toggleActive(Template $template): RedirectResponse
    {
        $template->update(['is_active' => !$template->is_active]);
        return back()->with('success', 'Status template diperbarui.');
    }
}
