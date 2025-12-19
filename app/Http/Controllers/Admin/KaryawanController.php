<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        // ambil semua user role=karyawan + relasi profil
        $rows = User::where('role','karyawan')->with('karyawan')->get();
        return view('admin.karyawan.index', compact('rows'));
    }

    public function create(){ return view('admin.karyawan.create'); }

public function store(Request $r)
{
    $data = $r->validate([
        'uid'     => ['required','string','max:50','unique:karyawans,uid'],
        'name'    => ['required','string','max:100'],
        'email'   => ['required','email','max:150','unique:users,email'],
        'password'=> ['required','string','min:6'],
        'alamat'  => ['nullable','string','max:255'],
        'status'  => ['required', Rule::in(['aktif','cuti','nonaktif'])],
    ]);

    $user = \App\Models\User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'role'     => 'karyawan',
    ]);

    Karyawan::create([
        'user_id' => $user->id,
        'uid'     => $data['uid'],
        'alamat'  => $data['alamat'] ?? null,
        'status'  => $data['status'],
    ]);

    return redirect()->route('admin.karyawan.index')->with('ok','Karyawan ditambahkan.');
}

// FORM EDIT
public function edit(User $user)
{
    abort_unless($user->role === 'karyawan', 404);
    $user->load('karyawan'); // tarik profil
    return view('admin.karyawan.edit', compact('user'));
}

// UPDATE DATA
public function update(Request $r, User $user)
{
    abort_unless($user->role === 'karyawan', 404);

    $data = $r->validate([
        'uid' => [
            'required',
            'string',
            'max:50',
            // cek unik di users (kecuali user ini)
            Rule::unique('users', 'uid')->ignore($user->id),
            // cek unik di karyawans (kecuali karyawan ini)
            Rule::unique('karyawans', 'uid')->ignore($user->karyawan->id ?? null),
        ],
        'name'     => ['required','string','max:100'],
        'email'    => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)],
        'password' => ['nullable','string','min:6'],
        'alamat'   => ['nullable','string','max:255'],
        'status'   => ['required', Rule::in(['aktif','cuti','nonaktif'])],
    ]);

    // UPDATE USERS
    $user->update([
        'name'  => $data['name'],
        'email' => $data['email'],
        'uid'   => $data['uid'], // ⬅️ INI WAJIB
    ]);

    if (!empty($data['password'])) {
        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    // UPDATE / CREATE KARYAWAN
    $user->karyawan()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'uid'    => $data['uid'],
            'alamat' => $data['alamat'] ?? null,
            'status' => $data['status'],
        ]
    );

    return redirect()
        ->route('admin.karyawan.index')
        ->with('ok', 'Data karyawan diperbarui.');
}


// HAPUS DATA
public function destroy(User $user)
{
    abort_unless($user->role === 'karyawan', 404);
    $user->delete(); // relasi karyawans ikut terhapus karena foreign key cascade
    return back()->with('ok','Karyawan dihapus.');
}

}

