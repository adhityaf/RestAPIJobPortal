<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function getRawData(){
        $data =['Web Development', 'Marketing', 'Data & Analytics', 'Sales & Business Development', 'Customer Service', 'Mobile Development', 'UI/UX Design', 'Academics'];
        return $data;
    }

    public static function getCategoryName($categoryName){
        return Category::where('name', $categoryName)->first();
    }
}
