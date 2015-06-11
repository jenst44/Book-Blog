<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler(true);
	}

	public function index()
	{
		$this->load->view('index');
	}

	public function create()
	{
		$this->load->model('user');
		if($this->user->validate_reg($this->input->post()) == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
		}
		else
		{
			$this->user->create($this->input->post());
			$user = $this->user->find_user($this->input->post());
			$this->session->set_userdata('user_info', $user);
			redirect('/home');
		}
		redirect('/');
	}

	public function login()
	{
		$this->load->model('user');
		if($this->user->validate_login($this->input->post()) == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
		}
		$user = $this->user->find_user($this->input->post());
		if($user)
		{
			$this->session->set_userdata('user_info', $user);
			redirect('/home');
		}
		redirect('/');
	}

	public function home()
	{
		$this->load->model('user');
		$bookReviews = $this->user->find_recent_book_reviews();
		$allBooks = $this->user->find_all_books();
		$this->load->view('homepage', array('bookReviews' => $bookReviews, 'books' => $allBooks));
	}

	public function AddBook()
	{
		$this->load->model('user');
		$authors = $this->user->find_all_authors();
		$this->load->view('addBook', array('authors' => $authors));
	}

	public function CreateBook()
	{
		$this->load->model('user');
		if($this->user->validate_book($this->input->post()) == FALSE)
		{
			$this->session->set_flashdata('error2', validation_errors());
		}
		else
		{
			$this->user->add_book($this->input->post());
			$this->session->set_flashdata('success', 'Your Book was added!');
		}
		redirect('/AddBook');
	}

	public function ViewBook($id)
	{
		$this->load->model('user');
		$reviews = $this->user->find_book_reviews($id);
		$this->load->view('book', array('reviews' => $reviews));
	}

	public function SubmitReview($id)
	{
		$this->load->model('user');
		$this->user->submit_review($this->input->post(),$id);
		redirect('/books/'.$id);
	}

	public function ShowUser($id)
	{
		$this->load->model('user');
		$result = $this->user->find_user_by_id($id);
		$reviewNumber = $this->user->total_review_number($id);
		$this->load->view('usersView', array('user' => $result, 'reviewNumber' => $reviewNumber));
	}

	public function DeleteReview($rating_id,$book_id)
	{
		$this->load->model('user');
		$result = $this->user->delete_review($rating_id);
		redirect('/books/'.$book_id);
	}

	public function Logout()
	{
		session_destroy();
		redirect('/');
	}

}