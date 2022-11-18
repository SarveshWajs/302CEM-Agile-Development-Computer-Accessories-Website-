@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Setting Banner Video
    </h1>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group product-image-list">
                <div class="row">
                    
                </div>
                <div class="clear-both"></div>
            </div>
            <!-- <div class="form-group">
                <form method="POST" action="" class="asdasd" id="upload_image_form" enctype="multipart/form-data">
                    <input type="file" name="upload_image" id="upload_image" class="form-control" />
                    <br />
                    <div id="uploaded_image"></div>
                </form>
            </div> -->
            
                
                   
                    <form method="POST" action="{{ route('uploadBannerVideo') }}"  id="setting-merchant-form" enctype="multipart/form-data">
                    @csrf
                   <input type="file" id="myFile" name="filename" class="form-control">
                   <br/>
                    @if(!empty($select->id))
                        <video width="320" height="240" controls>
                          <source src="{{ url($select->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                        </video>
                    @endif
                </form>
<div class="submit-form-btn">
    <div class="form-group wizard-actions" align="right">
        <button class="btn btn-primary">
            <i class="fa fa-check"> Save Changes</i>
        </button>

    </div>
</div>
       
@endsection

@section('js')
<script type="text/javascript">
    $('.submit-form-btn .btn-primary').click( function(e){
        e.preventDefault();
        $('.loading-gif').show();
        $('#setting-merchant-form').submit();
    });
</script>
@endsection