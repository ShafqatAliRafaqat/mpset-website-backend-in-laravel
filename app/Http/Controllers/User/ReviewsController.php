<?php

namespace App\Http\Controllers\User;

use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;
use App\Http\Resources\ReviewsResource;
use Illuminate\Support\Facades\Auth;


class ReviewsController extends Controller {

    public function locationReviews($local,$id){
        $reviews = Review::where('location_id',$id)->with('reviewer')->get();
        return ReviewsResource::collection($reviews);
    }

    public function eventReviews($local,$id){
        $reviews = Review::where('event_id',$id)->with('reviewer')->get();
        return ReviewsResource::collection($reviews);
    }

    public function createUserReview(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input, [
            'rating' => 'required',
            'comment' => 'present',

            'user_id' => 'required|numeric',
            'asHost' => 'required',
        ]);

        Review::create([
            'rating' => $input['rating'],
            'comment' => $input['comment'],
            'reviewer_id' => Auth::user()->id,
            'user_id' => $input['user_id'],
            'asHost' => $input['asHost'],
            'host_event_id' => 0,
        ]);

        return [
            'message' => 'Review Added Successfully'
        ];

    }

    public function createLocationReview(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input, [
            'rating' => 'required',
            'comment' => 'present',
            'location_id' => 'required|numeric',
        ]);

        Review::create([
            'rating' => $input['rating'],
            'comment' => $input['comment'],
            'location_id' => $input['location_id'],
            'reviewer_id' => Auth::user()->id,
            'user_id' => 0,
            'asHost' => 0,
            'host_event_id' => 0,
        ]);

        return [
            'message' => 'Review Added Successfully'
        ];

    }

    public function playerReviews($local,$id){
        $reviews = Review::where([
            ['user_id',$id],
            ['asHost',0],
        ])->with('reviewer')->get();
        return ReviewsResource::collection($reviews);
    }

    public function hostReviews($local,$id){
        $reviews = Review::where([
            ['user_id',$id],
            ['asHost',1],
        ])->with('reviewer')->get();
        return ReviewsResource::collection($reviews);
    }



}
