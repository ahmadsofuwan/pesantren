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
			$detailJoin = array(
				array('memori_detail', 'memori_detail.pkey=student_detail.detailmemorikey', 'left'),
			);
			$detailSelect = '
				student_detail.*,
				memori_detail.name memoridetailname
			';
			$dataDetail = $this->getDataRow('student_detail', $detailSelect, array('studentkey' => $studentData[0]['pkey']), '', $detailJoin, 'memori_detail.name DESC');
			$dataMemori = $this->getDataRow('memori', '*', 'pkey in (' . $this->implode($dataDetail, 'memorikey') . ')', '', '', 'name ASC');
			$level = $this->getDataRow('level', '*', '', '', '', 'level.pkey ASC');
			
			$data['html']['level'] = $level;
			$data['html']['dataMemori'] = $dataMemori;
			$data['html']['dataDetail'] = $dataDetail;
			//detail


			$data['html']['studentData'] = $studentData;
		}

		$data['html']['dataCompany'] = $dataCompany;
		$data['html']['title'] = 'Laporan Data Murid';
		$data['url'] = 'public/body';
		$this->templatePublic($data);
	}
}
