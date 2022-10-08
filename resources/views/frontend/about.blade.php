@extends('layouts.app')
<style type="text/css">
  .align-items-center {
    align-items: center!important;
}
.flex-column {
    flex-direction: column!important;
}
.d-flex {
    display: flex!important;
}
.p-2 {
    padding: 0.5rem!important;
}
.m-2 {
    margin: 0.5rem!important;
}
.shop-by-brand-tile img {
    width: 120px;
    filter: grayscale(.9) invert(.9);
    transition: all .3s;
}
</style>
@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                  About Us
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
                          About Us
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section class="blog spad my-5">
  <div class="">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="single_post_text">
         <div class="row">
<div class="col-md-4 text-center mb-4">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/media/photos/vision.png" style="width: 80px; height: 80px;" class="mb-4">
<h3 class="mb-0 dark-mode__reactive-white">Our Vision</h3>
<p class="dark-mode__reactive-white">To be one of the most innovative gaming components distributor in Malaysia.</p>
</div>
<div class="col-md-4 text-center mb-4">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/media/photos/mission.png" style="width: 80px; height: 80px;" class="mb-4">
<h3 class="mb-0 dark-mode__reactive-white">Our Mission</h3>
<p class="dark-mode__reactive-white">The one-stop solution in gaming technology by bringing in the newest technology, products, and services to all gamers in Malaysia.</p>
</div>
<div class="col-md-4 text-center mb-4">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/media/photos/core-value.png" style="width: 80px; height: 80px;" class="mb-4">
<h3 class="mb-0 dark-mode__reactive-white">Core Values</h3>
<p class="dark-mode__reactive-white">We strive for excellence in bringing in the newest technology, products and service to our customers, staff and business partners.</p>
</div>
</div>
<hr class="mb-5 mt-1">
<div class="col-md-12">
<h3 class="section-header dark-mode__reactive-white">Our Brands</h3>
</div>

</section>
@endsection
