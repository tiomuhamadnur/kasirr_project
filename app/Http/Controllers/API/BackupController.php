<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\BackupResource;
use App\Models\Backup;
use App\Models\Project;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackupController extends BaseController
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $group_id = Auth::user()->group_id;

        if (!$group_id) {
            return $this->sendError('User has no group assigned.');
        }

        $backup = Backup::with(['project', 'user', 'user.gender', 'user.group', 'user.role', 'project.license', 'project.license.status', 'project.group'])->whereRelation('project.group', 'id', '=', $group_id)->latest()->first();

        if (!$backup) {
            return $this->sendError('Data backup not found.');
        }

        return $this->sendResponse(['backup' => $backup], 'Backup retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'file|required|extensions:db',
        ]);

        $file = $request->file('file');

        $user = Auth::user();
        $group_id = $user->group_id;

        if (!$group_id) {
            return $this->sendError('User has no group assigned.');
        }

        $project = Project::where('group_id', $group_id)->first();

        if (!$project) {
            return $this->sendError('User has no project assigned.');
        }

        $rawdata = [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'description' => 'Data ini digenerate melalui API oleh ' . $user->name . ' (pada ' . Carbon::now() . ').',
        ];

        $backup = Backup::updateOrCreate($rawdata, $rawdata);
        $backup->load(['project', 'user', 'user.gender', 'user.group', 'user.role', 'project.license', 'project.license.status', 'project.group']);

        if ($file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'backup/file/');
            $backup->update([
                'file' => $filePath,
            ]);
        }

        return $this->sendResponse(['backup' => $backup], 'Data backup uploaded successfully.');
    }

    public function show()
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
