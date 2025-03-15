<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoController extends BaseController
{
    public function index()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $promo = Promo::where('status', 'active')
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now)
                ->get();

        if (!$promo) {
            return $this->sendError('Data promo not found.');
        }

        return $this->sendResponse(['promo' => $promo], 'Data promo retrieved successfully.');
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
