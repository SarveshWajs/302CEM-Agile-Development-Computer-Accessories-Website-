@extends('layouts.app')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Join Us</h1>
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
                            Join Us
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
					{!! $data['web_setting']->join_us_description !!}
				</div>
			</div>
		</div>
		<div class="form-group" align="center">
			<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#exampleModal">
				Become an agent
			</button>
		</div>
	</div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upgrade to an agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('upgrade_agent_form') }}" id="topup-form" enctype="multipart/form-data">
            @csrf
                <div class="modal-body" align="left">
                        <div class="form-group">
                            <select class="form-control select-packages" name="selected_packages">
                                <option value="">Select Topup Packages</option>
                                @foreach($data['aff_topups'] as $aff_topup)
                                @php
                                    $profit_bonus = 0;
                                    if(!empty($aff_topup->profit_amount)){
                                        if($aff_topup->profit_type == 'Percentage'){
                                            $profit_bonus = $aff_topup->topup_amount * $aff_topup->profit_amount / 100;
                                        }else{
                                            $profit_bonus = $aff_topup->profit_amount;
                                        }
                                    }
                                @endphp
                                <option value="{{ $aff_topup->id }}">
                                    RM {{ number_format($aff_topup->topup_amount, 2) }} 
                                    @if($profit_bonus > 0)
                                    + (RM {{ number_format($profit_bonus, 2) }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="form-group payment-area">
                            <h4>Top-up: RM 
                                <span class="topup_amount_display">
                                    
                                </span>
                                <input type="hidden" class="topup_amount" name='topup_amount'>
                            </h4>
                            <div class="widget-box transparent" id="recent-box">
                                <div class="widget-header">
                                  <h4 class="widget-title lighter smaller">
                                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Select a payment
                                  </h4>

                                  <div class="widget-toolbar no-border">
                                    <ul class="nav nav-tabs" id="recent-tab">
                                      <li class="parent_payment_method active">
                                        <a data-toggle="tab" class="payment_method f-15" data-id="1" href="#online-tab">Online Transfer</a>
                                      </li>

                                      <li class="parent_payment_method">
                                        <a data-toggle="tab" class="payment_method f-15" data-id="2" href="#cdm-tab">Bank Transfer</a>
                                      </li>
                                    </ul>
                                  </div>
                                  <input type="hidden" name="selected_payment_method" class="selected_payment_method" value="1">
                                </div>

                                <div class="widget-body">
                                  <div class="widget-main padding-4">
                                    <div class="tab-content padding-8">
                                      <div id="online-tab" class="tab-pane active">
                                        <div class="form-group">
                                          <h4>Select Banks </h4>
                                        </div>
                                        <div class="form-group">
                                          <div class="row">
                                            
                                            <div class="col-4" align="center">
                                              <label>
                                                <input type="radio" name="bank_id" value="1">
                                                <img src="{{ url('images/banks/maybank.jpg') }}">
                                              </label>
                                            </div>
                                            <div class="col-4" align="center">
                                              <label>
                                                <input type="radio" name="bank_id" value="2">
                                                <img src="{{ url('images/banks/cimb.jpg') }}">
                                              </label>
                                            </div>
                                            <div class="col-4" align="center">
                                              <label>
                                                <input type="radio" name="bank_id" value="4">
                                                <img src="{{ url('images/banks/rhb.jpg') }}">
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                          <div class="row">
                                            <div class="col-4" align="center">
                                              <label>
                                                <input type="radio" name="bank_id" value="5">
                                                <img src="{{ url('images/banks/hongleong.jpg') }}">
                                              </label>
                                            </div>
                                            <div class="col-4" align="center">
                                              <label>
                                                <input type="radio" name="bank_id" value="3">
                                                <img src="{{ url('images/banks/pbe.jpg') }}">
                                              </label>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <b id="error-message-banks" class="important-text"></b>
                                        </div>
                                      </div>

                                      <div id="cdm-tab" class="tab-pane" align="center">
                                        <div class="form-group">
                                          <input type="hidden" name="cdm_bank_id" value="10000743">
                                          <div class="card border-danger mb-3" style="max-width: 18rem;" align="center">
                                            <div class="card-body text-danger">
                                                <h5 class="card-title">Bank Holder</h5>
                                                <h5 class="card-title">Bank Name</h5>
                                                <p class="card-text">Bank Account</p>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group bank_details">

                                        </div>
                                        <div class="form-group">
                                          <input type="file" name="bank_slip" class="form-control upgrade_bank_slip" accept="image/*">
                                        </div>
                                      </div><!-- /.#member-tab -->
                                    </div>
                                  </div><!-- /.widget-main -->
                                </div><!-- /.widget-body -->
                              </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary upgrade-now-btn">Upgrade Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.payment_method').click(function(e){
        var ele = $(this);
        var id = ele.data('id');
        $('.parent_payment_method').removeClass('active');
        ele.parent().addClass('active');

        $('.selected_payment_method').val(id);
        $('.tab-pane').removeClass('active');
        if(id == 1){
        	$('#online-tab').addClass('active');
        }else{
        	$('#cdm-tab').addClass('active');
        }
    });

    $('.upgrade-now-btn').click( function(e){
        e.preventDefault();

        var ele = $(this);

        var sp = $('.select-packages').val();

        var pm = $('.selected_payment_method').val();

        var bs = $('.upgrade_bank_slip').val();

        if(pm == 2){
            if(!bs){
                toastr.error('Please upload bank slip to continue');
                return false;
            }
        }else{
            if(!$("input[name='bank_id']:checked").val()){
                toastr.error('Please Select Bank To Continue Payment.');
                $('.loading-gif').hide();
                return false;
            }
        }

        $('#topup-form').submit();
    });
</script>
@endsection