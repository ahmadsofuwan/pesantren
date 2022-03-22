<?php
$this->load->view('template/header', $html);
if (!empty($url))
    $this->load->view($url, $html);
$this->load->view('template/footer');
