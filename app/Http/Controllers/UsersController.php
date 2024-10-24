<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function showUserindex()
    {
        $user = Auth::user();

        return view('User.user_index', compact('user'));
    }
}
