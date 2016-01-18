<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Simple Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>Create New User</h1>
		<hr>
		<form action="{{ url('/') }}/users" method="POST">
			<div class="form-group">
				<label for="email">Email Address</label>
				<input type="email" name="email" id="email" class="form-control">
			</div>
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>

			<div class="form-group">
				<input type="submit" value="Create New User" class="btn btn-info">
			</div>
		</form>
		<hr>
	</div>
</body>
</html>