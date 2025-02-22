<?php

namespace App\Http\Controllers\admin;

use App\DataTables\GenderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function index(GenderDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.gender.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:gender,code'
        ]);

        Gender::updateOrCreate($data, $data);

        return redirect()->route('gender.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Gender::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('gender.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Gender::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('gender.index')->withNotify('Data berhasil dihapus');
    }
}
