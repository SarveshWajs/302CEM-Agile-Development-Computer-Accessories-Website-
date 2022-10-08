@extends('layouts.app')

@section('content')
<section class="background-page">
	<section class="bg-light">
	    <div class="container">
	        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
	            <div class="col-lg-6">
	                <h1 class="h2 text-uppercase mb-0">
	                	Fitness Gallery Journeys
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
	                        	Fitness Gallery Journeys
	                        </li>
	                    </ol>
	                </nav>
	            </div>
	        </div>
	    </div>
	</section>
<!-- Breadcrumb Section End -->


	<section class="py-5">
	    <div class="container">
	        <div class="col-lg-12 posts-list">
	        	<div class="row">
	          	@foreach($galleries as $key => $gallery)
	          	@php
	          	$exp_one = explode(".", $gallery->image);
       			$file_ext_one = end($exp_one);
        		@endphp
				<div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 30px;">
					<a href="#"  data-toggle="modal" data-target=".asd{{ $key }}" data-backdrop="false">
					@if($file_ext_one == 'pdf')
						<div class="link-wrap" style="width: 100%;height: 100%; position: absolute;"></div>
						<iframe src="{{ url($gallery->image) }}" width="100%" style="height:200px; z-index: -1">
						</iframe>
					@elseif($file_ext_one == 'mp4')
						<video height="200px" autoplay controls style="width: 100%;">
							<source src="{{ url($gallery->image) }}" type="video/mp4">
						</video>
					@else
	                <div style="width: 100%; height: 200px; background-image: url({{ url($gallery->image) }}); background-position: center; background-size: cover; background-repeat: no-repeat;">
	                </div>
	                @endif
	            	</a>
					<div class="modal fade asd{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					    <div class="modal-dialog" role="document">
						    <div class="modal-content">
							    <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Fitness Gallery Journeys {{$key+1}}</h5>
							        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          		<span aria-hidden="true">&times;</span>
							        	</button>

							    </div>
							    <div class="modal-body">
							      	@if($file_ext_one == 'pdf')
							      	<iframe src="{{ url($gallery->image) }}" width="100%" height="100%">
									</iframe>
							      	@elseif($file_ext_one == 'mp4')
							      	<video height="100%" autoplay="true" controls style="width: 100%;">
							      	<source src="{{ url($gallery->image) }}" type="video/mp4">
							      	</video>
							      	@else
							        <img src="{{ url($gallery->image) }}" style="width: 100%;">
							        @endif
							    </div>
						      	<div class="modal-footer">
						      		<div align="center">
						      		<p><b>LICHI WU</p></b>	
						      		</div>
						      		
						      		<P>I have been training with Ryan for over 2 years as of writing. Before I started training with Ryan, I had been lifting weights for over 14 years. As long as you are persistent and motivated, Ryan can tailor a program that will change how you look to get that physique you have always wanted.
						      		
                                    <p> The picture shown here was a cutting phase Ryan designed for me.</P>

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
	</section>


@endsection




