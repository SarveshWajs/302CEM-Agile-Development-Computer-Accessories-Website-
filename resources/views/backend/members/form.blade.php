<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Full Name <span class="important-text">*</span></label>
						<input type="text" class="form-control required-field" name="f_name" placeholder="First Name *" value="{{ isset($user) ? $user->f_name : old('f_name') }}">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Email <span class="important-text">*</span></label>
						<input type="email" class="form-control required-field" name="email" placeholder="Email" value="{{ isset($user) ? $user->email : old('email') }}"
							   {{ isset($user) ? 'readonly' : '' }}>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Password <span class="important-text">*</span></label>
						@if(isset($user))
						<br>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
							<i class="fa fa-key"></i> Change New Password
						</button>
						@else
						<input type="password" class="form-control required-field" name="password" placeholder="Password (min 6 character)" value="{{ isset($user) ? $user->password : old('password') }}">
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
			                    <input type="text" class="form-control required-feild" placeholder="Phone" name="phone"  value="{{ isset($user) ? $user->phone : old('phone') }}">
			                </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Refferal Code (Agent Code e.g. "M000001")</label>
							<input type="text" name="master_id" class="form-control" placeholder="Refferal Code (Agent Code)" value="{{ isset($user) ? $user->master_id : old('master_id') }}">
							<span class="important-text">
								If this agent is attribute to ADMIN, leave it blank
							</span>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
</div>

