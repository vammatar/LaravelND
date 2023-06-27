<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;


class UserController extends Controller
{
    public function changeRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => ['required', Rule::in(['admin', 'read_only', 'user'])],
        ]);

        $user = auth()->user();
        $user->role = $validatedData['role'];
        $user->save();

        return back()->with('success', 'Role changed successfully.');
    }
}
