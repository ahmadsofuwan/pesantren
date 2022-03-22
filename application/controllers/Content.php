<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Content extends MY_Controller
{

	public function checkdata()
	{

		$tableName = 'students';
		$dataCompany = $this->getDataRow('profile_company', '*');
		$join = array(
			array('class', 'class.pkey =' . $tableName . '.classkey'),
		);
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$studentData = $this->getDataRow($tableName, $tableName . '.*,class.name as classname', array('nis' => $_POST['nis']), '', $join);
			if (empty(count($studentData))) {
				$_SESSION['arrErrMsg'] = 'NIS yang Anda Masukan Salah';
				redirect(base_url());
			}
			$detailJoin = array(
				array('memori', 'memori.pkey = students_detail.memorikey'),
			);
			$detailData =  $this->getDataRow('students_detail', 'students_detail.*,memori.name as memoriname', array('studentkey' => $studentData[0]['pkey']), '', $detailJoin);
			$implodeDetailKey = '';
			foreach ($detailData as $key => $value) {
				if (empty($implodeDetailKey)) {
					$implodeDetailKey = $value['pkey'];
				} else {
					$implodeDetailKey .= ', ' . $value['pkey'];
				}
			}

			$subditail = $this->getDataRow('student_memori_detail', 'student_memori_detail.*', 'refkey in (' . $implodeDetailKey . ')', '');
			$selValLevel = $this->getDataRow('level', '*', '', '', '', 'level.pkey ASC');
			$selValMemori = $this->getDataRow('memori', '*', '', '', '', 'memori.name ASC');
			$selValMemoriDetail = $this->getDataRow('memori_detail', '*', '', '', '', 'memori_detail.name ASC');

			$data['html']['selValMemoriDetail'] = $selValMemoriDetail;
			$data['html']['studentData'] = $studentData;
			$data['html']['detailData'] = $detailData;
			$data['html']['subditail'] = $subditail;
			$data['html']['selValLevel'] = $selValLevel;
			$data['html']['selValMemori'] = $selValMemori;
		}

		$data['html']['dataCompany'] = $dataCompany;
		$data['html']['title'] = 'Laporan Data Murid';
		$data['url'] = 'public/body';
		$this->templatePublic($data);
	}
}
