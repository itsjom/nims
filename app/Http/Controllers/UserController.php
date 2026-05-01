<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'nullable|array'
        ]);

        // Prevent removing admin role from the default admin user to avoid locking out the system
        if ($user->email === 'systemadmin@nims.com' && !in_array('System Admin', $request->roles ?? [])) {
            $roles = $request->roles ?? [];
            $roles[] = 'System Admin';
            $user->syncRoles($roles);
            return redirect()->route('users.index')->with('error', 'The System Admin role cannot be removed from the system administrator.');
        }

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'User roles updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deletion of the default admin user
        if ($user->email === 'systemadmin@nims.com') {
            return redirect()->route('users.index')->with('error', 'The system administrator account cannot be deleted.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
