@extends('admin.layout.backend')

@section('title')
Permissions Management
@endsection

@section('content')
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Permissions</h3>
			<div class="box-tools pull-right">
				<a href="{{ route('admin.permissions.create') }}" style="width: 150px;" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> New Permission</a>
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
						@foreach($permissions as $permission)
						<tr>
							<td>{{ $permission->id }}</td>
							<td>{{ $permission->name }}</td>
							<td>{{ $permission->guard_name }}</td>
							<td>
								<a href="{{ route('admin.permissions.edit', ['id' => $permission->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection