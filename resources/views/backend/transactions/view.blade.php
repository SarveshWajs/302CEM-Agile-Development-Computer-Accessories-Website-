@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Transaction details
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            {{ $transaction->transaction_no }}
        </small>
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif

<!-- <div class="form-group">
    <a href="#" class="btn btn-warning">
        <i class="fa fa-print"></i> 打印
    </a>
</div> -->

<div class="form-group container-box">
    <div class="row">
        <div class="col-xs-6">
            <b>Transaction No: #{{ $transaction->transaction_no }}</b><br>
            Dates: {{ $transaction->created_at }}<br><br>
            @if($transaction->mall == 1)
                Payment Method: <b>Wallet</b> <br>
            @else
                Payment Method: <b>{{ (!empty($transaction->bank_id)) ? 'Online Transfer' : 'Bank Transfer' }}</b> <br>            
            @endif
            
        </div>
        <div class="col-xs-6" align="right">
            <h3 class="total_amount">
                <b>Total</b> : <b style="color: green;">RM{{ number_format($transaction->grand_total, 2) }}
                </b>
            </h3>
        </div>
    </div>
</div>

<div class="form-group container-box">
    <div class="row">
        <div class="col-md-6">
            @if($transaction->customer_address == 1)
                <div class="form-group">
                    <h3>
                        <b>Recipient address (Customer)</b>
                    </h3>
                    <hr>
                    <div class="form-group">
                        <b>Name</b>: <br>
                        {{ $transaction->c_address_name }} <br><br>

                        <b>Address</b>: <br>
                        {{ $transaction->c_address }}, <br>
                        {{ $transaction->c_postcode }} {{ $transaction->c_city }}, <br>
                        {{ $transaction->c_state }}<br><br>
                        <b>Phone</b>: <br>
                        {{ $transaction->c_phone }}
                    </div>
                </div>
            @else
                <div class="form-group">
                    <h3>
                        <b>Recipient address</b>
                    </h3>
                    <hr>
                    <div class="form-group">
                        <b>Name</b>: <br>
                        {{ $transaction->address_name }} <br><br>

                        <b>Address</b>: <br>
                        {{ $transaction->address }}, <br>
                        {{ $transaction->postcode }} {{ $transaction->city }}, <br>
                        {{ $transaction->state }}<br><br>
                        <b>Phone</b>: <br>
                        {{ $transaction->phone }}
                    </div>
                </div>
            @endif
        </div>
        
    </div>
</div>

<div class="form-group container-box">
    @foreach($details as $detail)
    @php
    $image = (!empty($detail->product_image)) ? $detail->product_image : 'images/no-image-available-icon-6.jpg';
    @endphp
    <div class="form-group">
        <div class="row">
            <div class="col-sm-1" align="center">
                <div class="from-group">
                    <img src="{{ url($image) }}" style="width: 70px;">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group product-details">
                    <b>{{ $detail->product_name }}</b> &nbsp;&nbsp;&nbsp;
                    @if($transaction->status == 99)
                        <span class="badge badge-pill badge-warning">Unpaid</span>
                    @elseif($transaction->status == 97)
                        <span class="badge badge-pill label-info">Waiting Verification</span>
                    @elseif($transaction->status == 98)
                        <span class="badge badge-pill badge-info">Waiting Verification</span>
                    @elseif($transaction->status == 1)
                        @if(!empty($transaction->bank_id))
                            <span class="badge badge-pill badge-success">Paid</span>
                        @else
                            <span class="badge badge-pill badge-success">Paid</span>
                        @endif
                    @elseif($transaction->status == '96')
                        <span class="badge badge-danger">Rejected</span>
                    @else
                        <span class="badge badge-pill badge-danger">Cancelled</span>
                    @endif
                    <br>
                    {!! ($detail->sub_category != '') ? "Variation: ".$detail->sub_category."<br>" : '' !!}
                    {!! ($detail->second_sub_category != '') ? "R: ".$detail->second_sub_category."°<br>" : '' !!}
                    RM {{ number_format($detail->unit_price, 2) }}<br>
                    Qty: {{ $detail->quantity }}
                </div>
            </div>
        </div>
    </div>
    <hr>
    @endforeach
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            @php
                $ex = explode('.',$transaction->bank_slip);
                $end = end($ex);
            @endphp
            <div class="form-group container-box" 
                 style="{{ ($end == 'pdf') ? 'height: 500px' : 'height: 369px' }}; overflow: hidden;">
                <h3>
                    <b>
                        Bank slip
                    </b>
                </h3>
                <hr>
                @if(!empty($transaction->bank_slip))
                @if($end == 'pdf')
                    <iframe src="{{ url($transaction->bank_slip) }}" width="100%" style="height:100%"></iframe>
                @else
                    <a href="#" data-toggle="modal" data-target="#myModal">
                        <div style="background-image: url('{{ url($transaction->bank_slip) }}');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center;
                                    width: 150px;
                                    height: 150px;">
                        </div>
                    </a>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-body">
                            <img src="{{ url($transaction->bank_slip) }}" width="100%">
                          </div>
                        </div>
                      </div>
                    </div>
                @endif
                @else
                <h3 align="center" style="color: #b5b2b2;margin-top: 88px;">No bank slip</h3>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group container-box">
                <div class="form-group">
                    <h3>
                        <b>Summary</b>
                    </h3>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            Subtotal: 
                        </div>
                        <div class="col-xs-6" align="right">
                            @if(!empty($transaction->sub_total))
                                RM {{ number_format($transaction->sub_total, 2) }}
                            @else
                                RM {{ number_format(($transaction->grand_total) - $transaction->shipping_fee - $transaction->processing_fee + $transaction->discount, 2) }}
                            @endif
                        </div>
                    </div>
                </div>

               
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            Shipping fee: 
                        </div>
                        <div class="col-xs-6" align="right">
                            RM {{ number_format($transaction->shipping_fee, 2) }}
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            Processing fee(1.6%): 
                        </div>
                        <div class="col-xs-6" align="right">
                            RM {{ number_format($transaction->processing_fee, 2) }}
                        </div>
                    </div>
                </div>

                @if(!empty($transaction->ad_discount))
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            Agent Discount: 
                        </div>
                        <div class="col-xs-6" align="right">
                            (-) RM {{ number_format($transaction->ad_discount, 2) }}
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            @php
                            $afterDiscount = $transaction->sub_total - $transaction->discount;
                            @endphp
                            
                            @if($afterDiscount <= 0)
                            Discount(RM {{ $transaction->sub_total }}):
                            @else
                            Discount{{ (!empty($transaction->discount_code)) ? "(".$transaction->discount_code.")" : '' }}:
                            @endif
                        </div>
                        <div class="col-xs-6" align="right">
                            
                            @if($afterDiscount <= 0)
                            (-) RM {{ $transaction->sub_total }}
                            @else
                            (-) RM {{ number_format($transaction->discount, 2) }}
                            @endif
                        </div>
                    </div>
                </div>
                

                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3>
                                <b>Grand total</b>
                            </h3>
                        </div>
                        <div class="col-xs-6" align="right">
                            <h3 style="color: green;">
                                <b>RM {{ number_format($transaction->grand_total, 2) }}</b>
                            </h3>
                            
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
    </div>
</div>
<div class="submit-form-btn">
    <div class="form-group wizard-actions" align="right">
        <a href="{{ route('transaction.transactions.index') }}" class="btn btn-default">
            <i class="fa fa-angle-left"></i> Back To List
        </a>
        @if($transaction->status == '98')
        <a href="{{ route('transaction.transactions.index') }}" class="btn btn-success change_action" data-id="1">
            <i class="fa fa-check"></i> Approve
        </a>

        <a href="{{ route('transaction.transactions.index') }}" class="btn btn-danger change_action" data-id="96">
            <i class="fa fa-ban"> </i> Reject
        </a>
        @endif

        @if($transaction->status == '97')
        <a class="btn btn-success change_action" data-id="1">
            <i class="fa fa-check"></i> Complete
        </a>

        <a class="btn btn-danger change_action" data-id="95">
            <i class="fa fa-ban"> </i> Cancel
        </a>
        @endif

        @if($transaction->status == '1')
        <a href="{{ route('transaction_invoice', $transaction->transaction_no) }}"  class="btn btn-success" target="_blank">
            <i class="fa fa-print"> </i> Print Invoice
        </a>
        @endif
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $('.submit-form-btn .btn-primary').click( function(e){
        e.preventDefault();
        
        $('#sub-categories-form').submit();
    });
</script>

<script type="text/javascript">
    $('.change_action').click( function(e){
        e.preventDefault();
        var ele = $(this);
        var action_id = $(this).data('id');
        var tid = '{{ $transaction->id }}';
        var fd = new FormData();
        fd.append('action_id', action_id);
        fd.append('tid', tid);

        if(action_id == '1'){
            var confirmMessage = confirm('Complete This Transaction?');
        }else if(action_id == '95'){
            var confirmMessage = confirm('Cancel This Transaction? ');
        }else if(action_id == '96'){
            var confirmMessage = confirm('Reject This Transaction?');
        }

        if(confirmMessage == true){
            $.ajax({
               url: '{{ route("change_transaction_action") }}',
               type: 'post',
               data: fd,
               contentType: false,
               processData: false,
               success: function(response){
                
                    toastr.success('Update Successful');
                    window.location.href = "{{ route('transaction.transactions.index') }}";
                    // if(action_id == '1'){
                    //  ele.closest('tr').find('.status_id').html('<span class="badge badge-success">Approved</span>');
                    // }else if(action_id == '98'){
                    //  ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Rejected</span>');
                    // }else{
                    //  ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Cancelled</span>');
                    // }
               },
            });         
        }
    });
</script>
@endsection