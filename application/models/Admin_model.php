<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

	public function getcek_data()
	{
		return $this->db->get('pelanggan');
	}
	public function get_logs()
	{
		return $this->db->get('logs');
	}
	public function get_logs_id($id)
	{

		return $this->db->get_where('logs', array('id' => $id));
	}
	public function add_logs($zte)
	{
		$data = array(
			'zte' => $zte,
			'logs' => ''

		);
		$this->db->insert('logs', $data);
	}
	public function update_logs($zte, $logs)
	{
		$this->db->query("UPDATE `logs` SET `logs` = CONCAT_WS('\n',(SELECT logs WHERE `zte` ='" . $zte . "'),'" . $logs . "') WHERE `logs`.`zte` = '" . $zte . "';");
	}
	public function get_tiket_open()
	{
		return $this->db->get_where('laporan', array('status' => 'open'));
	}
	public function get_tiket_close()
	{
		return $this->db->get_where('laporan', array('status' => 'close'));
	}
	public function get_tiket_id($id)
	{
		return $this->db->get_where('laporan', array('id' => $id));
	}
	public function tiket_progress($id, $pesan)
	{
		$enter = '
';

		$data = $this->db->get_where('laporan', array('id' => $id));
		$nohp = '';
		$tiket = '';
		$text = '';


		foreach ($data->result() as $row) {
			$data = array(
				'nama' => $row->nama,
				'customerid' => $row->customerid,
				'bvision' => $row->bvision,
				'sn' => $row->sn,
				'mac' => $row->mac,
				'alamat' => $row->alamat,
				'nohp' => $row->nohp,
				'koordinat' => $row->koordinat,
				'keluhan' => $row->keluhan,
				'wa' => $row->custumer,
				'owner' => $this->session->userdata('username'),
				'catatan' => $pesan,
				'nohp' => $row->custumer,
				'tiket' => '#BN' . $row->tiket

			);
			$nohp = $row->custumer;
			$tiket = $row->tiket;
			$info = 'informasi lebih lanjut hub: ' . $enter . 'https://wa.me/6282375437911 ';
			$text = 'Laporan dengan nomor tiket *#BN' . $tiket . '* telah di prosess' . $enter;
			$text .= '*Catatan:*' . $enter . $pesan . $enter . $info;
		}
		$postdata = http_build_query(
			array(
				'nohp' => $nohp . '@c.us',
				'pesan' => $text,
				'data' => $data
			)
		);
		$opts = array(
			'http' =>
			array(
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context = stream_context_create($opts);
		file_get_contents('http://localhost:8000/send', false, $context);
		$username = $this->session->userdata('username');
		$this->db->query("UPDATE `laporan` SET `status`='close',`restime`='" . strtotime("now") . "',`catatan`='" . $pesan . "',`owner`='" . $username . "' WHERE `id`=" . $id);
	}
	public function create_laporan($data)
	{
		$time = strtotime("now");
		$linetime = strlen($time);
		$tiket = substr($time, $linetime - 6, $linetime);
		$val = array(
			'tiket' => $tiket,
			'nama' => $data[0],
			'customerid' => $data[1],
			'bvision' => $data[2],
			'sn' => $data[3],
			'mac' => $data[4],
			'custumer' => $data[5],
			'alamat' => $data[6],
			'koordinat' => $data[7],
			'nohp' => $data[5],
			'keluhan' => $data[8],
			'status' => 'open',
			'time' => $time,
		);
		$this->db->insert('laporan', $val);
		echo ('#BB' . $tiket);
		$enter = '
';
		$grub = "*FROM CLIENT*" . $enter;
		$grub .= "https://wa.me/" . $data[5] . $enter;
		$grub .= "*NO TIKET:* " . '#BN' . $tiket . $enter;
		$grub .= "NAMA :" . $data[0] . $enter;
		$grub .= "customer id :" . $data[1] . $enter;
		$grub .= "BVISION :" . $data[2] . $enter;
		$grub .= "SN modem :" . $data[3] . $enter;
		$grub .= "MAC STB :" . $data[4] . $enter;
		$grub .= "ALAMAT :" . $data[6] . $enter;
		$grub .= "NO HP :" . $data[5] . $enter;
		$grub .= "koordinat :" . $data[7] . $enter;
		$grub .= "keluhan :" . $data[8] . $enter;

		$plg = '#tiket' . $enter;
		$plg .= 'NAMA :' . $data[0] . $enter;
		$plg .= 'customer id :' . $data[1] . $enter;
		$plg .= 'BVISION :' . $data[2] . $enter;
		$plg .= 'SN modem :' . $data[3] . $enter;
		$plg .= 'MAC STB :' . $data[4] . $enter;
		$plg .= 'ALAMAT :' . $data[6] . $enter;
		$plg .= 'NO HP :' . $data[5] . $enter;
		$plg .= 'koordinat :' . $data[5] . $enter;
		$plg .= 'keluhan :' . $data[8] . $enter;

		$plg2 = 'laporan anda telah di terima dengan nomor tiket *#BN' . $tiket . $enter;
		$plg2 .= 'kami tidak akan proses laporan jika:' . $enter;
		$plg2 .= '*1*. format laporan salah' . $enter;
		$plg2 .= '*2*. data wajib tidak di isi' . $enter;


		$postdata = http_build_query(
			array(
				'grub' => '120363040052518657@g.us',
				'nohp' => $data[5] . '@c.us',
				'pesan_pelanggan' => $plg,
				'pesan_pelanggan2' => $plg2,
				'pesan_grub' => $grub,
			)
		);
		$opts = array(
			'http' =>
			array(
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context = stream_context_create($opts);
		file_get_contents('http://localhost:8000/sendto', false, $context);
	}

	public function cek_regis_ikr($nama)
	{
		$query = $this->db->get_where('akun', array('name' => $nama, 'role' => 'ikr'));
		return $query;
	}
	public function cek_regis_superadmin($nama)
	{
		$query = $this->db->get_where('akun', array('name' => $nama, 'role' => 'superadmin'));
		return $query;
	}
	public function cek_regis_cs($nama)
	{
		$query = $this->db->get_where('akun', array('name' => $nama, 'role' => 'cs'));
		return $query;
	}
	public function insert_ikr($nama, $password)
	{
		$data = array(
			'name' => $nama,
			'password' => md5($password),
			'role' => 'ikr'
		);

		$this->db->insert('akun', $data);
	}
	public function insert_superadmin($nama, $password)
	{
		$data = array(
			'name' => $nama,
			'password' => md5($password),
			'role' => 'superadmin'
		);

		$this->db->insert('akun', $data);
	}
	public function insert_cs($nama, $password)
	{
		$data = array(
			'name' => $nama,
			'password' => md5($password),
			'role' => 'cs'
		);

		$this->db->insert('akun', $data);
	}
	public function get_ikr()
	{
		$query = $this->db->get_where('akun', array('role' => 'ikr'));
		return $query;
	}
	public function get_superadmin()
	{
		$query = $this->db->get_where('akun', array('role' => 'superadmin'));
		return $query;
	}
	public function get_cs()
	{
		$query = $this->db->get_where('akun', array('role' => 'cs'));
		return $query;
	}
	public function cek_login($username, $password)
	{
		$query = $this->db->get_where('akun', array('name' => $username, 'password' => $password), 1);
		return $query;
	}
	public function delete_akun($id)
	{
		$this->db->delete('akun', array('id' => $id));
	}
	public function ekport()
	{
		return $this->db->get_where('laporan', array('status' => 'close'));
	}
}
