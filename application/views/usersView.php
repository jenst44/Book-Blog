<?php
	if(empty($this->session->userdata['user_info']))
	{
		redirect('/');
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Users Reviews</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../asset/stylesheet/bookReview.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-1"><a href="/home">Home</a></div>
			<div class="col-md-2"><a href="/AddBook">Add Book and Review</a></div>
			<div class="col-md-1"><a href="/Logout">Logout</a></div>
		</div>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-8">
				<h1>User: <?=$user[0]['full_name']?></h1>
				<h3>Email: <?=$user[0]['email']?></h3>
				<h3>Total Reviews: <?=$reviewNumber['count']?></h3>
				<br>
				<h3>Posted Reviews on the following books</h3>
				<?php foreach ($user as $book) { ?>
					<p><a href="/books/<?=$book['book_id']?>"><?=$book['title']?></a></p>
				<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>