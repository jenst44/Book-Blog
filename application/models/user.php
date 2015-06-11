<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function validate_reg($post)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|alpha');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[confirm_password]|md5');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|md5');

		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function validate_login($post)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|md5');

		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function create($userinfo)
	{
		$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES(?,?,?,?,NOW(),NOW())";
		$values= array($userinfo['first_name'],$userinfo['last_name'],$userinfo['email'],$userinfo['password']);
		$this->db->query($query, $values);
	}

	public function find_user($userinfo)
	{
		$query = "SELECT * FROM users WHERE email = ? AND password =?";
		$values = array($userinfo['email'], $userinfo['password']);
		$result = $this->db->query($query, $values)->row_array();
		return $result;
	}

	public function validate_book($post)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('bookTitle', 'Book Title', 'required|trim');
		$this->form_validation->set_rules('authorNew', 'Author', 'trim|is_unique[authors.name]');
		$this->form_validation->set_rules('review', 'Review', 'required|trim');

		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}

	public function add_book($post)
	{
		if(!empty($post['authorNew']))
		{
			$authorQuery = "INSERT INTO authors (name, user_id, created_at, updated_at) VALUES (?,?,NOW(),NOW())";
			$authorValues = array($post['authorNew'], $this->session->userdata['user_info']['id']);
			$this->db->query($authorQuery, $authorValues);
			$theAuthor = $post['authorNew'];
		}
		else
		{
			$theAuthor = $post['authorList'];
		}

		$authorIDQuery = "SELECT authors.id FROM authors WHERE authors.name = ?";
		$authorID = $this->db->query($authorIDQuery, $theAuthor)->row_array();

		$bookQuery = "INSERT INTO books (title, author_id, user_id, created_at, updated_at) VALUES (?,?,?,NOW(),NOW())";
		$bookValues = array($post['bookTitle'], $authorID, $this->session->userdata['user_info']['id']);
		$this->db->query($bookQuery, $bookValues);

		$bookID = $this->db->insert_id();

		$ratingQuery = "INSERT INTO ratings (user_id, rating, review, book_id, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())";
		$ratingValues = array($this->session->userdata['user_info']['id'], $post['rating'], $post['review'], $bookID);
		$this->db->query($ratingQuery, $ratingValues);

	}

	public function find_all_authors()
	{
		$query = "SELECT authors.name FROM authors ORDER BY authors.name";
		return $this->db->query($query)->result_array();
	}

	public function find_recent_book_reviews()
	{
		$query="SELECT books.title, books.id as book_id, ratings.rating, ratings.review, users.first_name, users.id as user_id, DATE_FORMAT(ratings.created_at, '%M %D %Y') AS created_at
				FROM ratings
				LEFT JOIN books ON books.id = ratings.book_id
				LEFT JOIN users ON users.id = ratings.user_id
				LEFT JOIN authors ON books.author_id = authors.id
				ORDER BY ratings.created_at DESC
				LIMIT 3";
		return $this->db->query($query)->result_array();
	}

	public function find_all_books()
	{
		$query = "SELECT books.title, books.id FROM books ORDER BY books.title";
		return $this->db->query($query)->result_array();
	}

	public function find_book_reviews($id)
	{
		$query = "SELECT books.title, books.id as book_id, ratings.rating, ratings.review, users.first_name, users.id as user_id, DATE_FORMAT(ratings.created_at, '%M %D %Y') AS created_at, authors.name, ratings.id as rating_id
				FROM ratings
				LEFT JOIN books ON books.id = ratings.book_id
				LEFT JOIN users ON users.id = ratings.user_id
				LEFT JOIN authors ON books.author_id = authors.id
				WHERE books.id = $id
				ORDER BY ratings.id DESC
				LIMIT 3";
		return $this->db->query($query)->result_array();
	}

	public function submit_review($review,$bookID)
	{
		$query = "INSERT INTO ratings (rating, review, user_id, book_id, created_at, updated_at) 
		VALUES (?,?,?,?,NOW(),NOW())";
		$values = array($review['rating'], $review['review'], $this->session->userdata['user_info']['id'], $bookID);
		$this->db->query($query, $values);
	}

	public function find_user_by_id($id)
	{
		$query = "SELECT CONCAT_WS(' ',users.first_name,users.last_name) as full_name, users.email, books.title, books.id as book_id FROM users
				LEFT JOIN ratings ON users.id = ratings.user_id
				LEFT JOIN books ON ratings.book_id = books.id
				WHERE users.id = $id
				ORDER BY books.title";
		return $this->db->query($query)->result_array();
	}

	public function total_review_number($id)
	{
		$query = "SELECT count(ratings.review) as count FROM ratings 
		LEFT JOIN users on users.id = ratings.user_id
		WHERE users.id = $id";
		return $this->db->query($query)->row_array();
	}

	public function delete_review($id)
	{
		$query = "DELETE FROM ratings WHERE id=$id";
		$this->db->query($query);
	}

}