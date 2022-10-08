<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Full Name <span class="important-text">*</span></label>
						<input type="text" class="form-control required-field" name="f_name" placeholder="First Name *" value="{{ isset($merchant) ? $merchant->f_name : old('f_name') }}">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>E-Shop Name <span class="important-text">*</span></label>
						<input type="text" class="form-control required-field" name="e_shop_name" placeholder="E-Shop Name" value="{{ isset($merchant) ? $merchant->e_shop_name : old('e_shop_name') }}">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>IC No. <span class="important-text">*</span></label>
						<input type="text" class="form-control required-field" name="ic" placeholder="IC No." value="{{ isset($merchant) ? $merchant->ic : old('ic') }}" onkeypress="return isNumberKey(event)">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Address <span class="important-text">*</span></label>
						<textarea class="form-control required-field" name="address" placeholder="Address">{{ isset($merchant) ? $merchant->address : old('address') }}</textarea>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Email <span class="important-text">*</span></label>
						<input type="email" class="form-control required-field" name="email" placeholder="Email" value="{{ isset($merchant) ? $merchant->email : old('email') }}"
							   {{ isset($merchant) ? 'readonly' : '' }} >
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Password <span class="important-text">*</span></label>
						@if(isset($merchant))
						<br>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
							<i class="fa fa-key"></i> Change New Password
						</button>
						@else
						<input type="password" class="form-control required-field" name="password" placeholder="Password (min 6 character)" value="{{ isset($merchant) ? $merchant->password : old('password') }}">
						@endif
					</div>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-6">
						<label>Phone</label>
						<div class="row">
							<div class="col-xs-6">
			                    <select class="form-control select2" name="country_code" id="country_code" data-live-search="true">
			                        <option value="60">(+60) Malaysia</option>
			                        <option value="65">(+65) Singapore</option>
			                    </select>
			                </div>
			                <div class="col-xs-6">
			                    <input type="text" class="form-control required-feild" placeholder="Phone" name="phone"  value="{{ isset($merchant) ? $merchant->phone : old('phone') }}">
			                </div>
						</div>
					</div>
					@if(!isset($merchant))
					<div class="col-xs-6">
						<div class="form-group">
							<label>Refferal Code (Agent Code e.g. "M000001")</label>
							<input type="text" name="agent_pno" class="form-control" placeholder="Refferal Code (Agent Code)" value="{{ isset($merchant) ? $merchant->master_code : old('agent_pno') }}">
							<span class="important-text">
								If this agent is attribute to ADMIN, leave it blank
							</span>
						</div>
					</div>
					@endif
				</div>
			</div>
			<hr>
			@if(!isset($merchant))
				<div class="row">
					<div class="col-md-6">
						<label>Topup</label>
						<select class="form-control" name="packages_list">
							<option value="">Select Topup Packages</option>
							@foreach($aff_topups as $aff_topup)
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
				</div>
				<hr>
			@endif
			@if(Auth::guard('admin')->check())
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Set Agent Level</label>
						@php
							$selectedValue = (isset($merchant)) ? $merchant->lvl : old('lvl');
						@endphp
						<select class="form-control" name="lvl">
							<option value="">Basic Level</option>
							@foreach($levels as $level)
							<option {{ ($selectedValue == $level->id) ? 'selected' : ''}} value="{{ $level->id }}">{{ $level->agent_lvl }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Set Agent Permission Level</label>
						@php
							$selectedPMValue = (isset($merchant)) ? $merchant->permission_lvl : old('permission_lvl');
						@endphp
						<select class="form-control" name="permission_lvl">
							<option value="">Select Permission Level</option>
							<option {{ ($selectedPMValue == '1') ? 'selected' : ''}} value="1">Super Admin</option>
							<option {{ ($selectedPMValue == '2') ? 'selected' : ''}} value="2">Admin</option>
							<option {{ ($selectedPMValue == '3') ? 'selected' : ''}} value="3">User 1</option>
							<option {{ ($selectedPMValue == '4') ? 'selected' : ''}} value="4">User 2</option>
							<option {{ ($selectedPMValue == '5') ? 'selected' : ''}} value="5">User 3</option>
						</select>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

