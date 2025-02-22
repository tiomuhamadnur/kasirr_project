<?php

namespace App\Http\Controllers\admin;

use App\DataTables\GroupDataTable;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(GroupDataTable $dataTable)
    {
        return $dataTable->render('pages.user.group.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:gender,code',
            'description' => 'string|required'
        ]);

        Group::updateOrCreate($data, $data);

        return redirect()->route('group.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Group::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            'description' => 'string|required',
        ]);

        $data->update($rawData);
        return redirect()->route('group.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Group::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('group.index')->withNotify('Data berhasil dihapus');
    }
}
