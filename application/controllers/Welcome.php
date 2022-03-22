<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	public function index()
	{
		$data['titledashnoard'] = 'Masukan NIS Siswa/Siswi';
		$data['title'] = 'dashboard';
		$this->load->view('public/dashboard', $data);
	}
}
