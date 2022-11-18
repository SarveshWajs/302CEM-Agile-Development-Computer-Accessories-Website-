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
<div class="col-md-12">
<div>
<div class="row no-gutters justify-content-center">
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Arctic.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Armorig.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Asrock-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/bequiet.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Deepcool-New.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/der8aver-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
 <div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/ducky-02.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/evga.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/fnatic-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/fractal-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/fsp-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/glorious-new.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/hamman logo.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/hyte.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Iceberg.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
 <img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/id-cooling.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Jonsbo-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Keychron.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/klevv.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Machdesk.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/metallicgear-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/MSI WHITE LOGO.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/nitro-concepts.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/noblechair.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/nzxt-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/phanteks.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/pulsar.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/samsung.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/scythe.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/shurikey.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/ssupd.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/super-flower.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/taihao-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/tecgear brands logo1.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/tecware-01.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/tesoro.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/thermal-grizzly.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/TT.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/Vive.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/XFX-New.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/xpg.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/brand-logos/zotac-new.png">
</div>
</a>
</div>
<div class="col-md-3 col-xl-2">
<div class="d-flex flex-column align-items-center border m-2 p-2 shop-by-brand-tile" style="border-radius: 4px;">
<img src="https://econnect.sgp1.digitaloceanspaces.com/tenant_sc/Zowie.png">
</div>
</a>
</div>
</div>
</div>
</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection