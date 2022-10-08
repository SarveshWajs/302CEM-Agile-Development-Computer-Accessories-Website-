@extends('layouts.app')

@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                  Return & Refund Policy
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
                          Return & Refund Policy
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section class="blog spad my-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="single_post_text">
          {!! $data['web_setting']->return_policy_description !!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection