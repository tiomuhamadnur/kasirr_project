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

class BackupController extends BaseController
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $group_id = optional(auth()->user()->group)->id;
        if (!$group_id) {
            return $this->sendError('User has no group assigned.');
        }

        $backup = Backup::whereRelation('project.group', 'id', '=', $group_id)->latest()->first();

        if (is_null($backup)) {
            return $this->sendError('Data backup not found.');
        }

        $result = [
            'url' => asset('/storage/' . $backup->file),
            'project_name' => $backup->project->name,
            'description' => $backup->description,
            'uploaded_by' => $backup->user->name,
            'uploaded_at' => $backup->updated_at,
        ];

        return $this->sendResponse($result, 'Backup retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'file|nullable|extensions:sqlite',
        ]);

        $file = $request->file('file');

        $project = Project::where('group_id', auth()->user()->group_id)
            ->with(['group', 'license', 'license.status'])
            ->first();

        if (!$project) {
            return $this->sendError('User has no project assigned.');
        }

        $rawdata = [
            'project_id' => $project->id,
            'user_id' => auth()->user()->id,
            'description' => 'Data ini digenerate melalui API oleh ' . auth()->user()->name . ' (pada ' . Carbon::now() . ')',
        ];

        $backup = Backup::updateOrCreate($rawdata, $rawdata);

        if ($file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'backup/file/');
            $backup->update([
                'file' => $filePath,
            ]);
        }

        $result = [
            'url' => asset('/storage/' . $backup->file),
            'project' => $project,
            'description' => $backup->description,
            'uploaded_by' => $backup->user->name,
            'uploaded_at' => $backup->updated_at,
        ];

        return $this->sendResponse($result, 'Data backup uploaded successfully.');
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
