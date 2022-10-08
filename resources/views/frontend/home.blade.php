@extends('layouts.app')
<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
@section('content')

<div class="myBanner owl-carousel">
    @foreach($banners as $banner)
    <section class=" bg-cover bg-center d-flex align-items-center">
        <img src="{{ url($banner->image) }}" width="100%">
    </section>
    @endforeach
</div>
<div>

<div class="row">
    @foreach($setting_banner_video as $select)
        <video width="100%" controls>
            <source src="{{ url($select->video) }}" type="video/mp4">      
        </video>
    @endforeach
</div>

<div class="row">
    @foreach($setting_banner_testing as $key => $value)
    @php
        $col = ($key > 1) ? 'col-sm-12' : 'col-6';
    @endphp
        <div class="{{ $col }}" style="padding: 0px;">
            <img src="{{ url($value->image) }}" width="100%">
        </div>
    @endforeach
</div>


        

          
  </div>
</section>
@endsection

