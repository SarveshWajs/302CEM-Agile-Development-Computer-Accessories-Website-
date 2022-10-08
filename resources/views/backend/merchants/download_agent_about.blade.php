<table class="table table-bordered">
	<thead>
		<tr class="info">
			<th>#</th>
			<th>Agent</th>
			<th>About</th>
		</tr>
	</thead>
	<tbody>
		@foreach($merchants as $key => $merchant)
		<tr>
			<td width="5%">
				{{ $key+1 }}
				<input type="hidden" class="row_id" value="{{ $merchant->id }}">
			</td>
			<td width="10%">{{ $merchant->f_name }} {{ $merchant->l_name }}<br>({{ $merchant->code }})</td>
			<td>{{ $merchant->about_us }}</td>
		</tr>
		@endforeach
	</tbody>
</table>