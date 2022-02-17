<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyApplicationController extends Controller
{
    public function listApplicant($slug){
        $status = Request()->query('status');
        
        // if status not available
        // available status 'sent', 'interview', 'offered', 'hired', 'unsuitable'
        if(!($status == '' || $status == 'sent' || $status == 'interview' || $status == 'offered' || $status == 'hired' || $status == 'hired')){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Status is not available',
            ], 400);
        }
        
        $job = Job::getJobBySlugAndStatusOpen($slug);
        // dd($slug, $job->id);
        $applications = Application::getCompanyApplicationStatus($status, $job->id);

        if($applications->isEmpty()){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }
        
        // available status 'sent', 'interview', 'offered', 'hired', 'unsuitable'
        if($status == 'sent'){
            $message = "Retrieve data with status 'sent' and job title is " .$job->title . " successfully";
        }elseif($status == 'interview'){
            $message = "Retrieve data with status 'interview' and job title is " .$job->title . " successfully";
        }elseif($status == 'offered'){
            $message = "Retrieve data with status 'offered' and job title is " .$job->title . " successfully";
        }elseif($status == 'hired'){
            $message = "Retrieve data with status 'hired' and job title is " .$job->title . " successfully";
        }elseif($status == 'unsuitable'){
            $message = "Retrieve data with status 'unsuitable' and job title is " .$job->title . " successfully";
        }elseif(!$status){
            $message = "Retrieve all data with job title is " .$job->title . " successfully";
        }

        return response()->json([
            'status'    => 'Success',
            'message'   => $message,
            'data'      => $applications
        ], 200);
    }

    public function changeStatusToInterview($slug, $id){
        $job = Job::where('slug', $slug)->where('status', 'open')->first();
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }

        $data = [
            'status' => 'interview',
        ];
        $application = Application::where('user_id', $id)->where('job_id', $job->id)->update($data);

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Successfully update status application to interview',
            'data'      => $application
        ], 200);
    }

    public function changeStatusToOffered($slug, $id){
        $job = Job::where('slug', $slug)->where('status', 'open')->first();
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }

        $data = [
            'status' => 'offered',
        ];
        $application = Application::where('user_id', $id)->where('job_id', $job->id)->update($data);
        
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Successfully update status application to offered',
            'data'      => $application
        ], 200);
    }

    public function changeStatusToHired($slug, $id){
        $job = Job::where('slug', $slug)->where('status', 'open')->first();
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }

        $data = [
            'status' => 'hired',
        ];
        $application = Application::where('user_id', $id)->where('job_id', $job->id)->update($data);
        
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Successfully update status application to hired',
            'data'      => $application
        ], 200);
    }

    public function changeStatusToUnsuitable($slug, $id){
        $job = Job::where('slug', $slug)->where('status', 'open')->first();
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }

        $data = [
            'status' => 'unsuitable',
        ];
        $application = Application::where('user_id', $id)->where('job_id', $job->id)->update($data);
        
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Successfully update status application to unsuitable',
            'data'      => $application
        ], 200);
    }
}
