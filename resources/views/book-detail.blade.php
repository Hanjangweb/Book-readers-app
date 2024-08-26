@extends('layouts.app')

@section('main')
<div class="container mt-3 ">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <a href="{{route('home')}}" class="text-decoration-none text-dark ">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
            </a>
            <div class="row mt-4">
                <div class="col-md-4">
                    @if($books->image != '')
                    <img src="{{asset('uploads/books/'.$books->image)}}" alt="" class="card-img-top">
                    @else
                    <img src="https://placehold.co/260x400" alt="" class="card-img-top">
                    @endif
                    {{-- <img src="images/book06.jpg" alt="" class="card-img-top"> --}}
                </div>
                <div class="col-md-8">
                    @include('layouts.message')
                    <h3 class="h2 mb-3">{{$books->title}}</h3>
                    <div class="h4 text-muted">{{$books->author}}</div>
                    <div class="star-rating d-inline-flex ml-2" title="">
                        <span class="rating-text theme-font theme-yellow">5.0</span>
                        <div class="star-rating d-inline-flex mx-2" title="">
                            <div class="back-stars ">
                                <i class="fa fa-star " aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>

                                <div class="front-stars" style="width: 100%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <span class="theme-font text-muted">(0 Review)</span>
                    </div>

                    <div class="content mt-3">
                       {{$books->description}}
                    </div>

                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h2 class="h3 mb-4">Readers also enjoyed</h2>
                        </div>
                        @if ($relatedBooks->isNotEmpty())
                            @foreach ($relatedBooks as $relatedBook)
                                <div class="col-md-4 col-lg-4 mb-4">
                                    <div class="card border-0 shadow-lg">

                                        <a href="{{route('book.detail',$relatedBook->id)}}">
                                            @if($relatedBook->image != '')
                                            <img src="{{asset('uploads/books/'.$relatedBook->image)}}" alt="" class="card-img-top">
                                            @else
                                            <img src="https://placehold.co/260x400" alt="" class="card-img-top">
                                            @endif
                                            {{-- <img src="{{asset('images/book02.jpg')}}" alt="" class="card-img-top"> --}}
                                        </a>
                                        <div class="card-body">
                                            <h3 class="h4 heading"><a href="{{route('book.detail',$relatedBook->id)}}">{{$relatedBook->title}}</a></h3>
                                            <p>{{$relatedBook->author}}</p>
                                            <div class="star-rating d-inline-flex ml-2" title="">
                                                <span class="rating-text theme-font theme-yellow">0.0</span>
                                                <div class="star-rating d-inline-flex mx-2" title="">
                                                    <div class="back-stars ">
                                                        <i class="fa fa-star " aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                    
                                                        <div class="front-stars" style="width: 70%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="theme-font text-muted">(0)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                                         
                    </div>
                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12  mt-4">
                            <div class="d-flex justify-content-between">
                                <h3>Reviews</h3>
                                <div>
                                    @if (Auth::check())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Add Review
                                        </button>
                                        @else
                                        <a href="{{route('account.login')}}" class="btn btn-primary">Add Review</a>
                                    @endif
                                   
                                      
                                </div>
                            </div>                        
                            @if ($books->reviews->isNotEmpty())
                                @foreach ($books->reviews as $review )
                                    
                                <div class="card border-0 shadow-lg my-4">
                                    <div class="card-body">
                                        {{-- @foreach ($reviews as $review ) --}}
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mb-3">{{$review->user->name}}</h4>
                                                <span class="text-muted">
                                                    {{\Carbon\Carbon::parse($review->created_at)->format('d M,Y')}}    
                                                </span>         
                                            </div>
                                        @php
                                            $ratingPer = ($review->rating/5)*100;
                                        @endphp
                                            <div class="mb-3">
                                                <div class="star-rating d-inline-flex" title="">
                                                    <div class="star-rating d-inline-flex " title="">
                                                        <div class="back-stars ">
                                                            <i class="fa fa-star " aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>

                                                            <div class="front-stars" style="width: {{$ratingPer}}%">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                                                
                                            </div>
                                            <div class="content">
                                                <p>{{$review->review}}</p>
                                            </div>
                                
                                        
                                    </div>
                                </div>  
                                @endforeach
                            @endif
                                                        
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>   

<!-- Modal -->
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="bookReviewForm" name="bookReviewForm">
                <div class="modal-body">
                    @if(Auth::check())
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @else
                        <p>Please <a href="{{ route('account.login') }}">log in</a> to submit a review.</p>
                    @endif
                    <input type="hidden" name="book_id" value="{{ $books->id }}">
            
                    <div class="mb-3">
                        <label for="" class="form-label">Review</label>
                        <textarea name="review" id="review" class="form-control " cols="5" rows="5" placeholder="Review"></textarea>
                        <p class="invalid-feedback" id="review-errors"></p>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#bookReviewForm').submit(function(e) {
        e.preventDefault(); // Moved the closing parenthesis here
        $.ajax({
            url: '{{route("book.reviewSave")}}',
            type: 'post',
            data: $('#bookReviewForm').serializeArray(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
            
                if(response.status == false) {
                    var errors = response.errors;
                    if(errors.review) {
                        $('#review').addClass('is-invalid');
                        $('#review.errors').html(errors.review[0]);
                    } else {
                        $('#review').removeClass('is-invalid');
                        $('#review.errors').html('');
                    }
                } else {
                    window.location.href = "{{route('book.detail', $books->id)}}";
                }
            },     
        });
    })
</script>
@endsection
