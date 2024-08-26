@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome {{ Auth::user()->name}}                        
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if (Auth::user()->image != "") 
                           <img src="{{asset('uploads/profile/'.Auth::user()->image)}}" class="img-fluid rounded-circle" alt="Luna John"> 
                        @endif
                                                  
                    </div>
                    <div class="h5 text-center">
                        <strong>{{Auth::user()->name}}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header  text-white">
                    Navigation
                </div>
               @include('layouts.sidebar')
            </div>
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="col-md-9">
                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">            
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if ($reviews->isNotEmpty())
                                    @foreach ($reviews as $review )
                                    <tr>
                                        <td>{{$review->book->title}}</td>
                                        <td>{{$review->review}}</td>                                        
                                        <td>{{$review->rating}}</td>
                                        <td>
                                            @if ($review->book->status == 1)
                                               <span class="text-success">Active</span>
                                            @else
                                               <span class="text-danger">Block</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="edit-review.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{route('account.destroy',$review->id)}}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>   
                                    @endforeach
                                        
                                    @endif
                                                                  
                                </tbody>
                            </thead>
                        </table>   
                        {{$reviews->links()}}
                        {{-- <nav aria-label="Page navigation " >
                            <ul class="pagination">
                              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                              <li class="page-item"><a class="page-link" href="#">2</a></li>
                              <li class="page-item"><a class="page-link" href="#">3</a></li>
                              <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>                   --}}
                    </div>
                    
                </div>                
            </div>  
        </div>
    </div>       
</div>
@endsection