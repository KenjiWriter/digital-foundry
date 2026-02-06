<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class WelcomeController extends Controller
{
    public function index()
    {
        $sectors = Sector::with('questions')
            ->where('is_active', true)
            ->get();

        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'auditSectors' => $sectors,
        ]);
    }
}
