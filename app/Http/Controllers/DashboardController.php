<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Backup;
use App\Models\Group;
use App\Models\License;
use App\Models\Project;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $group = Group::count();
        $license = License::count();
        $project = Project::count();
        $backup = Backup::count();
        $asset = Asset::count();
        $promo = Promo::count();

        return view('pages.user.dashboard.index', compact([
            'user',
            'group',
            'license',
            'project',
            'backup',
            'asset',
            'promo',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
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
