<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');


class Admin extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->role = $this->session->userdata('role');
		$this->id = $this->session->userdata('id');
		$login = $this->session->userdata('login');
		if (!$login) {
			redirect(base_url('Auth'));
		}
	}

	public function index()
	{
		$data['html']['title'] = 'Dasboard';
		$this->template($data);
	}

	public function studentList($classKey = '')
	{

		$tableName = 'students';
		$className = 'student';
		$where = '';
		$whereSelValClass = '';
		if (!empty($classKey))
			$where = $tableName . '.classkey=' . $classKey;
		$join = array(
			array('class', 'class.pkey=' . $tableName . '.classkey', 'left')
		);
		if ($this->role != '1') {
			$classAcces = $this->getDataRow('account_detail', '*', array('refkey' => $this->id));
			$whereSelValClass = 'pkey in (' . $this->implode($classAcces, 'classkey') . ')';
			if (empty($where)) {
				$where = 'classkey in (' . $this->implode($classAcces, 'classkey') . ')';
			} else {
				$where .= ' AND classkey in (' . $this->implode($classAcces, 'classkey') . ')';
			}
		}
		$dataList = $this->getDataRow($tableName, $tableName . '.*,class.name as classname', $where, '', $join,  $tableName . '.name ASC');
		$selValClass = $this->getDataRow('class', '*', $whereSelValClass, '', '', 'class.name ASC');

		$data['html']['role'] = $this->role;
		$data['html']['classKey'] = $classKey;
		$data['html']['selValClass'] = $selValClass;
		$data['html']['title'] = 'List Murid';
		$data['html']['dataList'] = $dataList;
		$data['html']['form'] = get_class($this) . '/' . $className;
		$data['url'] = 'admin/' . $className . 'List';
		$this->template($data);
	}

	public function student($id = '')
	{

		$tableName = 'students';
		$tableDetail = 'student_detail';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$formData = array(
			'pkey' => 'pkey',
			'nis' => 'nis',
			'name' => 'name',
			'birthday' => array('birthday', 'date'),
			'birthdaynoted' => 'birthdayNoted',
			'classkey' => 'class',
			'father' => 'father',
			'mother' => 'mother',
		);

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "nama wajib Di isi");
			if (empty($_POST['nis']))
				array_push($arrMsgErr, "NIS wajib Di isi");
			if (empty($_POST['birthdayNoted']) || empty($_POST['birthday']))
				array_push($arrMsgErr, "Tempat Tanggal Lahir wajib Di isi");
			if (empty($_POST['father']) || empty($_POST['mother']))
				array_push($arrMsgErr, "Orang Tua wajib Di isi");


			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$memori = $this->getDataRow('memori', '*', 'classkey=' . $_POST['class']);
						$memoriDetail = $this->getDataRow('memori_detail', '*', 'memorikey in(' . $this->implode($memori, 'pkey') . ')');
						foreach ($memoriDetail as $memoriDetailKey => $memoriDetailValue) {
							$data = array(
								'studentkey' => $refkey,
								'memorikey' => $memoriDetailValue['memorikey'],
								'detailmemorikey' => $memoriDetailValue['pkey'],
								'levelkey' => $_POST['level_' . $memoriDetailValue['memorikey'] . '_' . $memoriDetailValue['pkey']],
							);
							$this->insert($tableDetail, $data);
						}

						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->delete($tableDetail, array('studentkey' => $_POST['pkey']));
						$memori = $this->getDataRow('memori', '*', 'classkey=' . $_POST['class']);
						$memoriDetail = $this->getDataRow('memori_detail', '*', 'memorikey in(' . $this->implode($memori, 'pkey') . ')');
						foreach ($memoriDetail as $memoriDetailKey => $memoriDetailValue) {
							$data = array(
								'studentkey' => $id,
								'memorikey' => $memoriDetailValue['memorikey'],
								'detailmemorikey' => $memoriDetailValue['pkey'],
								'levelkey' => $_POST['level_' . $memoriDetailValue['memorikey'] . '_' . $memoriDetailValue['pkey']],
							);
							$this->insert($tableDetail, $data);
						}
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);

			$memori = $this->getDataRow('memori', '*', array('classkey' => $dataRow['classkey']));
			$whereDetailMemori = '';
			if (!empty(count($memori)))
				$whereDetailMemori = 'memorikey in (' . $this->implode($memori, 'pkey') . ')';
			$detailMemori = $this->getDataRow('memori_detail', '*', $whereDetailMemori);
			$level = $this->getDataRow('level', '*', '', '', '', 'level.pkey ASC');
			$studentDetail = $this->getDataRow('student_detail', '*', array('studentkey' => $id));
			$data['html']['studentDetail'] = $studentDetail;
			$data['html']['detailMemori'] = $detailMemori;
			$data['html']['memori'] = $memori;
			$data['html']['level'] = $level;
		}

		$selValClass = $this->getDataRow('class', '*', '', '', '', 'class.name ASC');
		$selValLevel = $this->getDataRow('level', '*', '', '', '', 'level.pkey ASC');
		$selValMemori = $this->getDataRow('memori', '*', '', '', '', 'memori.name ASC');
		$firsDetailbMemori = $this->getDataRow('memori_detail', '*', array('memorikey' => $selValMemori[0]['pkey']), '', '', 'memori_detail.name ASC');

		$data['html']['firsDetailbMemori'] = $firsDetailbMemori;
		$data['html']['selValClass'] = $selValClass;
		$data['html']['selValLevel'] = $selValLevel;
		$data['html']['selValMemori'] = $selValMemori;
		$data['html']['title'] = 'Input Data ' . __FUNCTION__;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function classList($id = '')
	{
		$tableName = 'class';
		$className = 'class';
		$where = array();
		$arrWhereIn = '';
		if (!empty($id))
			$where = 'classkey=' . $id;
		if ($this->role != '1') {
			$detailRole = $this->getDataRow('account_detail', 'classkey', array('refkey'));
			$whereIn = array();
			foreach ($detailRole as $key => $value) {
				array_push($whereIn, $value['classkey']);
			}
			$arrWhereIn = array('pkey', $whereIn);
		}


		$dataList = $this->getDataRow($tableName, '*', $where, '', '', 'name ASC', $arrWhereIn);
		$data['html']['title'] = 'List Kelas';
		$data['html']['tableName'] = $tableName;
		$data['html']['dataList'] = $dataList;
		$data['html']['form'] = get_class($this) . '/' . $className;
		$data['url'] = 'admin/' . $className . 'List';
		$this->template($data);
	}

	public function class($id = '')
	{
		$tableName = 'class';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
		);
		$formDetail = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "nama wajib Di isi");

			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						//insert
						if (!empty(count($arrMsgErr)))
							break;

						$refkey = $this->insert($tableName, $this->dataForm($formData));
						// insert detail
						if (!empty(count($formDetail))) {
							$dataDetail = array();
							foreach ($_POST['detailKey'] as $item => $val) {
								foreach ($formDetail as $key => $value) {
									if (
										$value == 'refkey'
									)
										$_POST[$value][$item] = $refkey;
									$dataDetail[$key] = $_POST[$value][$item];
								}
								$this->insert($tableDetail, $dataDetail);
							}
						}
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						//insert
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						//update detail
						if (!empty($tableDetail)) {
							$oldDataDetail = $this->getDataRow($tableDetail, 'pkey', $detailRef . '=' . $_POST['pkey']);
							foreach ($_POST['detailKey'] as $i => $value) {
								if (!empty($_POST['detailKey'][$i])) {
									$status = false;
									$arrNumber = 0;
									foreach ($oldDataDetail as $key => $item) {

										if ($item['pkey'] == $_POST['detailKey'][$i]) {
											$status = true;
											$arrNumber = $key;
										}
									}
									if ($status)
										unset($oldDataDetail[$arrNumber]);
								}

								$dataDetail = array();
								foreach ($formDetail as $key => $value) {
									if ($value == 'refkey')
										$_POST[$value][$i] = $id;

									if (is_array($value) && $value[1] == 'number') {
										$_POST[$value[0]] = str_replace(",", "", $_POST[$value[0]]);
										$value = $value[0];
									}
									$dataDetail[$key] = $_POST[$value][$i];
								}
								if (empty($_POST['detailKey'][$i])) {
									echo 'insert';
									$this->insert($tableDetail, $dataDetail);
								} else {
									echo 'update';
									$this->update($tableDetail, $dataDetail, 'pkey=' . $_POST['detailKey'][$i]);
								}
							}
							//delete detail
							$deleteId = '';
							foreach ($oldDataDetail as $item) {
								if (empty($deleteId)) {
									$deleteId = $item['pkey'];
								} else {
									$deleteId .= ', ' . $item['pkey'];
								}
							}
							if (!empty($deleteId))
								$this->delete($tableDetail, 'pkey in(' . $deleteId . ')');
						}
						//update detail
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			foreach ($formData as $key => $value) {
				if (is_array($value))
					$value = $value[0];
				$_POST[$value] = $dataRow[$key];
			}
			$_POST['action'] = 'update';
		}

		if (!empty($tableDetail)) {
			$dataDetail = $this->getDataRow($tableDetail, '*', $detailRef . '=' . $id);
			$data['html']['dataDetail'] = $dataDetail;
		}
		$data['html']['title'] = 'Input Data ' . __FUNCTION__;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function memoriList()
	{
		$tableName = 'memori';
		$className = 'memori';

		$dataList = $this->getDataRow($tableName, '*', '', '', '', 'name ASC');
		$data['html']['title'] = 'List Hapalan';
		$data['html']['tableName'] = $tableName;
		$data['html']['dataList'] = $dataList;
		$data['html']['form'] = get_class($this) . '/' . $className;
		$data['url'] = 'admin/' . $className . 'List';
		$this->template($data);
	}

	public function memori($id = '')
	{
		//commit
		$tableName = 'memori';
		$tableDetail = 'memori_detail';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'classkey' => 'selClass',
		);
		$formDetail = array(
			'pkey' => 'detailKey',
			'name' => 'detailName',
			'memorikey' => 'refkey',
		);
		$detailRef = 'memorikey';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "nama wajib Di isi");

			foreach ($_POST['detailKey'] as $key => $value) {
				if (empty($_POST['detailKey'][$key]) && empty($_POST['detailName'][$key])) {
					unset($_POST['detailKey'][$key]);
				}
			}
			//validate form
			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);

			if (!empty($tableDetail)) {
				$dataDetail = $this->getDataRow($tableDetail, '*', $detailRef . '=' . $id);
				$data['html']['dataDetail'] = $dataDetail;
			}
		}
		$selValClass = $this->getDataRow('class', '*');

		$data['html']['selValClass'] = $selValClass;
		$data['html']['title'] = 'Input Data Hafalan';
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}


	public function levelList()
	{
		$tableName = 'level';
		$className = 'level';

		$dataList = $this->getDataRow($tableName, '*', '', '', '', 'name ASC');
		$data['html']['title'] = 'List Level';
		$data['html']['tableName'] = $tableName;
		$data['html']['dataList'] = $dataList;
		$data['html']['form'] = get_class($this) . '/' . $className;
		$data['url'] = 'admin/' . $className . 'List';
		$this->template($data);
	}

	public function level($id = '')
	{
		$tableName = 'level';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
		);
		$formDetail = array();
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "nama wajib Di isi");

			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						//insert
						if (!empty(count($arrMsgErr)))
							break;

						$refkey = $this->insert($tableName, $this->dataForm($formData));
						// insert detail
						if (!empty(count($formDetail))) {
							$dataDetail = array();
							foreach ($_POST['detailKey'] as $item => $val) {
								foreach ($formDetail as $key => $value) {
									if (
										$value == 'refkey'
									)
										$_POST[$value][$item] = $refkey;
									$dataDetail[$key] = $_POST[$value][$item];
								}
								$this->insert($tableDetail, $dataDetail);
							}
						}
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						//insert
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						//update detail
						if (!empty($tableDetail)) {
							$oldDataDetail = $this->getDataRow($tableDetail, 'pkey', $detailRef . '=' . $_POST['pkey']);
							foreach ($_POST['detailKey'] as $i => $value) {
								if (!empty($_POST['detailKey'][$i])) {
									$status = false;
									$arrNumber = 0;
									foreach ($oldDataDetail as $key => $item) {

										if ($item['pkey'] == $_POST['detailKey'][$i]) {
											$status = true;
											$arrNumber = $key;
										}
									}
									if ($status)
										unset($oldDataDetail[$arrNumber]);
								}

								$dataDetail = array();
								foreach ($formDetail as $key => $value) {
									if ($value == 'refkey')
										$_POST[$value][$i] = $id;

									if (is_array($value) && $value[1] == 'number') {
										$_POST[$value[0]] = str_replace(",", "", $_POST[$value[0]]);
										$value = $value[0];
									}
									$dataDetail[$key] = $_POST[$value][$i];
								}
								if (empty($_POST['detailKey'][$i])) {
									echo 'insert';
									$this->insert($tableDetail, $dataDetail);
								} else {
									echo 'update';
									$this->update($tableDetail, $dataDetail, 'pkey=' . $_POST['detailKey'][$i]);
								}
							}
							//delete detail
							$deleteId = '';
							foreach ($oldDataDetail as $item) {
								if (empty($deleteId)) {
									$deleteId = $item['pkey'];
								} else {
									$deleteId .= ', ' . $item['pkey'];
								}
							}
							if (!empty($deleteId))
								$this->delete($tableDetail, 'pkey in(' . $deleteId . ')');
						}
						//update detail
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}

		if (!empty($tableDetail)) {
			$dataDetail = $this->getDataRow($tableDetail, '*', $detailRef . '=' . $id);
			$data['html']['dataDetail'] = $dataDetail;
		}
		$data['html']['title'] = 'Input Data ' . __FUNCTION__;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function userList()
	{
		if ($this->session->userdata('role') != '1')
			redirect(base_url());
		$dataList = $this->getDataRow('account', '* ,', '', '', '', 'name ASC');
		$data['html']['title'] = 'List Account';
		$data['html']['dataList'] = $dataList;
		$data['html']['form'] = get_class($this) . '/user';
		$data['url'] = 'admin/userList';
		$this->template($data);
	}

	public function user($id = '')
	{
		$tableName = 'account';
		$tableDetail = 'account_detail';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = 'refkey';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'username' => 'username',
			'password' => array('password', 'md5'),
			'role' => 'role',
		);
		$formDetail = array(
			'refkey' => 'refkey',
			'classkey' => 'detailClassKey',
		);

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			unset($_POST['detailKey'][0]);
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Password wajib Di isi");

			if (empty($_POST['password']) && $_POST['action'] == 'add')
				array_push($arrMsgErr, "Password wajib Di isi");
			if ($_POST['role'] == '1')
				unset($_POST['detailKey']);



			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			foreach ($formData as $key => $value) {
				if (is_array($value))
					$value = $value[0];
				$_POST[$value] = $dataRow[$key];
			}
			if (!empty($tableDetail)) {
				$dataDetail = $this->getDataRow($tableDetail, '*', $detailRef . '=' . $id);
				$data['html']['dataDetail'] = $dataDetail;
			}
			$_POST['action'] = 'update';
			$_POST['password'] = '';
		}
		$selVal = $this->getDataRow('role', '*', '', '', '', 'name ASC');
		$selValClass = $this->getDataRow('class', '*', '', '', '', 'name ASC');

		$data['html']['selValClass'] = $selValClass;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['selVal'] = $selVal;
		$data['html']['title'] = 'Input Data ' . __FUNCTION__;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function ajax()
	{
		if (empty($_POST['action'])) {
			echo 'no action';
			die;
		}
		switch ($_POST['action']) {
			case 'deleteStudent':
				$detailKey = $this->getDataRow('students_detail', 'pkey', array('studentkey' => $_POST['pkey']));
				$this->delete('student_memori_detail', 'refkey in (' . $this->implode($detailKey, 'pkey') . ')');
				$this->delete('students_detail', array('studentkey' => $_POST['pkey']));
				$this->delete('students', 'pkey=' . $_POST['pkey']);
				break;
			case 'deleteClass':
				$this->delete('class', 'pkey=' . $_POST['pkey']);
				break;
			case 'delete':
				$this->delete($_POST['tbl'], 'pkey=' . $_POST['pkey']);
				break;
			case 'deleteUser':
				$this->delete('account', 'pkey=' . $_POST['pkey']);
				$this->delete('account_detail', array('refkey' => $_POST['pkey']));
				break;
			case 'getDataDetailMemori':
				echo json_encode($this->getDataRow('memori_detail', '*', array('memorikey' => $_POST['pkey'])));
				break;
			case 'getDetailStudent':
				$baseData = array();
				$dataMemori = $this->getDataRow('memori', '*', array('classkey' => $_POST['pkey']), '', '', 'name DESC');
				foreach ($dataMemori as $dataMemoriKey => $dataMemoriValue) {
					$detaMemoriDetail = $this->getDataRow('memori_detail', '*', array('memorikey' => $dataMemoriValue['pkey']), '', '', 'name DESC');
					array_push($baseData, array('detail' => $dataMemoriValue, 'subdetail' => $detaMemoriDetail));
				}
				echo json_encode($baseData);
				break;
			default:
				echo 'action is not in the list';
				break;
		}
	}

	public function exportStudent()
	{
		$join = array(
			array('students', 'students.pkey=student_detail.studentkey', 'left'),
			array('class', 'class.pkey=students.classkey', 'left'),
			array('memori', 'memori.pkey=student_detail.memorikey', 'left'),
			array('memori_detail', 'memori_detail.pkey=student_detail.detailmemorikey', 'left'),
			array('level', 'level.pkey=student_detail.levelkey', 'left'),
		);
		$select = '
			student_detail.*,
			students.nis as nis,
			students.name as name,
			students.nis as nis,
			class.name as classname,
			memori.name as memoriname,
			memori_detail.name as memoridetailname,
			level.name as levelname
		';

		$data = $this->getDataRow('student_detail', $select, '', '', $join);
		$heder = array('No', 'NIS', 'NAMA SISWA', 'KELAS', 'JENIS HAFALAN', 'NAMA HAFALAN', 'STATUS');
		$index = array('number', 'nis', 'name', 'classname', 'memoriname', 'memoridetailname', 'levelname');
		$this->export($heder, $index, $data, 'laporan siswa');
	}
	public function importStudent()
	{
		$baseUrl = '';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl));
			//validate form
			$arrMsgErr = array();
			if (empty($_FILES['file']['name']))
				array_push($arrMsgErr, 'File Import Wajib Di Isi');
			//validate form
			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			if (empty(count($arrMsgErr)))

				switch ($_POST['action']) {
					case 'import':

						$import = $this->import('file');
						unset($import[0]);
						foreach ($import as $importKey => $importValue) {
							$classkey = 0;
							$class = $this->getDataRow('class', 'pkey', array('name' => $importValue[2]));
							if (!empty(count($class)))
								$classkey = $class[0]['pkey'];
							$formData = array(
								'pkey' => 'pkey',
								'nis' => $importValue[0],
								'name' => $importValue[1],
								'birthday' => strtotime($importValue[4]),
								'birthdaynoted' => $importValue[3],
								'classkey' => $classkey,
								'father' => $importValue[5],
								'mother' => $importValue[6],
							);
							$this->insert('students', $formData);
						}
						redirect(base_url('Admin'));
						break;
				}
		}
		$data['html']['title'] = 'Import Data Siswa';
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/import';
		$this->template($data);
	}
	public function excampleImport()
	{
		$join = array(
			array('class', 'class.pkey=students.classkey', 'left'),
		);
		$data = $this->getDataRow('students', 'students.*,class.name as classname', '', array(1, 2), $join);
		$header = array('NIS', 'NAMA SISWA', 'KELAS', 'TEMPAT LAHIR', 'TANGGAL LAHIR', 'AYAH', 'UBU');
		$index = array('nis', 'name', 'classname', 'birthdaynoted', array('birthday', 'time'), 'father', 'mother');
		$this->export($header, $index, $data, 'Contoh Import');
	}
}
