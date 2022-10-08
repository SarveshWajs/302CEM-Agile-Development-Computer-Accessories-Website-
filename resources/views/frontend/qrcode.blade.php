@extends('layouts.app')
<script src="{{ asset('frontend/js/qrious.min.js') }}"></script>
@section('content')
<div class="profile-own-bg">
	<div class="personal-header-info">
			<div class="container">
				<div class="row">
					<div class="col-4" align="left">
						<a href="{{ route('profile') }}">
							<p style="color: white;"><i class="fa fa-chevron-left"></i> Back</p>
						</a>
					</div>
					<div class="col-4" align="left">
						<p align="center" class="header-title">My QRcode</p>
					</div>
					<div class="col-4" align="right">
						<a href="{{ route('my_setting') }}" class="setting-btn">
							<i class="fa fa-cog" style="font-size: 20px;"></i>
						</a>
					</div>
				</div>
			</div>
<div class="container">
			<div class="form-group">
				<div class="row">
					<div class="col-2">
						<a href="{{ route('profile') }}">
							@if(!empty(Auth::user()->profile_logo))
								<!-- <img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo"> -->
								<div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
							@else
								<img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
							@endif							
						</a>
					</div>
					<div class="col-6">
						<a href="{{ route('profile') }}">
							&nbsp;
							<b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
							<br>
						&nbsp;
						<small class="profile-code">Code: {{ Auth::user()->code }}</small>
							<br>
							<br>
							
							
							
						</a>
					</div>
					<!-- <div class="col-xs-4" align="right">
						<a href="#">
							<i class="fa fa-pencil"></i> Edit Profile
						</a>

					</div> -->
				</div>
			</div>
			
			@if(Auth::guard('web')->check())
				<!-- <div class="form-group container-box sl-personal-header">
					<div class="row">
						<div class="col-6" align="center">
							<a href="{{ route('myqrcode') }}">
								<img src="{{ url('images/qrcode.png') }}" width="30">
								<br>
								<span class="profile-word">My QRcode</span>
							</a>
						</div>

						<div class="col-4" align="center">
							<a href="{{ route('MyAffiliate', Auth::user()->code) }}">
								<img src="{{ url('images/profile/585e4d1ccb11b227491c339b.png') }}" width="30">
								<br>
								<span class="profile-word">My Team</span>
							</a>
						</div>

						<div class="col-6" align="center">
							<a href="{{ route('wallet') }}">
								<img src="{{ url('images/profile/c3286d4d32fa90ebcf09b488654612b9-wallet-icon-by-vexels.png') }}" width="30">
								<br>
								<span class="profile-word">My Wallet</span>
							</a>
						</div>
					</div>
				</div> -->
			@else
				<div class="form-group container-box sl-personal-header">
					<div class="row">
						<div class="col" align="center">
							<a href="{{ route('myqrcode') }}">
								<img src="{{ url('images/qrcode.png') }}" width="30">
								<br>
								<span class="profile-word">My QRcode</span>
							</a>
						</div>

					

						<div class="col" align="center">
							<a href="{{ route('wallet') }}">
								<img src="{{ url('images/profile/calories.png') }}" width="30">
								<br>
								<span class="profile-word">Calorie Calculator</span>
							</a>
						</div>

						
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
<br>
		<div class="container">
			<div class="form-group">
				<div class="row">
					<!-- <div class="col-xs-4" align="right">
						<a href="#">
							<i class="fa fa-pencil"></i> Edit Profile
						</a>

					</div> -->
				</div>
			</div>
			<div class="form-group container-box sl-personal-header" align="center">
			

			

				
				<div class="form-group">
					@if(Auth::guard('web')->check())
						<div class="row">
							<div class="col-md-12" align="center">
								<canvas id="qr-customer"></canvas>
								<br>
								<span>For customer registration</span>
								<br>
								<a class="btn btn-primary btn-sm" id="save" style="color: white;">
						        	<i class="fa fa-download"></i> Download Customer QRcode
						        </a>
							</div>
						</div>
						<br>
						<div class="form-group">
							<div class="row" style="display: flex; justify-content: center;">
								<div class="col-md-6" align="left">
									Link:
									<div class="button-inside">
					                    <input type="text" name="guest_link" id="guest_link" class="form-control" value="{{ route('register', ['p='.Auth::user()->code]) }}">
					                    <a href="#" class="btn btn-sm btn-primary copy-guest-link">
					                        Copy
					                    </a>
					                </div>
								</div>
							</div>
						</div>
					@else
						<div class="row">
							<div class="col-md-6">
							</div>
					
						</div>
						<div class="row">
							<div class="col-lg-12" align="center">
								<canvas id="qr-customer"></canvas>
								<br>
								<span>For customer registration</span>
								<br>
								<a class="btn btn-primary btn-sm" id="save" style="color: white;">
						        	<i class="fa fa-download"></i> Download Customer QRcode
						        </a>
						        <br>
						        <div class="form-group">
									Link:
									<div class="button-inside">
					                    <input type="text" name="guest_link" id="guest_link" class="form-control" value="{{ route('register', ['p='.Auth::user()->code]) }}">
					                    <a href="#" class="btn btn-sm btn-primary copy-guest-link">
					                        Copy
					                    </a>
					                </div>
								</div>
							</div>
							
				
							
						</div>
					@endif
				</div>

				

				<!-- <div class="form-group">
					<div class="row justify-content-center">
						<div class="col-md-6">
							For Guest:
							<div class="button-inside">
			                    <input type="text" name="guest_link" id="guest_link" class="form-control" value="{{ route('home', ['a='.Auth::user()->code]) }}">
			                    <a href="#" class="btn btn-sm btn-primary copy-agent-link">
			                        Copy
			                    </a>
			                </div>
						</div>
					</div>
				</div> -->

				<div class="form-group">
					<div class="row">
						<div class="col-md-6" align="center">
							
					    </div>
					    <div class="col-md-6" align="center">
					        
					    </div>
					</div>

			        <div id="previewImage" style="display: none;"></div>
			    </div>
			</div>
		</div>
	</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>
@endsection

@section('js')
<script type="text/javascript">
	$('.pay-now-button').click( function(){
		$('#traind').val($(this).data('id'));
	});

	$('.pay-button').click( function(e){
		e.preventDefault();
		
		if(!$("input[name='bank_id']:checked").val()){
	    	$('#error-message-banks').html('Please Select Bank To Continue Payment.');
	    	return false;
	    }
	    
	    var fd = new FormData();
		fd.append('transaction_id', $('#traind').val());
		$('.loading-gif').show();
		$.ajax({
	       url: '{{ route("Repayment") }}',
	       type: 'post',
	       data: fd,
	       contentType: false,
	       processData: false,
	       success: function(response){

	       		var url = "{{ route('PaymentProcess', [':id', ':bank_code']) }}";
					url = url.replace(':id', response);
					url = url.replace(':bank_code', $("input[name='bank_id']:checked").val());

				window.location.href = url;
	       	  
	       },
	    });

		
	});

	var element = $(".qrcode-div"); // global variable
    var getCanvas; // global variable

    // html2canvas(element, {
    //     onrendered: function (canvas) {
    //         $("#previewImage").append(canvas);
    //         getCanvas = canvas;
    //     }
    // });

	$('.download-qr').click( function(e){
		var imgageData = getCanvas.toDataURL("image/png");
        // Now browser starts downloading it instead of just showing it
        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
        $(".download-qr").attr("download", "MyQRcode.png").attr("href", newData);
	});
</script>


<script type="text/javascript">
	$('.copy-agent-link').click( function(e){
		e.preventDefault();
		
		var copyText = document.getElementById("agent_link");
		    copyText.select();
		    copyText.setSelectionRange(0, 99999)
		    document.execCommand("copy");

		$(this).html('copied');
	});

	$('.copy-guest-link').click( function(e){
		e.preventDefault();
		
		var copyText = document.getElementById("guest_link");
		    copyText.select();
		    copyText.setSelectionRange(0, 99999)
		    document.execCommand("copy");

		$(this).html('copied');
	});
</script>
@if(Auth::guard('web')->check())
<script type="text/javascript">
  var canvas2 = new QRious({
    element: document.getElementById('qr-customer'),
    value: "{{ route('register', 'p='.Auth::guard($data['userGuardRole'])->user()->code) }}",
    size: '250',
    background: 'white',
    foreground: 'black',
    level: 'L',
    padding: '38',
    foregroundAlpha: '2.8'
  })


  	var canvas2 = document.getElementById('qr-customer');
	var ctx = canvas2.getContext('2d');
	ctx.webkitImageSmoothingEnabled = false;
	ctx.mozImageSmoothingEnabled = false;
	ctx.imageSmoothingEnabled = false;
	ctx.retinaResolutionEnabled = false;
	// Set display size (css pixels).
	var size = 200;

	// // Set actual size in memory (scaled to account for extra pixel density).
	var scale = window.devicePixelRatio; // Change to 1 on retina screens to see blurry canvas2.
	canvas2.style.width = size + "px";
	canvas2.style.height = size + "px";

	// canvas2.width = size * scale;
	// canvas2.height = size * scale;

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

	var textString = "{{ Auth::guard($data['userGuardRole'])->user()->code }}";
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

  document.getElementById('save').addEventListener(
    'click',
    function() {
      var dataURL = canvas2.toDataURL({ pixelRatio: 300 });
      downloadURI(dataURL, 'MyQRcode.jpeg');
    },
    false
  );
</script>
@else

<script type="text/javascript">
  var pc = $('.topup_package').find(":selected").val();
  var link = "{{ route('merchant_register', ['p='.Auth::guard($data['userGuardRole'])->user()->code, 'pc=:pc']) }}";
	  link = link.replace(':pc', pc);

  var canvas = new QRious({
    element: document.getElementById('qr-agent'),
    value: link,
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

	var textString = "{{ Auth::guard($data['userGuardRole'])->user()->code }}";
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

  document.getElementById('save-two').addEventListener(
    'click',
    function() {
      var dataURL = canvas.toDataURL({ pixelRatio: 300 });
      downloadURI(dataURL, 'MyQRcode.jpeg');
    },
    false
  );

  var canvas2 = new QRious({
    element: document.getElementById('qr-customer'),
    value: "{{ route('register', 'p='.Auth::guard($data['userGuardRole'])->user()->code) }}",
    size: '250',
    background: 'white',
    foreground: 'black',
    level: 'L',
    padding: '38',
    foregroundAlpha: '2.8'
  })


  	var canvas2 = document.getElementById('qr-customer');
	var ctx = canvas2.getContext('2d');
	ctx.webkitImageSmoothingEnabled = false;
	ctx.mozImageSmoothingEnabled = false;
	ctx.imageSmoothingEnabled = false;
	ctx.retinaResolutionEnabled = false;
	// Set display size (css pixels).
	var size = 200;

	// // Set actual size in memory (scaled to account for extra pixel density).
	var scale = window.devicePixelRatio; // Change to 1 on retina screens to see blurry canvas2.
	canvas2.style.width = size + "px";
	canvas2.style.height = size + "px";

	// canvas2.width = size * scale;
	// canvas2.height = size * scale;

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

	var textString = "{{ Auth::guard($data['userGuardRole'])->user()->code }}";
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

  document.getElementById('save').addEventListener(
    'click',
    function() {
      var dataURL = canvas2.toDataURL({ pixelRatio: 300 });
      downloadURI(dataURL, 'MyQRcode.jpeg');
    },
    false
  );
</script>
@endif
<script type="text/javascript">
	$('.topup_package').change( function(){
		var ele = $(this);
		getPc();
	});

	function getPc()
	{
		var pc = $('.topup_package').find(":selected").val();
		var link = "{{ route('merchant_register', ['p='.Auth::guard($data['userGuardRole'])->user()->code, 'pc=:pc']) }}";
		link = link.replace(':pc', pc);

		$('#agent_link').val(link.replace('amp;', ''));

		  var canvas = new QRious({
		    element: document.getElementById('qr-agent'),
		    value: link.replace('amp;', ''),
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

			var textString = "{{ Auth::guard($data['userGuardRole'])->user()->code }}";
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
	}

	getPc();
</script>
@endsection