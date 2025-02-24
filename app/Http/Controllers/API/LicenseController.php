<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\License;
use App\Models\LicenseUsed;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LicenseController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        $project = Project::where('group_id', $user->group_id)
                    ->with([
                        'license',
                        'license.category',
                        'license.status',
                        'group',
                    ])
                    ->first();

        if (!$project) {
            return $this->sendError('Your account does not have a valid license key.');
        }

        return $this->sendResponse(['license' => $project->license], 'License retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        $key = $request->key;

        $check = $this->check_license();

        if($check) {
            return $this->sendError('Your account already has a valid license key.');
        }

        $license = License::where('key', $key)->first();

        if (!$license) {
            return $this->sendError('Your license key is not registered in our system.');
        }

        if($license->is_used == true) {
            return $this->sendError('Your license key has been used.');
        }

        $user = Auth::user();

        $project = $this->generateProjectBySystem($user->group_id, $license->id);

        LicenseUsed::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);

        $license->load(['category', 'status'])->update([
            'is_used' => true
        ]);

        $license['license_use'] = $this->license_used($license->key);

        return $this->sendResponse(['license' => $license], 'Your license key matches in our system.');
    }

    private function check_license()
    {
        $user = Auth::user();
        $check = Project::where('group_id', $user->group_id)->exists();

        return $check;
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

    private function generateProjectBySystem($group_id, $license_id)
    {
        $code = strtoupper(Str::random(30));
        $code = preg_replace('/[^A-Z0-9]/', '', $code);
        $code = substr($code, 0, 20);

        $project = Project::create([
            'name' => $code,
            'code' => $code,
            'description' => 'Project ini digenerate otomatis oleh system pada ' . Carbon::now(),
            'group_id' => $group_id,
            'license_id' => $license_id,
        ]);

        return $project;
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
