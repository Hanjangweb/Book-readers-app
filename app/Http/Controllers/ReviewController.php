<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //this method will show  Review backend
    public function index( ){
        $reviews = Review::with('book')->orderBy("created_at", "desc")->paginate(2);
        return view("account.reviews.list", compact("reviews"));

    }
    public function myReview(Request $request){
        $reviews = Review::with('book')->orderBy("created_at", "desc")->paginate(2);
        return view("account.reviews.myReview", compact("reviews"));
    }
    public function destroy(String $id){
       $review = Review::findOrFail($id);
       $review->delete();
       return redirect()->back()->with("success","You have deleted Successfully");
    }
}
