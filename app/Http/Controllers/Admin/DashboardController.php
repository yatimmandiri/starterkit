<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Views\DashboardView;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $config = DashboardView::handle(Auth::user());

        return Inertia::render(
            $config['view'] ?? 'admin/dashboard/user',
            $config['data'] ?? []
        );
    }
}
