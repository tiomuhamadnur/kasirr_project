<?php

namespace App\Http\Controllers\admin;

use App\DataTables\StatusDataTable;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(StatusDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.status.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:status,code'
        ]);

        Status::updateOrCreate($data, $data);

        return redirect()->route('status.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Status::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('status.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Status::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('status.index')->withNotify('Data berhasil dihapus');
    }
}
