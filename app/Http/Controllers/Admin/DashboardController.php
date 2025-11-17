<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'conferences' => \App\Models\Conference::count(),
            'active_conference' => \App\Models\Conference::active()->first(),
            'speakers' => \App\Models\Speaker::count(),
            'sponsors' => \App\Models\Sponsor::count(),
            'exhibitors' => \App\Models\Exhibitor::count(),
            'participants' => \App\Models\Participant::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
