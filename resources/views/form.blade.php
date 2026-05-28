	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Personal Information</title>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/form.css') }}">
		</head>
		<body>
			<div class="wrap">
				<div class="grid">
					<div>
						<div class="card">
							<h1>Personal Information</h1>
							@if(session('success'))
								<div class="success">{{ session('success') }}</div>
							@endif

							@if($errors->any())
								<div style="color:#dc2626;margin-bottom:8px">
									<ul style="margin:0;padding-left:18px">
										@foreach($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" value="{{ old('name') }}" required>
								</div>
								<div class="row">
									<label for="image">2x2 Id Picture</label>
									<div class="preview" id="imgPreview">No image selected</div>
									<input type="file" name="image" id="image" accept="image/*" style="display:none" onchange="previewImage(event)">
									<label class="file-label" tabindex="0" role="button" aria-label="Choose 2x2 image" for="image">Choose image</label>
								</div>
								<div class="row">
									<label for="birthdate">Birthdate</label>
									<input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
								</div>
								<div class="row">
									<label for="email">Email Address</label>
									<input type="email" name="email" id="email" value="{{ old('email') }}" required>
								</div>
								<div style="margin-top:8px">
									<button class="btn" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
					<aside>
						<div class="card">
							<h2>Saved Students</h2>
							@if(isset($students) && $students->count())
								<div style="display:flex;flex-direction:column;gap:12px;margin-top:12px">
									@foreach($students as $student)
										<div class="student">
											@if($student->image)
												<img src="{{ asset('images/'.$student->image) }}" alt="{{ $student->name }}">
											@else
												<div style="width:120px;height:120px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:var(--muted)">No Image</div>
											@endif
											<div>
												<strong>{{ $student->name }}</strong>
												<div class="muted">Birthdate: {{ $student->birthdate }}</div>
												<div class="muted">Email: {{ $student->email }}</div>
											</div>
										</div>
									@endforeach
								</div>
							@else
								<p class="muted" style="margin-top:12px">No students found.</p>
							@endif
						</div>
					</aside>
				</div>
			</div>

			<script>
				function previewImage(e){
					const file = e.target.files[0];
					const preview = document.getElementById('imgPreview');
					if(!file){ preview.innerText = 'No image selected'; return }
					const img = document.createElement('img');
					img.style.maxWidth = '100%'; img.style.maxHeight = '100%'; img.style.objectFit = 'cover'; img.alt = 'preview';
					const reader = new FileReader();
					reader.onload = function(ev){ preview.innerHTML = ''; img.src = ev.target.result; preview.appendChild(img) }
					reader.readAsDataURL(file);
				}
				// keyboard proxy for hidden file input (supports Enter/Space)
				const fileInput = document.getElementById('image');
				document.querySelectorAll('.file-label').forEach(lbl=>{
					lbl.addEventListener('keydown', (e)=>{
						if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); fileInput && fileInput.click(); }
					});
				});
			</script>
		</body>
		</html>
