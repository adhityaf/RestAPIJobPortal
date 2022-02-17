<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\Category;
use App\Models\Location;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SendApplicationRequest;

class ApplicantApplicationController extends Controller
{
    public function index(){
        $status = Request()->query('status');
        
        // if status not available
        // available status 'sent', 'interview', 'offered', 'hired', 'unsuitable'
        if(!($status == '' || $status == 'sent' || $status == 'interview' || $status == 'offered' || $status == 'hired' || $status == 'hired')){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Status is not available',
            ], 400);
        }

        // get applicant application status
        $application = Application::getApplicantApplicationStatus($status);
        if($application->isEmpty()){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }
        
        // available status 'sent', 'interview', 'offered', 'hired', 'unsuitable'
        if($status == 'sent'){
            $message = "Retrieve data with status 'sent' successfully";
        }elseif($status == 'interview'){
            $message = "Retrieve data with status 'interview' successfully";
        }elseif($status == 'offered'){
            $message = "Retrieve data with status 'offered' successfully";
        }elseif($status == 'hired'){
            $message = "Retrieve data with status 'hired' successfully";
        }elseif($status == 'unsuitable'){
            $message = "Retrieve data with status 'unsuitable' successfully";
        }elseif(!$status){
            $message = "Retrieve all data successfully";
        }
        
        return response()->json([
            'status'    => 'Success',
            'message'   => $message,
            'data'      => $application
        ], 200);
    }

    public function sendApplication(SendApplicationRequest $request, $slug){
        // get data job
        $job = Job::getJobBySlug($slug);
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'This Data is empty',
            ], 404);
        }

        // if already applied
        $applied = Application::getApplicationByUserIdAndJobId($job->id);
        if($applied){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You already applied on this job vacancy',
            ], 400);
        }

        // if job vacancy status close
        $closedJob = Job::getJobStatusClose($job->id);
        if($closedJob){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'This job vacancy has been closed',
            ], 404);
        }
        
        // create new applicatian default status is sent
        $data = [
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'attachment'  => $request->attachment,
            'status' => 'sent'
        ];
        $apply = Application::create($data);

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Your application was sent successfully',
            'data'      => $apply
        ], 201);
    }
}
