<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $users = User::select("first_name as value", "last_name as value", "username as value", "id as value", "id")
                    ->where('first_name', 'LIKE', '%'. $request->search. '%')
                    ->orWhere('last_name', 'LIKE', '%'. $request->search. '%')
                    ->orWhere('username', 'LIKE', '%'. $request->search. '%')
                    ->orWhere('id', 'LIKE', '%'. $request->search. '%')
                    ->limit(10)->get();

        return response()->json($users);
    }
}
