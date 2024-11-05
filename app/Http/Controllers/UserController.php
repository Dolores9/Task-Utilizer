<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleActive(User $user)
    {
        // Toggle the active status
        $user->active = !$user->active;
        $user->save();

        // Redirect back to the current page with a success message
        return redirect()->back()->with('success', 'User status updated successfully.');
    }

}
