<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public static function getJobBySlugAndStatusOpen($slug){
        return Job::where('user_id', Auth::id())->where('slug', $slug)->where('status', 'open')->first();
    }

    public static function getJobStatusClose($id){
        return Job::where('id', $id)->where('status', 'close')->first();
    }
    
}
