<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $admins   = User::where('role', 'admin')->get();
        return view('admin.settings.index', compact('settings', 'admins'));
    }

    /** Save all store settings at once */
    public function update(Request $request)
    {
        $settingsData = $request->input('settings', []);
        foreach ($settingsData as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Pengaturan toko berhasil disimpan!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update($request->only('name', 'email'));
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diubah!');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return back()->with('success', 'Akun admin baru berhasil dibuat!');
    }

    public function destroyAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }
        $user->delete();
        return back()->with('success', 'Akun admin berhasil dihapus!');
    }
}
