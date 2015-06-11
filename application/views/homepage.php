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
	<title>HomePage</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link type="text/css" rel="stylesheet" href="../asset/stylesheet/bookReview.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<h1>Welcome <?=$this->session->userdata['user_info']['first_name']?></h1>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-2"><a href="/AddBook">Add Book and Review</a></div>
			<div class="col-md-1"><a href="/Logout">Logout</a></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="RecentBookReviews">
					<h2>Recent Book Reviews:</h2>
					<?php foreach ($bookReviews as $bookReview) { ?>
						<div class="bookReview">
							<h3><a href="/books/<?=$bookReview['book_id']?>"><?=$bookReview['title']?></a></h3>
							<h4>Rating: <?=$bookReview['rating']?>/5</h4>
							<p><a href="/users/<?=$bookReview['user_id']?>"><?=$bookReview['first_name']?></a> says: <?=$bookReview['review']?></p>
							<p>Posted on <?=$bookReview['created_at']?></p>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="OtherBookReviews">
				<h2>Other Books with Reviews:</h2>
				<div class="allBooks">
				<?php foreach ($books as $book){ ?>
						<p><a href="/books/<?=$book['id']?>"><?=$book['title']?></a></p>
				<?php } ?>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>