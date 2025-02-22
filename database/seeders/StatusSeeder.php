<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['code' => 'pending', 'name' => 'Pending']);
        Status::create(['code' => 'active', 'name' => 'Active']);
        Status::create(['code' => 'expired', 'name' => 'Expired']);
        Status::create(['code' => 'suspend', 'name' => 'Suspend']);
    }
}
