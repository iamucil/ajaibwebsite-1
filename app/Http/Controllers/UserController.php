<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function confirmation(Request $request)
    {
        return view('auth.success', [
            'user' => $request->session()->get('user'),
            'status' => $request->session()->get('status')
        ]);
    }
}
