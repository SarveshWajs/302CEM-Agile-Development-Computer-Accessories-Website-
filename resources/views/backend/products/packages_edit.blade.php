@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Packages Details
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            
        </small> -->
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
@include('backend.products.packages_form')

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('product.products.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> Cancel</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> Save Changes</i>
		</button>

	</div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    var url = '{{ route("LoadImage", ":id") }}';
    url = url.replace(':id', '{{ $product->id }}');
    
    $.ajax({
        url: url,
        type: 'get',
        success: function(response){
            $('.product-image-list .row').html(response);
            
        },
    });

    jQuery(function($){
            
        try {
            
            var myDropzone = Dropzone.options.dropzone =
            {

                maxFilesize: 120000,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                   return time+file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 5000,
                dictRemoveFile: 'Remove',
                maxFiles: 100,
                
                dictDefaultMessage :
                '<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> {{ isset($data["Blang"]["Blang"]["dnd_files"]) ? $data["Blang"]["Blang"]["dnd_files"] : "拖放文件" }} </span> {{ isset($data["Blang"]["Blang"]["uploads"]) ? $data["Blang"]["Blang"]["uploads"] : "上传" }} \
                <span class="smaller-80 grey">{{ isset($data["Blang"]["Blang"]["or_click"]) ? $data["Blang"]["Blang"]["or_click"] : "(或 点击)" }}</span> <br /> \
                <i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',
                
                thumbnail: function(file, dataUrl) {
                  if (file.previewElement) {
                    $(file.previewElement).removeClass("dz-file-preview");
                    var images = $(file.previewElement).find("[data-dz-thumbnail]").each(function() {
                        var thumbnailElement = this;
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    });
                    setTimeout(function() { $(file.previewElement).addClass("dz-image-preview"); }, 1);

                  }
                },
                success: function(file, response) 
                {
                    $('.product-image-list .row').html(response);
                },
            };
        
          //simulating upload progress
          var minSteps = 6,
              maxSteps = 60,
              timeBetweenSteps = 100,
              bytesPerStep = 100000;
        
          
        
           
           //remove dropzone instance when leaving this page in ajax mode
           $(document).one('ajaxloadstart.page', function(e) {
                try 
                {
                    myDropzone.destroy();
                } catch(e) {}
           });
        
        } catch(e) {
          alert('Dropzone.js does not support older browsers!');
        }
        
    });

    $('.product-image-list').on('click', '.product-image-thumbnail .delete-image', function(e){
        e.preventDefault();
        var delete_btn = $(this);
        if(confirm('Delete This Image?') == true){
            var url = '{{ route("DeleteImage", ":id") }}';
            url = url.replace(':id', $(this).data('id'));
            $.ajax({
                url: url,
                type: 'get',
                success: function(response){
                    delete_btn.closest('.product-image-thumbnail').hide();
                },
            });
        }else{
            return false;
        }
    });

    $('.submit-form-btn .btn-primary').click( function(e){
        e.preventDefault();
        var g;
            
        
        $( ".products" ).each(function() {
            if($(this).val()){
                g = 1;
            }
        }); 

        if(g == 1){
            $('#product-form').submit();    
        }else{
            alert("At least 1 item");
        }
        return false;
        
    });

    var descriptionUrl = '{{ route("CKEditorUploadImage", ["_token" => csrf_token(), "p_id"=> ":p_id", "type" => "1" ]) }}';

    var description = CKEDITOR.instances["description"];
    descriptionUrl = descriptionUrl.replace(':p_id', '{{ $product->id }}');

    if(!description){
        CKEDITOR.replace( 'description',{
          filebrowserUploadUrl: descriptionUrl,
          filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace( 'free_gift_description',{
          filebrowserUploadUrl: descriptionUrl,
          filebrowserUploadMethod: 'form'
        });
    }
    // CKEDITOR.replace( 'free_gift');

    var item = '<div class="form-group">\
                        <input type="hidden" name="pid[]" value="">\
                        <div class="row">\
                            <div class="col-md-2">\
                                <select class="form-control products" name="products[]">\
                                    <option value="">{{ isset($data["Blang"]["Blang"]["Choose Product"]) ? $data["Blang"]["Blang"]["Choose Product"] : "选择产品" }}</option>\
                                    @foreach($products as $product_s)\
                                    @if($product_s->packages != 1)\
                                    <option value="{{ $product_s->id }}">{{ $product_s->product_name }}</option>\
                                    @endif\
                                    @endforeach\
                                </select>\
                            </div>\
                            <div class="col-md-2">\
                                <input type="input" name="qty[]" class="form-control" placeholder="{{ isset($data["Blang"]["Blang"]["Quantity"]) ? $data["Blang"]["Blang"]["Quantity"] : "数量" }}" onkeypress="return isNumberKey(event)">\
                            </div>\
                            <div class="col-md-2">\
                                <input type="input" name="unit_price[]" class="form-control" placeholder="{{ isset($data["Blang"]["Blang"]["Total Cost"]) ? $data["Blang"]["Blang"]["Total Cost"] : "总价格" }}" onkeypress="return isNumberKey(event)">\
                            </div>\
                            <div class="col-md-2">\
                                <a href="#" class="important-text delete_btn">\
                                    <i class="fa fa-trash fa-2x"></i>\
                                </a>\
                            </div>\
                        </div>\
                    </div>';

    $('.add-shipping-btn').click(function(e){
        e.preventDefault();

        $('.parent-box').append(item);
    });

    $('.parent-box').on('change', '.products', function(){
        $('.loading-gif').show();
        var ele = $(this);
        var fd = new FormData();
            fd.append('product_id', ele.val());

        $.ajax({
            url: '{{ route("getProducts") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                $('.loading-gif').hide();
                ele.closest('.form-group').find('input[name="unit_price[]"]').val(response);
            }
        });
    });

    $('.parent-box').on('click', '.delete_btn', function(e){
        e.preventDefault();
        $('.loading-gif').show();
        var ele = $(this);
        var row_id = ele.data('id');

        if(row_id){
            var fd = new FormData();
                fd.append('pid', row_id);

            $.ajax({
                url: '{{ route("deletePackageItem") }}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('.loading-gif').hide();
                    ele.closest('.row').remove();
                    toastr.error('Deleted');
                }
            });
        }else{
            ele.closest('.row').remove();
            $('.loading-gif').hide();            
        }
    });


    $('.event_date').daterangepicker({
        'applyClass' : 'btn-sm btn-success',
        'cancelClass' : 'btn-sm btn-default',
        locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
        }
    })
    .prev().on(ace.click_event, function(){
        $(this).next().focus();
    });

    $('input[name="event_time_available"]').click( function(){
        if($(this).is(":checked")){
            $('.event_area').show();
        }else{
            $('.event_area').hide();
        }
    });

    $(document).ready( function(){
        if($('input[name="event_time_available"]').is(":checked")){
            $('.event_area').show();
        }else{
            $('.event_area').hide();
        }
    });
</script>

@endsection