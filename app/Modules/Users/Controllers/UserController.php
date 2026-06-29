<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(
            'role:' . implode(',', config('roles.user_manage'))
        );
    }

public function index(Request $request)
{
    $search = trim($request->get('search'));

    $users = User::with('roles')
        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");

            });

        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

    return view('users.index', compact(
        'users',
        'search'
    ));
}


public function create()
{
    $roles = Role::orderBy('name')->get();

    return view('users.create', compact('roles'));
}


public function store(Request $request)
{
    $validated = $request->validate([

        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'username' => [
            'required',
            'string',
            'max:255',
            'unique:users,username',
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
        ],

        'password' => [
            'required',
            'confirmed',
            'min:8',
        ],

        'role_id' => [
            'required',
            'exists:roles,id',
        ],

    ]);

    $user = User::create([

        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'clinic_id' => config('clinic.id'),

    ]);

    $user->roles()->sync([
        $validated['role_id']
    ]);

    return redirect()
        ->route('users.index')
        ->with('success', 'User created successfully.');
}




}