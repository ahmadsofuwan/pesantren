<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Content extends MY_Controller
{

	public function checkdata()
	{

		$tableName = 'students';
		$dataCompany = $this->getDataRow('profile_company', '*');

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$join = array(
				array('class', 'class.pkey =' . $tableName . '.classkey'),
			);

			$studentData = $this->getDataRow($tableName, $tableName . '.*,class.name as classname', array('nis' => $_POST['nis']), '', $join);
			if (empty(count($studentData))) {
				$_SESSION['arrErrMsg'] = 'NIS yang Anda Masukan Salah';
				redirect(base_url());
			}

			//detail
			$memori = $this->getDataRow('memori', '*', array('classkey' => $studentData[0]['classkey']));
			$whereDetailMemori = '';
			if (!empty(count($memori)))
				$whereDetailMemori = 'memorikey in (' . $this->implode($memori, 'pkey') . ')';
			$detailMemori = $this->getDataRow('memori_detail', '*', $whereDetailMemori);
			$level = $this->getDataRow('level', '*', '', '', '', 'level.pkey ASC');
			$studentDetail = $this->getDataRow('student_detail', '*', array('studentkey' => $studentData[0]['pkey']));
			$data['html']['studentDetail'] = $studentDetail;
			$data['html']['detailMemori'] = $detailMemori;
			$data['html']['memori'] = $memori;
			$data['html']['level'] = $level;
			//detail


			$data['html']['studentData'] = $studentData;
		}

		$data['html']['dataCompany'] = $dataCompany;
		$data['html']['title'] = 'Laporan Data Murid';
		$data['url'] = 'public/body';
		$this->templatePublic($data);
	}
}
