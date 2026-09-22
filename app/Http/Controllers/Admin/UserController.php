<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminCmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected AdminCmsService $cmsService;

    public function __construct(AdminCmsService $cmsService)
    {
        $this->cmsService = $cmsService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $role = $request->query('role');

        $users = $this->cmsService->getUsers($search, $role, 10);

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,contributor,user',
        ]);

        if (Auth::id() == $id && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat menurunkan role akun admin Anda sendiri!');
        }

        $user = $this->cmsService->updateUserRole($id, $request->role);

        return redirect()->back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi {$user->role}!");
    }

    public function toggleStatus($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user = $this->cmsService->toggleUserStatus($id);
        $statusMsg = $user->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (suspended)';

        return redirect()->back()->with('success', "Akun {$user->name} berhasil {$statusMsg}!");
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user = User::findOrFail($id);
        $name = $user->name;
        $this->cmsService->deleteUser($id);

        return redirect()->back()->with('success', "Pengguna {$name} berhasil dihapus dari sistem!");
    }
}
