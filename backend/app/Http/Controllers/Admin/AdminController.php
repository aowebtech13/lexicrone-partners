<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display admin dashboard stats.
     */
    public function index()
    {
        return response()->json([
            'stats' => [
                'total_users' => User::count(),
                // Add more stats as needed
            ],
            'message' => 'Admin dashboard data retrieved successfully.'
        ]);
    }
}
