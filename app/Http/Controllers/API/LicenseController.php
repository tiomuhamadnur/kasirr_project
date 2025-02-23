<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\License;
use App\Models\LicenseUsed;
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

        LicenseUsed::create([
            'project_id' => $project->id,
            'user_id' => auth()->user()->id,
        ]);

        $license['license_use'] = $this->license_used($license->key);

        return $this->sendResponse(['license' => $license], 'Your license key matches in our system.');
    }

    private function license_used($licenseKey)
    {
        $licenseUsed = LicenseUsed::whereRelation('project.license', 'key', $licenseKey)
            ->with([
                'user',
                'user.group',
                'user.gender',
                'user.role',
            ])
            ->get();

        return [
            'used' => $licenseUsed->isNotEmpty(),
            'used_count' => $licenseUsed->count(),
            'used_by' => $licenseUsed->map(fn($item) => $item->user)->all(),
        ];
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
