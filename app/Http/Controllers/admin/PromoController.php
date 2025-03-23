<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PromoDataTable;
use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(PromoDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.promo.index');
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
            'type' => 'string|required|in:image,video',
            'target' => 'required|string|in:all,subscribed,unsubscribed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'string|required',
        ]);

        $request->validate([
            'file' => 'file|required'
        ]);

        $file = $request->file('file');

        $data = Promo::updateOrCreate($rawData, $rawData);

        if ($file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'promo/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('promo.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Promo::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'type' => 'string|required|in:image,video',
            'target' => 'required|string|in:all,subscribed,unsubscribed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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

            $filePath = $this->fileUploadService->uploadFile($file, 'promo/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('promo.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Promo::where('uuid', $uuid)->firstOrFail();

        if ($data->file) {
            Storage::delete($data->file);
        }
        $data->forceDelete();
        return redirect()->route('promo.index')->withNotify('Data berhasil dihapus');
    }
}
