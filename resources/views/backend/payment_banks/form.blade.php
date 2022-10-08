<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-4">
					Bank Name: <span class="important-text">*</span>
				</div>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="bank_name" value="{{ isset($payment_bank) ? $payment_bank->bank_name : old('bank_name') }}" placeholder="Bank Name *">
				</div>
			</div>
		</div>
	</div>
</div>