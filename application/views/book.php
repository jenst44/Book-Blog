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
	<title>View Book Reviews</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../asset/stylesheet/bookReview.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<h1><?=$reviews[0]['title'];?></h1>
				<h3><?=$reviews[0]['name'];?></h3>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-1"><a href="/home">Home</a></div>
			<div class="col-md-1"><a href="/Logout">Logout</a></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h2>Reviews:</h2>
				<div class="reviewBox">
					<?php foreach ($reviews as $review) { ?>
					<p>Rating <?=$review['rating']?>/5</p>
					<p><a href="/users/<?=$review['user_id']?>"><?=$review['first_name']?></a> says <?=$review['review']?></p>
					<p><?=$review['created_at']?> <?php if($review['first_name'] == $this->session->userdata['user_info']['first_name']) { ?> 
					<a href="/delete/<?=$review['rating_id']?>/<?=$review['book_id']?>">Delete Review</a></p>
					<?php } } ?>
				</div>
			</div>
			<div class="col-md-6">
				<h3>Add a Review</h3>
				<form action="/submitReview/<?=$reviews[0]['book_id']?>" method="post">
					<textarea name="review"></textarea><br>
					<select name="rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<input type="submit">
				</form>
			</div>
		</div>
	</div>
</body>
</html>