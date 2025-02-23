<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        $gender = Gender::all();
        $group = Group::all();
        $role = Role::all();

        return $dataTable->render('pages.admin.user.index', compact([
            'gender',
            'group',
            'role',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'name' => 'string|required',
            'email' => 'email|required|unique:users,email',
            'gender_id' => 'required|numeric',
            'role_id' => 'numeric|required',
            'group_id' => 'numeric|required',
        ]);

        $default_password = "user123";
        $rawData['password'] = Hash::make($default_password);

        User::updateOrCreate($rawData, $rawData);

        return redirect()->route('user.index')->withNotify('Data user berhasil ditambahkan dengan password default ' . $default_password);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        $data = User::where('id', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'gender_id' => 'required|numeric',
            'role_id' => 'numeric|required',
            'group_id' => 'numeric|required',
        ]);

        $data->update($rawData);
        return redirect()->route('user.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = User::where('id', $uuid)->firstOrFail();
        // $data->delete();
        return redirect()->route('user.index')->withNotifyerror('Anda tidak bisa menghapus data ini.');
    }
}
