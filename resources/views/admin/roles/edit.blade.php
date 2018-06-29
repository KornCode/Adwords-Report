@extends('admin.layout.backend')

@section('title')
Edit Role #{{ $role->id }}
@endsection

@section('content')

@include('admin.components.errors_box')

<div class="row">
	<form action="{{ route('admin.roles.edit.post') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Editing Role #{{ $role->id }} - {{ $role->guard_name }} - {{ $role->name }}</h3>
				</div>
				<div class="box-body">
					<input type="hidden" name="role_id" value="{{ $role->id }}" />
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Role name" value="{{ $role->name }}" />
					</div>
					<div class="form-group{{ $errors->has('guard_name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Guard Name</label>
						<input type="text" name="guard_name" class="form-control" placeholder="Guard name" value="{{ $role->guard_name }}" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-info btn-block">Submit</button>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Permissions</h3>
				</div> 
				<div class="box-body">
					@foreach($permissions as $guard => $guard_permissions)
						<p><strong>Guard - {{ $guard }}</strong></p>
						<div class="form-group">
						@foreach($guard_permissions as $permission)
							<label class="checkbox-inline">
								<input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}" value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}> {{ $permission->name }}
							</label>
							<br />
						@endforeach
						</div>
					@endforeach
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-info btn-block">Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="row">
	<div class="col-sm-4">
		<form action="{{ route('admin.roles.delete.post') }}" method="POST" role="form">
			{{ csrf_field() }}
			<input type="hidden" name="role_id" value="{{ $role->id }}" />
			<div class="box collapsed-box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Delete Role</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="delete_input" class="control-label">Type in role name</label>
						<input type="text" name="delete_name" value="" class="form-control" placeholder="role_access" />
					</div>
					@include('admin.components.errors_box')
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-danger btn-block">ONCE DELETED, CAN'T BE RESTORE</button>
				</div>
			</div>
		</form>
	</div>	
</div>
@endsection