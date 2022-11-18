@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Customer Review List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<div class="row">
  <div class="col-sm-2">
    <div class="form-group">
      <input type="text" class="form-control" name="user_id" value="{{ !empty('user_id') && request('user_id') ? request('user_id') : '' }}" placeholder="Search User Id">
    </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group">
      <input type="text" class="form-control" name="product_id" value="{{ !empty('product_id') && request('product_id') ? request('product_id ') : '' }}" placeholder="Search Prouct Id">
    </div>
  </div>
  <div class="col-sm-2">
    
  </div>
</div>
<div class="form-group">
  <div class="row">
    <div class="col-sm-2">
      <div class="form-group">
        Row Per Page: <br>
        <select class="input-small" name="per_page">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="form-group">
  <button class="btn btn-primary btn-sm">
    <i class="fa fa-search"></i> Search
  </button>
  <a href="{{ route('member.members.index') }}" class="btn btn-warning btn-sm">
    <i class="fa fa-refresh"></i> Clear Search
  </a>
</div>
     <div class="row" style="overflow: auto;">
  <div class="col-xs-12">
    <table class="table table-bordered">
      <thead>
        <tr class="info">
           <th>#</th>
            <th>User Id </th>
            <th>Product Id </th>
            <th>Comment</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        
        @foreach($student as $row => $user) 
        <tr>
          <td>
             {{ $row+1 }}
            <input type="hidden" class="row_id" value="{{ $user->product_id }}">
          </td>
         <td>{{$user->user_id}}</td>
          <td>{{$user->product_id}}</td>
          <td>{{$user->comment}}</td>
          <td>{{$user->rating}}</td>
          <td>
            <a href="#" class="red change-status" data-id="3">
              <i class="ace-icon fa fa-trash-o bigger-130"></i> Delete
            </a>
          </td>
        </tr>
        @endforeach
       
      </tbody>
    </table>
   
  </div>
</div>

     


@endsection
@section('js')
<script type="text/javascript">
  $('.change-status').click(function(){
        $('.loading-gif').show();
        var ele = $(this);
        var row_id = ele.closest('tr').find('.row_id').val();

        var fd = new FormData();
        fd.append('row_id', row_id);
        fd.append('status', ele.data('id'));
        fd.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
           url: '{{ route("ReviewStatus") }}',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                $('.loading-gif').hide();
                toastr.success('Status Changed');
                window.location.href="{{ route('brand.brands.index') }}";
           },
        });
    });
</script>

@endsection