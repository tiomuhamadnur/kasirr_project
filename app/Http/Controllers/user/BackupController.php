<?php

namespace App\Http\Controllers\user;

use App\DataTables\BackupDataTable;
use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\Project;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(BackupDataTable $dataTable)
    {
        $project = Project::all();
        $user = User::all();

        return $dataTable->render('pages.user.backup.index', compact([
            'project',
            'user',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'project_id' => 'numeric|required',
            'user_id' => 'numeric|required',
            'description' => 'string|required',
        ]);

        $request->validate([
            'file' => 'file|required|extensions:sqlite'
        ]);

        $file = $request->file('file');

        $data = Backup::updateOrCreate($rawData, $rawData);

        if ($file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'backup/file/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('backup.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Backup::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'project_id' => 'numeric|required',
            'user_id' => 'numeric|required',
            'description' => 'string|required',
        ]);

        $request->validate([
            'file' => 'file|nullable|extensions:sqlite'
        ]);

        $file = $request->file('file');

        $data->update($rawData);

        if ($file) {
            if ($data->file) {
                Storage::delete($data->file);
            }

            $filePath = $this->fileUploadService->uploadFile($file, 'backup/file/');

            $data->update(['file' => $filePath]);
        }

        return redirect()->route('backup.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Backup::where('uuid', $uuid)->firstOrFail();

        if ($data->file) {
            Storage::delete($data->file);
        }
        $data->forceDelete();
        return redirect()->route('backup.index')->withNotify('Data berhasil dihapus');
    }
}
