@extends('layouts.app')

@section('content')
<section class="section my-5">
	<div class="container" align="center"> 
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="container-box">
					<img src="{{ url('images/ui-41-512.png') }}" width="20%">
					<br>
					<br>
					<h3>Success</h3>
					<br>
					<p style="color: #000">Thanks for getting started with weshare2you.com!</p>
					<p style="color: #000">You may login to your account</p>
					<a href="{{ route('login') }}" class="btn btn-primary">
						Login now
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection