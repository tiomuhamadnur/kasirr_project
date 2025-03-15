<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends BaseController
{
    public function index()
    {
        $asset = Asset::where('status', 'active')
                    ->where('type', 'file')
                    ->first();

        if (!$asset) {
            return $this->sendError('Data asset not found.');
        }

        return $this->sendResponse(['asset' => $asset], 'Data asset retrieved successfully.');
    }

    public function store(Request $request)
    {
        //
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
