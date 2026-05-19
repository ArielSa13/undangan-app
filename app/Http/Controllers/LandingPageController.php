<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $packages = Package::active()->get();

        return view('landing', compact('packages'));
    }
}
