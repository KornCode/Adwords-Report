@extends('admin.layout.backend')

@section('title')
Roles Management
@endsection

@section('content')
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Roles</h3>
			<div class="box-tools pull-right">
				<a href="{{ route('admin.roles.create') }}" style="width: 150px;" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> New Role</a>
			</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Guard Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($roles as $role)
						<tr>
							<td>{{ $role->id }}</td>
							<td>{{ $role->name }}</td>
							<td>{{ $role->guard_name }}</td>
							<td>
								<a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection