<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::orderBy("created_at","asc");

        if(!empty($request->keyword)){
            $books = $books->where("title","like", "%".$request->keyword."%");
        }
        $books = $books->paginate(2);
        return view("books.list", compact("books"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("books.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            "title"=> "required",
            "author"=>"required",
            "status"=> "required",

        ];

        $validator =validator($request->all());

        if(!empty($request->image)){
            $rules['image'] = 'image';
           
        }
        if ($validator->fails()){
            return redirect()->route('books.create')->withErrors($validator)->withInput();
        }

        
        //Add Books Now
        $books = new Book();
        $books->title = $request->title;
        $books->author = $request->author;
        $books->description = $request->description;
        $books->status = $request->status;
      
        $books->save();

        //upload book image
        if(!empty($request->image)){
            //delete old image
            File::delete(public_path('uploads/books/'.$books->image));
             $image = $request->image;
             
             $ext =$image->getClientOriginalExtension();
             $imageName = time().'.'.$ext;
             $image->move(public_path('/uploads/books'), $imageName);
             
             $books->image = $imageName;
             $books->save();
         }

        return redirect()->route('books.index')->with('success','Your books created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $books = Book::findorfail($id);
        return view('books.edit', compact('books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $books = Book::findorfail($id);
          // Update the book record with request data
        // Only include the fields that are fillable
       $books->update($request->only(['title', 'author', 'description', 'status']));
        $rules =  [
            "title"=> "required",
            "author"=>"required",
            "status"=> "required",

        ];

        $validator =validator($request->all());

        if(!empty($request->image)){
            $rules['image'] = 'image';
           
        }
        if ($validator->fails()){
            return redirect()->route('books.edit')->withErrors($validator)->withInput();
        }

        
        //Update Books Now
    
        $books->title = $request->title;
        $books->author = $request->author;
        $books->description = $request->description;
        $books->status = $request->status;
      
        $books->save();

        //upload book image
        if(!empty($request->image)){
            //delete old image
            File::delete(public_path('uploads/books/'.$books->image));
            //File::delete(public_path('uploads/books/thumb'.$books->image));
             $image = $request->image;
             
             $ext =$image->getClientOriginalExtension();
             $imageName = time().'.'.$ext;
             $image->move(public_path('/uploads/books'), $imageName);
             
             $books->image = $imageName;
             $books->save();

            //Generate Image Thumnail
            //  $manager = new ImageManager(Driver::class);
            //  $image = $manager->read(public_path('uploads/books/'.$imageName));
            //  $image->resize(0,0);
            //  $image->save(public_path('uploads/books/thumb/'.$imageName));
         }

        return redirect()->route('books.index')->with('success','Your books created Successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $books = Book::find($id);

        if($books == null){
            Session()->flash('error','Book Not Found');
            return response()->json([
                'status' => false,
                'message'=> 'Book Not Found'
            ]);

        }else{
            File::delete(public_path('uploads/books/'.$books->image));
            $books->delete();

            Session()->flash('success','Book Deleted successfully');
            return response()->json([
                'status' => true,
                'message'=> 'Book Deleted successfully.'
            ]);
        }
    }
}
