<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitRequest;

class VisitRequestSeeder extends Seeder
{
    public function run()
    {
        VisitRequest::factory()->count(10)->create();
    }
}
