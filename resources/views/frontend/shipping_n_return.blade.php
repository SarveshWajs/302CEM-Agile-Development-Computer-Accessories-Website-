@extends('layouts.app')

@section('content')
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Term & Condition</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Term & Condition</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section class="blog spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="single_post_text">
          {!! $data['web_setting']->shipping_policy_description !!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection