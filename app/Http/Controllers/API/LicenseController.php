<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Project;
use Illuminate\Http\Request;

class LicenseController extends BaseController
{
    public function index()
    {
        $project = Project::where('group_id', auth()->user()->group_id)
                    ->with([
                        'license',
                        'license.category',
                        'license.status',
                        'group',
                    ])
                    ->first();

        if (!$project) {
            return $this->sendError('User has no project assigned.');
        }

        $result = [
            'project' => $project
        ];

        return $this->sendResponse($result, 'License retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        $user_key = $request->key;

        $project = Project::where('group_id', auth()->user()->group_id)
                    ->with(['license.category', 'license.status'])
                    ->first();

        if (!$project) {
            return $this->sendError('User has no project assigned.');
        }

        $license = $project->license;

        if (!$license || !$license->key) {
            return $this->sendError('User has no license key.');
        }

        if ($user_key !== $license->key) {
            return $this->sendError('Your license key is not registered in our system.');
        }

        return $this->sendResponse(['license' => $license], 'Your license key matches in our system.');
    }


    public function show(string $id)
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
