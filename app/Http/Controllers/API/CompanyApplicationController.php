<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\NotifyApplicationStatusChange;
use App\Http\Requests\ChangeApplicationStatusRequest;

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
        
        $job = Job::getJobByUserIdSlugAndStatusOpen($slug);
        
        // get company job vacancy based on status
        $applications = Application::getCompanyApplicationStatus($status, $job->id);
        if($applications->isEmpty()){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }
        
        // available status 'sent', 'interview', 'offered', 'hired', 'unsuitable'
        $message = Application::getApplicationMessage($status, $job->title);

        return response()->json([
            'status'    => 'Success',
            'message'   => $message,
            'data'      => $applications
        ], 200);
    }

    public function changeApplicationStatus($slug, $id, ChangeApplicationStatusRequest $request){
        // is job vacancy still available
        $job = Job::getJobBySlugAndStatusOpen($slug);
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Job is not available',
            ], 404);
        }

        // if applicant applied for the job
        $applicant = Application::where('user_id', $id)->where('job_id', $job->id)->first();
        if(!$applicant){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'This applicant do not apply for this job',
            ], 404);
        }

        // change status application
        $data = [
            'status' => $request->status,
        ];
        Application::where('user_id', $id)->where('job_id', $job->id)->update($data);
        
        // send notification
        NotifyApplicationStatusChange::dispatch('application status has change', Auth::user()->name, $request->status, $job->title);
        
        $applicant = Application::where('user_id', $id)->where('job_id', $job->id)->first();

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Successfully update status application to interview',
            'data'      => $applicant
        ], 200);
    }
}
