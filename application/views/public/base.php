<?php
$this->load->view('public/header', $html);
if (!empty($url))
    $this->load->view($url, $html);
$this->load->view('public/footer');
