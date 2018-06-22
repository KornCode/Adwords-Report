@extends('admin.layout.backend')

@section('title')
Create a new Member
@endsection

@section('content')
@include('admin.components.errors_box')


<div class="row">
	<div class="col-sm-4">
		<form action="{{ route('admin.members.create.post') }}" method="POST" role="form">
			{{ csrf_field() }}
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">General Profile</h3>
				</div>
				<div class="box-body">
					<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
						<label for="first_name" class="control-label">First Name</label>
						<input type="text" name="first_name" class="form-control" placeholder="First Name" />
					</div>
					<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
						<label for="first_name" class="control-label">Last Name</label>
						<input type="text" name="last_name" class="form-control" placeholder="Last Name" />
					</div>
					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="first_name" class="control-label">Email</label>
						<input type="email" name="email" class="form-control" placeholder="Email" />
					</div>
					<div class="form-group{{ $errors->has('adwords') ? ' has-error' : '' }}">
						<label for="adwords" class="control-label">AdWords</label>
						<input type="text" name="adwords" class="form-control" placeholder="AdWords Key : Optional" />
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-block btn-success">Create New Member</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
	
@endsection