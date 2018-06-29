@extends('admin.layout.backend')

@section('title')
Create a new Permission
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<div class="col-sm-4">
		<form action="{{ route('admin.permissions.create.post') }}" method="POST" role="form">
			{{ csrf_field() }}
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Create a new Permission</h3>
				</div>
				<div class="box-body">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Permission name" value="{{ old('name') }}" />
					</div>
					<div class="form-group{{ $errors->has('guard_name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Guard Name</label>
						<input type="text" name="guard_name" class="form-control" placeholder="Guard name" value="{{ old('guard_name') }}" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-warning btn-block">Submit</button>
				</div>
			</div>
		</form>	
	</div>
</div>
@endsection