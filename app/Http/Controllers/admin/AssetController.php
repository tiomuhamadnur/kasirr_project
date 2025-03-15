<?php

namespace App\Http\Controllers\admin;

use App\DataTables\AssetDataTable;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(AssetDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.asset.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'type' => 'string|required',
            'status' => 'string|required',
        ]);

        $request->validate([
            'file' => 'file|required'
        ]);

        $file = $request->file('file');

        $data = Asset::updateOrCreate($rawData, $rawData);

        if ($file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'asset/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('asset.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Asset::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'type' => 'string|required',
            'status' => 'string|required',
        ]);

        $request->validate([
            'file' => 'file|nullable'
        ]);

        $file = $request->file('file');

        $data->update($rawData);

        if ($file) {
            if ($data->file) {
                Storage::delete($data->file);
            }

            $filePath = $this->fileUploadService->uploadFile($file, 'asset/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('asset.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Asset::where('uuid', $uuid)->firstOrFail();

        if ($data->file) {
            Storage::delete($data->file);
        }
        $data->forceDelete();
        return redirect()->route('asset.index')->withNotify('Data berhasil dihapus');
    }
}
