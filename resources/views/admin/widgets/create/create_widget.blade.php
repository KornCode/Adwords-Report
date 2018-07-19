@extends('admin.layout.backend')
{{-- ss --}}
@section('title')
Create a new Widget
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.widgets.create.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Widget Profile</h3>
				</div>
				<div class="box-body">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Name</label>
						<input type="text" name="widget_name" class="form-control" placeholder="laravel.com's widget" />
					</div>

					<div class="form-group{{ $errors->has('user_data') ? ' has-error' : '' }}">
						<label>User ID</label>
						<br>
						<select name="user_id" class="selectpicker" data-live-search="true" data-width="100%">
							<option disabled selected value> -- select an option -- </option>
							@foreach ($user_data as $user) 
								<option value={{ $user->id }}>{{ $user->id }} - {{ $user->email }}</option>
							@endforeach
						</select>
					</div>

					<!-- checkbox -->
					<div class="form-group">
						<label>Alignment</label>
						<br>
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-block btn-default btn-flat active">
							  	<input type="radio" name="alignment" value="desktop" autocomplete="off" checked> Desktop
							</label>
							<label class="btn btn-block btn-default btn-flat">
							  	<input type="radio" name="alignment" value="mobile" autocomplete="off"> Mobile
							</label>
						</div>
					</div>

					<div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
						<label for="domain" class="control-label">Domain</label>
						<input type="text" name="domain" class="form-control" placeholder="laravel.com" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-success">Create New Widget</button>
				</div>
			</div>
		</div>
	</form>
</div>
	
@endsection