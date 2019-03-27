<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\ReviewsResource;
use App\Review;
use App\Http\Controllers\Controller;

class AdminReviewsController extends Controller {

    public function index(){
        $reviews = Review::query()->with('reviewer')->paginate(5);
        return ReviewsResource::collection($reviews);
    }

}
