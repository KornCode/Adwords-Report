@extends('admin.layout.backend')

@section('title')
Edit Member #{{ $member->id }}
@endsection

@section('content')

@include('admin.components.errors_box')

<form action="{{ route('admin.members.edit.post') }}" role="form" method="POST">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-sm-4">
			<input type="hidden" name="member_id" value="{{ $member->id }}">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">General Profile</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="first_name" class="control-label">First Name</label>
						<input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ $member->first_name }}" />
					</div>
					<div class="form-group">
						<label for="first_name" class="control-label">Last Name</label>
						<input type="text" name="last_name" class="form-control" placeholder="First Name" value="{{ $member->last_name }}" />
					</div>
					<div class="form-group">
						<label for="first_name" class="control-label">Email</label>
						<input type="email" name="email" disabled="disabled" class="form-control" placeholder="First Name" value="{{ $member->email }}" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-success">Change Profile</button>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Change AdWords Key</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="adwords" class="control-label">New AdWords Key</label>
						<input type="text" name="new_adwords_key" class="form-control" placeholder="New AdWords Key" value="" />
					</div>
					<div class="form-group">
						<label for="adwords" class="control-label">Confirm New AdWords Key</label>
						<input type="text" name="new_adwords_key_confirm" class="form-control" placeholder="Confirm New AdWords Key" value="" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-warning">Change AdWords Key</button>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Change Password</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="first_name" class="control-label">New Password</label>
						<input type="text" name="new_password" class="form-control" placeholder="New Password" value="" />
					</div>
					<div class="form-group">
						<label for="first_name" class="control-label">Confirm New Password</label>
						<input type="text" name="new_password_confirm" class="form-control" placeholder="Confirm New Password" value="" />
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-danger">Change Password</button>
				</div>
			</div>
		</div>
		
	</div>

	<div class="row">
		<div class="col-sm-4">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Roles</h3>
				</div>
				<div class="box-body">
				@foreach($roles as $guard => $guard_roles)
					<p><strong>Guard [{{ $guard }}]</strong></p>
					@foreach($guard_roles as $role)
						<label class="checkbox-inline">
							<input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}" {{ $member->hasRole($role->name) ? 'checked' : '' }}> {{ $role->name }}
						</label>
					@endforeach
				@endforeach
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-block btn-primary">Change Roles</button>
				</div>
			</div>
		</div>

		
	</div>
		
</form>

@endsection