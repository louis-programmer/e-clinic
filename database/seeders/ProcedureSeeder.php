<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Modules\Patients\Models\Procedure;

class ProcedureSeeder extends Seeder
{
    public function run(): void
    {
        Procedure::insert([
            [
                'name' => 'Tooth Extraction',
                'category' => 'surgical',
                'price' => 1500,
            ],
            [
                'name' => 'Oral Prophylaxis',
                'category' => 'preventive',
                'price' => 800,
            ],
            [
                'name' => 'Dental Filling',
                'category' => 'restorative',
                'price' => 1200,
            ],
        ]);
    }
}