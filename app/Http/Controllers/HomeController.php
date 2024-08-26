<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at','asc')->where('status',1);
    
        if(!empty($request->keyword)){
            $books = $books->where("title","like", "%".$request->keyword."%");
        }
    
        $books = $books->paginate(4); // Paginate before execution
        return view('home', compact('books'));
    }

    public function detail($id){
        
        $books = Book::with('reviews.user','reviews')->where('status',1)->findOrFail($id);
      

        if($books->status == 0 ){
            abort(404);
        }

        $relatedBooks = Book::where('status',1)->take(5)->where('id' , '!=' , $id)->inRandomOrder()->get();
        return view('book-detail', compact('books','relatedBooks'));
    }
    //Review save 
   
    // public function reviewSave(Request $request) {
      
    //         // Validate the request
    //         $validator = Validator::make($request->all(), [
    //             'review' => 'required',
    //             'rating' => 'required',
    //         ]);
    
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'errors' => $validator->errors()
    //             ]);
    //         }
    
    //         // Create a new review
    //         $reviews = new Review();
    //         $reviews->review = $request->review;
    //         $reviews->rating = $request->rating;
    //         $reviews->user_id = $request->user_id;
    //         $reviews->book_id = $request->book_id;
    //         $reviews->save();
    
    //         // Flash message (optional for AJAX)
    //         Session()->flash('success', 'Successfully Submitted');
    
    //         return response()->json([
    //             'status' => true,
    //         ]);
    
    // }

    public function reviewSave(Request $request) {
        // dd($request->all()); // Check the received data
    
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'rating' => 'required',
        ]);
     
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        //apply condition here
        $countReview = Review::where('user_id',Auth::user()->id)->where('book_id',$request->book_id)->count();
    
        if($countReview > 0){
            Session()->flash('error','You already submitted a review');
            return response()->json([
                'status'=> true,
            ]);
        }
      
    
        $reviews = new Review();
        $reviews->review = $request->review;
        $reviews->rating = $request->rating;
        $reviews->user_id = Auth::user()->id;
        $reviews->book_id = $request->book_id;
        $reviews->save();
    
        Session()->flash('success', 'Successfully Submitted');
    
        return response()->json([
            'status' => true,
        ]);

        
    }
    public function showReview() {
      
        $reviews = review::orderBy("created_at","asc"); 
             
        return view("books.detail", compact("reviews"));
    }
    
    
}
