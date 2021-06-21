<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkB = Type::where('name', 'Bucket')->first();
        if ($checkB === null) {
            Type::create([
                'name' => 'Bucket',
                'display' => 'block',
                'required' => 1,
            ]);
        }
        $checkP = Type::where('name', 'Plain Contract')->first();
        if ($checkP === null) {
            Type::create([
                'name' => 'Plain Contract',
                'display' => 'none',
                'required' => 0,
            ]);
        }
    }
}
