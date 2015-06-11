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
	<title>Add Book and Review</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../asset/stylesheet/bookReview.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-1"><a href="/home">Home</a></div>
			<div class="col-md-1"><a href="/Logout">Logout</a></div>
		</div>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<h2>Add a New Book Title and a Review</h2>
				<form action="/CreateBook" method="post">
					<p>Book Title</p>
					<input type="text" name="bookTitle">
					<h4>Author</h4>
					<p>Select from list</p>
					<select name="authorList">
						<?php foreach($authors as $author) { ?>
						<option value="<?=$author['name']?>"><?=$author['name']?></option>
						<?php } ?>
					</select>
					<p>Or add a new author</p>
					<input type="text" name="authorNew">
					<p>Review</p>
					<textarea name="review"></textarea><br>
					<p>Rating</p>
					<select name="rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select><br>
					<input type="submit" value="Add Book and Review">
				</form>
				<div class="red">
					<p><?=$this->session->flashdata('error2')?></p>
				</div>
				<div class="glass">
					<p><?=$this->session->flashdata('success')?></p>
				</div>
			</div>	
		</div>
	</div>
</body>
</html>