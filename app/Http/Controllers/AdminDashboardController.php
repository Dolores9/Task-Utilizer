<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch all users
        $users = User::all();

        return view('auth/admin-dashboard', compact('users'));
    }
}
