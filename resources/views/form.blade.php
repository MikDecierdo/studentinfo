<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Personal Information</title>
	<style>
		body{font-family: Arial, Helvetica, sans-serif; padding:20px}
		.student{border:1px solid #ddd; padding:10px; margin:10px 0; display:flex; gap:10px; align-items:center}
		.student img{max-width:120px; height:auto}
	</style>
</head>
<body>
	<h2>Personal Information</h2>

	@if(session('success'))
		<div style="color:green">{{ session('success') }}</div>
	@endif

	@if($errors->any())
		<div style="color:red">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div>
			<label for="name">Name</label><br>
			<input type="text" name="name" id="name" value="{{ old('name') }}" required>
		</div>
        <br>
		<div>
			<label for="image">2x2 Id Picture</label><br>
			<input type="file" name="image" id="image" accept="image/*">
		</div>
        <br>
		<div>
			<label for="birthdate">Birthdate</label><br>
			<input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
		</div>
        <br>
		<div>
			<label for="email">Email Address</label><br>
			<input type="email" name="email" id="email" value="{{ old('email') }}" required>
		</div>
		<div style="margin-top:10px">
			<button type="submit">Submit</button>
		</div>
	</form>

<br><br><br>
<h2>Saved Students</h2>
	@if(isset($students) && $students->count())
		@foreach($students as $student)
			<div class="student">
				@if($student->image)
					<img src="{{ asset('images/'.$student->image) }}" alt="{{ $student->name }}">
				@else
					<div style="width:120px;height:80px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;color:#999">No Image</div>
				@endif
				<div>
					<strong>{{ $student->name }}</strong><br>
					<small>Birthdate: {{ $student->birthdate }}</small><br>
					<small>Email: {{ $student->email }}</small>
				</div>
			</div>
		@endforeach
	@else
		<p>No students found.</p>
	@endif

</body>
</html>
