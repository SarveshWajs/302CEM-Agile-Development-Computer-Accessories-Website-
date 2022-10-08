@extends('layouts.app')
@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                   Food Blog
                </h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Food Blog
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<br/>


<!-- Breadcrumb Section End -->
<section class="blog spad">
   <div class="container">
      <div class="row justify-content-center">
            @foreach($blogs as $blog)
            <div class="col-md-6" style="margin-bottom: 30px;">
                <div class="form-group">
                    <div class="flip-card">
                       <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <div style="width: 100%;height:300px; background-image: url({{ url($blog->image) }}); background-position: center; background-size: cover; background-repeat: no-repeat;">
                                </div>
                                <!-- <img src="{{ url($blog->image) }}" width="100%"> -->
                            </div>
                            <div class="flip-card-back">
                                   
                               <div class="b">
                                   <h3 align="center">{{ $blog->title }}</h3>
                               </div>

                                <i class="fa fa-tag fa-1.5x"></i> 
                                  
                               <div class="a">
                                    <p style="color:black; font-size:18px"> {{ $blog->blog_tags }}</p>
                               </div>
                                       
                                <i class="fa fa-calendar fa-1.5x" aria-hidden="true"> </i>
                                      
                                <div class="a" style="padding-bottom: 0px;">
                                    <p style="color:black;font-size:18px"> {{ date('M d, Y', strtotime($blog->blog_date)) }}</p>
                                </div>

                                <a href="{{ route('blog_details', $blog->id) }}"class="btn btn-primary">READ MORE</a>
                                  
                            </div>
                        </div>
                     </div>
                </div>
            </div>
            @endforeach
        </div>
   </div>
 </div>
  </section>
  <br/>
@endsection