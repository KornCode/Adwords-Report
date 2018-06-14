@extends('admin.layout.backend')

@section('title')
Edit Permission #{{ $permission->id }}
@endsection

@section('content')
@include('admin.components.errors_box')
<div class="row">
	<div class="col-sm-4">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Editing Permission #{{ $permission->id }} - {{ $permission->guard_name }} - {{ $permission->name }}</h3>
			</div>
			<div class="box-body">
				<form action="{{ route('admin.permissions.edit.post') }}" method="POST" role="form">
					{{ csrf_field() }}
					<input type="hidden" name="permission_id" value="{{ $permission->id }}">
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Role name" value="{{ $permission->name }}" />
					</div>
					<div class="form-group{{ $errors->has('guard_name') ? ' has-error' : '' }}">
						<label for="name" class="control-label">Guard Name</label>
						<input type="text" name="guard_name" class="form-control" placeholder="Guard name" value="{{ $permission->guard_name }}" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-block">Submit</button>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<form action="{{ route('admin.permissions.delete.post') }}" method="POST" role="form">
			{{ csrf_field() }}
			<input type="hidden" name="permission_id" value="{{ $permission->id }}" />
			<div class="box collapsed-box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Delete Permission</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="delete_input" class="control-label">Type in permission name</label>
						<input type="text" name="delete_name" value="" class="form-control" placeholder="permission_access" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-danger btn-block">ONCE DELETED, CAN'T BE RESTORE</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection