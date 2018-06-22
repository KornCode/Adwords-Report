@extends('admin.layout.backend')

@section('content')

<div class="row">
	<div class="col-sm-4">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">App Information</h3><i class="fa fa-info-circle" style="float: right;"></i>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>Variables</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Enviroment</td>
							<td>{{ env('APP_ENV', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Debug Mode</td>
							<td>{{ env('APP_DEBUG', 'No variable') ? 'On' : 'Off' }}</td>
						</tr>
						<tr>
							<td>PHP Version</td>
							<td>{{ phpversion() }}</td>
						</tr>
						<tr>
							<td>Laravel Version</td>
							<td>{{ App::VERSION() }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
	</div>

	<div class="col-sm-4">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Database Information</h3><i class="fa fa-database" style="float: right;"></i>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>Variables</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Connection</td>
							<td>{{ env('DB_CONNECTION', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Host</td>
							<td>{{ env('DB_HOST', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Port</td>
							<td>{{ env('DB_PORT', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>{{ env('DB_DATABASE', 'No variable') }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
	</div>

	<div class="col-sm-4">
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Mail Information</h3><i class="fa fa-envelope" style="float: right;"></i>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>Variables</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Driver</td>
							<td>{{ env('MAIL_DRIVER', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Host</td>
							<td>{{ env('MAIL_HOST', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Port</td>
							<td>{{ env('MAIL_PORT', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Encryption</td>
							<td>{{ env('MAIL_ENCRYPTION', 'No variable') }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Member Information</h3><i class="fa fa-users" style="float: right;"></i>
			</div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
							<th>Variables</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total Members</td>
							<td>{{ $member_count }}</td>
						</tr>
						<tr>
							<td>Registered Adwords Keys</td>
							<td>{{ $member_with_adwordsKey }}</td>
						</tr>
						<tr>
							<td>Registered Social Keys</td>
							<td>{{ $member_with_socialKey }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection