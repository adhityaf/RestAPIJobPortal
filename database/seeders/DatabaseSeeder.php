<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Application;
use App\Models\UserApplication;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Location::factory(10)->create();
        $categories = Category::getRawData();
        // create company
        $companies = User::factory(3)->create([
            'role' => 'company'
        ]);
        // create applicant
        User::factory(10)->create([
            'role' => 'applicant'
        ]);
        
        foreach($categories as $category){
            $newCategory = Category::factory()->create([
                'name' => $category,
            ]);
        }
        foreach($companies as $company){
            Job::factory(5)->create([
                'user_id' => $company->id,
                'location_id' => Location::inRandomOrder()->first()->id,
                'category_id' => $newCategory->inRandomOrder()->first()->id,
            ]);
        }
        // make 10 application
        Application::factory(10)->create();
    }
}
