<?php

namespace App\Http\Controllers\user;

use App\DataTables\ProjectDataTable;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\License;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(ProjectDataTable $dataTable)
    {
        $license = License::all();
        $group = Group::all();

        return $dataTable->render('pages.user.project.index', compact([
            'license',
            'group',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:project,code',
            'description' => 'string|required',
            'group_id' => 'numeric|required',
            'license_id' => 'numeric|required',
        ]);

        Project::updateOrCreate($data, $data);

        return redirect()->route('project.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Project::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            'description' => 'string|required',
            'group_id' => 'numeric|required',
            'license_id' => 'numeric|required',
        ]);

        $data->update($rawData);
        return redirect()->route('project.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Project::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('project.index')->withNotify('Data berhasil dihapus');
    }
}
