@extends('layouts.app')
<style type="text/css">
    .col-xs-6 {
         width: 50%;
         color:#337ab7;
      
     }

    .progress.progress-mini {
        height: 6px;
    }
    .bs-callout {
        padding: 10px 20px;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
    }

    .bs-callout-info {
        border-left-color: #1b809e;
    }
    .progress {
    box-shadow: none;
    background: #e9e9e9;
    height: 18px;
}

</style>
@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">
                	<i class="fa fa-users" aria-hidden="true"></i>Tab view
                </h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                        	<a href="{{ route('MyGroupSales') }}">
                        		<img src="{{ url('images/profile/d5421e115be8ce021842d8a350bceed1-organisational-structure-icon-by-vexels.png') }}" width="25">
                        	</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                         <i class="fa fa-users" aria-hidden="true"></i>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="widget-main padding-4">
      <div  class="tab-content padding-8">
            <div class="col-md-4">
              <div class="form-group">
                  <div class="bs-callout bs-callout-info" id="callout-alerts-dismiss-plugin">
                      <div style="color:#0000A0"class="form-group">
                        1st generation downline
                      </div>
                      <div class="row">
                        <div class="col-xs-6">
                          <div class="form-group">
                            &nbsp;&nbsp;&nbsp;Quantity
                          </div>
                        </div>
                        <div class="col-xs-6" align="right">
                          <div class="form-group">
                            {{ $fg }}
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12" align="right">
                          <div class="progress progress-mini">
                          <div class="progress-bar progress-danger" style="width:{{ $fgp }}%;"></div>
                        </div>
                        </div>

                      <div class="col-xs-6">
                        <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Percentage</small>
                      </div>
                      <div class="col-xs-6" align="right">
                        <small>{{ $fgp }}%</small>
                      </div>
                      </div>
                  </div>                  
              </div>  
            </div>
</section>

@endsection
