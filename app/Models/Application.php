<?php

namespace App\Models;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public static function getApplicantApplicationStatus($status = null){
        if(!$status){
            $application = Application::where('user_id', Auth::id())->get();
            return $application;
        }
        $application = Application::where('user_id', Auth::id())->where('status', $status)->get();
        return $application;
    }

    public static function getCompanyApplicationStatus($status = null, $jobId){
        if(!$status){
            $applications = Application::where('job_id', $jobId)->get();
            return $applications;
        }
        $applications = Application::where('status', $status)->where('job_id', $jobId)->get();
        return $applications;
    }

    public static function getApplicationByUserIdAndJobId($id){
        return Application::where('user_id', Auth::id())->where('job_id', $id)->first();
    }

    public static function getApplicationMessage($status, $jobTitle){
        if($status == 'sent'){
            $message = "Retrieve data with status ". $status . " and job title is " . $jobTitle . " successfully";
        }elseif($status == 'interview'){
            $message = "Retrieve data with status ". $status . " and job title is " . $jobTitle . " successfully";
        }elseif($status == 'offered'){
            $message = "Retrieve data with status ". $status . " and job title is " . $jobTitle . " successfully";
        }elseif($status == 'hired'){
            $message = "Retrieve data with status ". $status . " and job title is " . $jobTitle . " successfully";
        }elseif($status == 'unsuitable'){
            $message = "Retrieve data with status ". $status . " and job title is " . $jobTitle . " successfully";
        }elseif(!$status){
            $message = "Retrieve all data with job title is " . $jobTitle . " successfully";
        }
        return $message;
    }
}
