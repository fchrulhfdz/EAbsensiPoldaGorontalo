<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->where('id', '!=', auth()->id())
            ->get();
            
        return view('super-admin.admins', compact('admins'));
    }

    public function create()
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        return view('super-admin.create-admin');
    }

    public function store(Request $request)
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|unique:users',
            'jabatan' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'pangkat' => $request->pangkat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.management')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $admin = User::whereIn('role', ['admin', 'super_admin'])
            ->where('id', $id)
            ->firstOrFail();
            
        return view('super-admin.edit-admin', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $admin = User::whereIn('role', ['admin', 'super_admin'])
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|unique:users,nrp,' . $id,
            'jabatan' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'pangkat' => $request->pangkat,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.management')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $admin = User::where('role', 'admin')
            ->where('id', $id)
            ->firstOrFail();

        $admin->delete();

        return redirect()->route('admin.management')
            ->with('success', 'Admin berhasil dihapus.');
    }
}