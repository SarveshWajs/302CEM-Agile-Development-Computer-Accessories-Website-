@extends('layouts.app')
<script src="{{ asset('frontend/js/qrious.min.js') }}"></script>
@section('content')
<div class="" style="height: 370px;">
  <div class="" style="background-image: url({{ (!empty($userProfile->bg_image)) ? url($userProfile->bg_image) : url('images/profile-background.png') }});
                       background-repeat: no-repeat;
                       background-position: center;
                       background-size: cover;
                       width: 100%;
                       height: 280px;
                       position: relative;">
      <div class="" style="position: absolute;
                           width: 150px;
                           height: 150px;
                           border-radius: 100%;
                           border: 1px solid #eee;
                           top: 280px;
                           left: 50%;
                           transform: translate(-50%, -50%);
                           background-image: url('{{ (!empty($userProfile->profile_logo)) ? url($userProfile->profile_logo) : url('images/images.png') }}');
                           background-size: cover;
                           background-position: center;
                           background-repeat: no-repeat;">
      </div>
  </div>
</div>
<div class="container">
  <div class="form-group" align="center">
    <h3> {{ $userProfile->f_name }} {{ $userProfile->l_name }} ({{ $userProfile->e_shop_name }})</h3>
  </div>

  
  <div class="form-group" align="center">
    <canvas id="qr-agent"></canvas>
  </div>

  <div class="form-group" align="center">
    <div class="row">
      <div class="col-3" align="center">
        <a href="mailto:{{ $userProfile->contact_email }}">
          <img src="{{ url('images/88e50689fa3280c748d000aaf0bad480-email-round-icon-1-by-vexels.png') }}" width="60px">          
        </a>
      </div>

      <div class="col-3" align="center">
        <a href="#" class="share-link" style="display: block;">
          <input type="text" name="link" id="myInput" class="form-control" value="{{ route('name_card', [$userProfile->f_name.' '.$userProfile->l_name, $userProfile->code]) }}" 
          style="height: 0; position: absolute; z-index: -1; padding: 0; border: none;">
          <img src="{{ url('images/share-512.png') }}" width="60px">          
        </a>
      </div>

      @if($userProfile->phone[0] != 0)
        <div class="col-3" align="center">
          <a href="https://api.whatsapp.com/send?phone=60{{ $userProfile->phone }}&source=&data=" target="_blank">
            <img src="{{ url('images/social-whatsapp-circle-512.png') }}" width="60px">
          </a>
        </div>
      @else
        <div class="col-3" align="center">
          <a href="https://api.whatsapp.com/send?phone=6{{ $userProfile->phone }}&source=&data=" target="_blank">
            <img src="{{ url('images/social-whatsapp-circle-512.png') }}" width="60px">
          </a>
        </div>
      @endif
      <div class="col-3" align="center">
          <a href="{{ route('register', 'p='.$userProfile->code) }}" target="_blank">
            <img src="{{ url('images/register-icon.png') }}" width="60px">
          </a>
        </div>
    </div>
  </div>

  <div class="form-group container-box" >
    <div class="form-group">
        <i class="fa fa-user" style="width: 20px;"></i> Level: {{ $level }}
    </div>
    <div class="form-group">
        <i class="fa fa-envelope" style="width: 20px;"></i> Email: {{ $userProfile->email }}
    </div>
    @if($userProfile->phone[0] != 0)
      <div class="form-group">
          <i class="fa fa-phone" style="width: 20px;"></i> Phone: 0{{ $userProfile->phone }}
      </div>
    @else
      <div class="form-group">
          <i class="fa fa-phone" style="width: 20px;"></i> Phone: {{ $userProfile->phone }}
      </div>
    @endif
    @if(!empty($userProfile->e_shop_name))
    <div class="form-group">
        <i class="fa fa-shopping-bag" style="width: 20px;"></i> E-Shop Name: {{ $userProfile->e_shop_name }}
    </div>
    @endif
    @if(!empty($userProfile->gender))
    <div class="form-group">
        <i class="fa fa-venus-mars" style="width: 20px;"></i> Gender {{ $userProfile->gender }}
    </div>
    @endif

    @if(!empty($userProfile->dob))
    <div class="form-group">
        <i class="fa fa-birthday-cake" style="width: 20px;"></i> Date of birth {{ $userProfile->dob }}
    </div>
    @endif
  </div>
</div>

<div class="container">
  <div class="ps-contact ps-section pb-40 pt-40">
    <div class="ps-container">
      <div class="row">
          <h2 class="ps-section__title" data-mask="About">- About Us</h2>
      </div>
    <!-- Breadcrumb Section End -->
        <div class="form-group">
          {!! $userProfile->about_us !!}
        </div>
    </div>
  </div>
</div>  

@endsection


@section('js')
<script type="text/javascript">
$('.share-link').click(function(e){
    // alert(123);
    e.preventDefault();
    myFunction();
    toastr.success('Link Copied');
  });
</script>
<script type="text/javascript">
  var canvas = new QRious({
    element: document.getElementById('qr-agent'),
    value: "{{ route('register', 'p='.$userProfile->code) }}",
    size: '250',
    background: 'white',
    foreground: 'black',
    level: 'L',
    padding: '38',
    foregroundAlpha: '2.8'
  })

  var canvas = document.getElementById('qr-agent');
  var ctx = canvas.getContext('2d');
  ctx.webkitImageSmoothingEnabled = false;
  ctx.mozImageSmoothingEnabled = false;
  ctx.imageSmoothingEnabled = false;
  ctx.retinaResolutionEnabled = false;
  // Set display size (css pixels).
  var size = 200;

  // // Set actual size in memory (scaled to account for extra pixel density).
  var scale = window.devicePixelRatio; // Change to 1 on retina screens to see blurry canvas.
  canvas.style.width = size + "px";
  canvas.style.height = size + "px";

  // canvas.width = size * scale;
  // canvas.height = size * scale;

  // // Normalize coordinate system to use css pixels.
  // ctx.scale(10, scale);

  ctx.fillStyle = "#000000";
  ctx.fillRect(37, 217, 175, 30);
  ctx.fillStyle = "#FFFFFF";
  
  ctx.font = '18pt Signika Negative';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';

  var x = size / 1.6;
  var y = size / 0.855;

  var textString = "{{ $userProfile->code }}";
  ctx.fillText(textString, x, y);

  function downloadURI(uri, name) {
    var link = document.createElement('a');
    link.download = name;
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
  }

  function myFunction() {
    var copyText = document.getElementById("myInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
  }


</script>
@endsection