<?php

namespace App\Http\Controllers\user;

use App\DataTables\LicenseDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\License;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{
    public function index(LicenseDataTable $dataTable)
    {
        $category = Category::all();
        $status = Status::all();

        return $dataTable->render('pages.user.license.index', compact([
            'category',
            'status',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'numeric|required',
            'description' => 'string|required',
            'status_id' => 'numeric|required',
        ]);

        $data['user_id'] = Auth::user()->id;

        License::updateOrCreate($data, $data);

        return redirect()->route('license.index')->withNotify('Data berhasil ditambahkan');
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
        $data = License::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'category_id' => 'numeric|required',
            'description' => 'string|required',
            'status_id' => 'numeric|required',
            'is_used' => 'numeric|required',
        ]);

        $rawData['user_id'] = Auth::user()->id;
        $data->update($rawData);

        return redirect()->route('license.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = License::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('license.index')->withNotify('Data berhasil dihapus');
    }
}
