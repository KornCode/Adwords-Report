@extends('admin.layout.backend')

@section('content')

<div class="row">
	<div class="col-sm-4">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">App Information</h3>
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
						<tr>
							<td>Database Connection</td>
							<td>{{ env('DB_CONNECTION', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Database Name</td>
							<td>{{ env('DB_DATABASE', 'No variable') }}</td>
						</tr>
						<tr>
							<td>Mail Host</td>
							<td>{{ env('MAIL_HOST', 'No variable') }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
</div>

@endsection

{{-- Status --}}
{{-- <td><span class="label label-primary">Approved</span></td> --}}