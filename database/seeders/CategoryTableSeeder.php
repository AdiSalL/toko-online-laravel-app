<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $category1 = new Category();
        $category1->name = "Sepatu";
        $category1->save();

        $category2 = new Category();
        $category2->name = "Sandal";
        $category2->save();
        
        $category3 = new Category();
        $category3->name = "Tas";
        $category3->save();
        
        $category4 = new Category();
        $category4->name = "Celana";
        $category4->save();
        
        $category5 = new Category();
        $category5->name = "Celana Panjang  ";
        $category5->save();
        
    }
}
