<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;

class JobController extends Controller
{
    public function index(){
        // filter by category or location
        $category = Request()->query('category');
        $location = Request()->query('location');

        if($category && $location){
            $dataCategory = Category::getCategoryName($category);
            $dataLocation = Location::getLocationName($location);

            if(!$dataCategory && !$dataLocation){
                // if data category and data location is empty

                return response()->json([
                    'status'    => 'Failed',
                    'message'   => 'Data with category named ' . $category . ' and location named ' . $location . ' does not exist',
                ], 404);
            }else if(!$dataCategory){
                // if data category is empty
                $jobs = Job::where('location_id', $dataLocation->id)->where('status', 'open')->get();
                
                $message = "Retrieve all data with location named " . $dataLocation->name . " successfully";
            }else if(!$dataLocation){
                // if data location is empty
                $jobs = Job::where('category_id', $dataCategory->id)->where('status', 'open')->get();
                
                $message = "Retrieve all data with category named " . $dataCategory->name . " successfully";
            }else{
                // if data category and data location exist
                $jobs = Job::where('location_id', $dataLocation->id)->orWhere('category_id', $dataCategory->id)->where('status', 'open')->get();

                $message = "Retrieve all data with location named " . $dataLocation->name . " and category named " . $dataCategory->name . " successfully";
            }
        }else if($category){
            $dataCategory = Category::getCategoryName($category);
        
            if(!$dataCategory){
                return response()->json([
                    'status'    => 'Failed',
                    'message'   => 'Data with location named ' . $category . ' does not exist',
                ], 404);
            }

            $jobs = Job::where('category_id', $dataCategory->id)->where('status', 'open')->get();

            $message = "Retrieve all data " . $dataCategory->name . " successfully";
        }else if($location){
            $dataLocation = Location::getLocationName($location);
            
            if(!$dataLocation){
                return response()->json([
                    'status'    => 'Failed',
                    'message'   => 'Data with location named ' . $location . ' does not exist',
                ], 404);
            }

            $jobs = Job::where('location_id', $dataLocation->id)->where('status', 'open')->get();

            $message = "Retrieve all data " . $dataLocation->name . " successfully";
        }else{
            $jobs = Job::where('status', 'open')->get();

            $message = "Retrieve all data successfully";
        }

        if($jobs->isEmpty()){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Data is empty',
            ], 404);
        }
        
        return response()->json([
            'status'    => 'Success',
            'message'   => $message,
            'data'      => $jobs
        ], 200);
    }

    /*
        Scopes point 2
        The app can manage company job vacancies
    */
    public function store(StoreJobRequest $request){
        $createdJob = Job::create([
            'user_id'       => Auth::user()->id,
            'location_id'   => $request->location_id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'description'   => $request->description,
            'status'        => 'open',
            'type'          => $request->type,
            'level'         => $request->level
        ]);

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Create data successfully',
            'data'      => $createdJob
        ], 201);
    }

    public function show($slug){
        // show single data from table job
        $job = Job::where('slug', $slug)->first();

        // If data job doesn't exist
        if(!$job){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Job does not exist',
            ], 404);
        }

        // if data job does exist
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Retrive single data successfully',
            'data'      => $job
        ], 200);
    }

    /*
        Scopes point 2
        The app can manage company job vacancies
    */
    public function update(UpdateJobRequest $request, $slug){
        $isJobExist = Job::where('slug', $slug)->first();
        $job = Job::where('user_id', Auth::id())->where('slug', $slug)->first();

        if(!$isJobExist){
            // if job does not exist
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Job does not exist',
            ], 404);
        }elseif(!$job){
            // if job not made by auth user 
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You can\'t update this data',
            ], 401);
        }

        $data = [
            'location_id'   => $request->location_id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'description'   => $request->description,
            'status'        => $request->status,
            'type'          => $request->type,
            'level'         => $request->level
        ];

        Job::where('user_id', Auth::id())->where('slug', $slug)->update($data);
        
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Update data successfully',
            'data'      => $data
        ], 201);
    }

    /*
        Scopes point 2
        The app can manage company job vacancies
    */
    public function destroy($slug){
        $isJobExist = Job::where('slug', $slug)->first();
        $job = Job::where('user_id', Auth::id())->where('slug', $slug)->first();

        if(!$isJobExist){
            // if job does not exist
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Job does not exist',
            ], 404);
        }elseif(!$job){
            // if job not made by auth user 
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You can\'t delete this data',
            ], 401);
        }

        Job::where('user_id', Auth::id())->where('slug', $slug)->delete();
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Delete data successfully',
        ], 200);
    }
}
