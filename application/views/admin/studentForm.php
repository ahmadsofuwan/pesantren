<?php
$action = 'add';
$display = '';
if (isset($_POST['action']))
	$action = $_POST['action'];
if ($action == 'update')
	$display = 'style="display: none;"'
?>
<div class="row justify-content-center">
	<div class="col-lg-10">
		<div class="row">
			<div class="col-lg">
				<div class="p-5">
					<?php echo $err ?>
					<h3 class="text-center"><b><?php echo strtoupper($title) ?></b></h3>
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="pkey" value="">
						<input type="hidden" name="action" value="<?php echo $action ?>">

						<div class="form-group row">
							<label for="nis" class="col-sm-3 col-form-label">NIS</label>
							<div class="col-sm">
								<input type="text" class="form-control" id="nis" name="nis" placeholder="NIS">
							</div>
						</div>

						<div class="form-group row">
							<label for="name" class="col-sm-3 col-form-label">Nama</label>
							<div class="col-sm">
								<input type="text" class="form-control" id="name" name="name" placeholder="Nama">
							</div>
						</div>

						<div class="form-group row">
							<label for="birthday" class="col-sm-3 col-form-label">Tempat / Tgl. Lahir</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="birthdaynoted" name="birthdayNoted" placeholder="Tempat Lahir">
							</div>
							<div class="col-sm-5">
								<input type="date" class="form-control" id="birthday" name="birthday" placeholder="Nama">
							</div>
						</div>

						<div class="form-group row">
							<label for="class" class="col-sm-3 col-form-label">Kelas</label>
							<div class="col-sm">
								<select name="class" class="form-control">
									<?php foreach ($selValClass as $key => $value) { ?>
										<option value="<?php echo $value['pkey'] ?>"><?php echo $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="family" class="col-sm-3 col-form-label">Orang Tua</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="father" name="father" placeholder="Ayah">
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="mother" name="mother" placeholder="Ibu">
							</div>
						</div>

						<div id="detail"></div>

						<!-- detaile -->
						<div class="form-group row">
							<div class="col-sm">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Jenis Hapalan</th>
											<th scope="col"></th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<tr <?php echo $display ?>>
											<input type="hidden" name="detailKey[]">
											<td>
												<select class="form-control" name="detailMemori[]">
													<?php foreach ($selValMemori as $val) { ?>
														<option value="<?php echo $val['pkey'] ?>"><?php echo $val['name'] ?></option>
													<?php } ?>
												</select>
											</td>
											<td>
												<div class="row head">
													<div class="col-sm-3" style="min-width: 150px;">Nama Hafalan</div>
													<div class="col-sm-3 text-center" style="min-width: 150px">Level Hafalan</div>
													<div class="col-sm"></div>
												</div>
												<hr>
												<?php foreach ($firsDetailbMemori as $item) { ?>
													<div class="row detail">
														<div class="col-sm-3"><?php echo $item['name'] ?></div>
														<div class="col-sm">
															<div class="d-flex flex-row">
																<input type="hidden" name="level_<?php echo $selValMemori[0]['pkey'] ?>_<?php echo $item['pkey'] ?>[]">
																<?php foreach ($selValLevel as $key => $value) { ?>
																	<div class="p-2">
																		<div class="form-check">
																			<input type="checkbox" class="form-check-input" value="<?php echo $value['pkey'] ?>">
																			<label class="form-check-label"><?php echo $value['name'] ?></label>
																		</div>
																	</div>
																<?php } ?>
															</div>
														</div>
													</div>
												<?php } ?>
											</td>
											<td><b class="text-danger btn closeDetail">X</b></td>
										</tr>
										<?php
										//jika update/edit
										if ($action == 'update') {
										?>
											<?php foreach ($dataDetail as $key => $valuee) { ?>
												<tr>
													<input type="hidden" name="detailKey[]" value="<?php echo $valuee['pkey'] ?>">
													<td>
														<select class="form-control" name="detailMemori[]">
															<?php foreach ($selValMemori as $val) { ?>
																<option value="<?php echo $val['pkey'] ?>" <?php if ($val['pkey'] == $valuee['memorikey']) echo 'selected' ?>><?php echo $val['name'] ?></option>
															<?php } ?>
														</select>
													</td>
													<td>
														<div class="row head">
															<div class="col-sm-3" style="min-width: 150px;">Nama Hafalan</div>
															<div class="col-sm-3" style="min-width: 150px;">Level Hafalan</div>
															<div class="col-sm"></div>
														</div>
														<hr>
														<?php foreach ($subDetailMemori[$key] as $item) { ?>
															<div class="row detail">
																<div class="col-sm-3"><?php echo $item['name'] ?></div>
																<div class="col-sm">
																	<div class="d-flex flex-row">
																		<?php
																		$levelValue = '';
																		for ($i = 0; $i < count($subDetail[$key]); $i++) {
																			if ($subDetail[$key][$i]['subdetailkey'] == $item['pkey'])
																				$levelValue = $subDetail[$key][$i]['levelkey'];
																		}
																		?>
																		<input type="hidden" name="level_<?php echo $item['memorikey'] ?>_<?php echo $item['pkey'] ?>[]" value="<?php echo $levelValue ?>">
																		<?php foreach ($selValLevel as $keys => $value) { ?>
																			<div class="p-2">
																				<div class="form-check">
																					<input type="checkbox" class="form-check-input" value="<?php echo $value['pkey'] ?>" <?php
																																											for ($i = 0; $i < count($subDetail[$key]); $i++) {
																																												if ($subDetail[$key][$i]['subdetailkey'] == $item['pkey']) {
																																													if ($subDetail[$key][$i]['levelkey'] == $value['pkey'])
																																														echo 'checked';
																																												}
																																											}
																																											?>>
																					<label class="form-check-label"><?php echo $value['name']  ?></label>
																				</div>
																			</div>
																		<?php } ?>
																	</div>
																</div>
															</div>
														<?php } ?>
													</td>
													<td><b class="text-danger btn closeDetail">X</b></td>
												</tr>
											<?php } ?>
										<?php } //jika update/edit
										?>
									</tbody>
									<tfoot>
										<tr>
											<td><button type="button" class="btn btn-primary" name="addDetail">Tambah</button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<!-- detaile -->



						<div class="form-group row mt-5">
							<div class="col-sm">
								<button type="submit" class="btn btn-primary btn-block">Submit</button>
							</div>
							<div class="col-sm">
								<a href="<?php echo base_url($baseUrl . 'List') ?>" class="btn btn-warning btn-block">Cancel</a>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		var level = JSON.parse('<?php echo json_encode($selValLevel) ?>');
		$('[name="detailMemori[]"]').change(function() {
			var obj = this;
			var value = $(obj).val();
			var tr = obj.closest('tr');
			var tdTarget = $(tr).find('td')[1];
			var divTarget = $(tdTarget).find('div.row.detail');
			var hrTarget = $(tdTarget).find('hr');

			$.ajax({
					url: '<?php echo base_url('Admin/ajax') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'getDataDetailMemori',
						pkey: value,
					},
				})
				.done(function(data) {
					$(divTarget).remove();
					for (let i = data.length - 1; i >= 0; i--) {
						var element = '<div class="row detail">\n';
						element += '<div class="col-sm-3">' + data[i]['name'] + '</div>\n';
						element += '<div class="col-sm">\n';
						element += '<div class="d-flex flex-row">\n';
						element += '<input type="hidden" name="level_' + value + '_' + data[i].pkey + '[]">\n';
						$.each(level, function(key, val) {
							element += '<div class="p-2">\n';
							element += '<div class="form-check">\n';
							element += '<input type="checkbox" class="form-check-input" value="' + val.pkey + '">\n';
							element += '<label class="form-check-label">' + val.name + '</label>\n';
							element += '</div>\n';
							element += '</div>\n';
						});
						element += '</div>\n';
						element += '</div>\n';
						element += '</div>\n';
						element += '</div>\n';
						$(hrTarget).after(element)
					}
					checkbox();
				})
				.fail(function() {
					console.log('error');
				})
		})
		$('[name="class"]').change(function() {
			var obj = this;
			var value = $(obj).val();

			$.ajax({
					url: '<?php echo base_url('Admin/ajax') ?>',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'getDetailStudent',
						pkey: value,
					},
				})
				.done(function(data) {
					console.log(data)
					var elemetDetail = '<div class="form-group row">';
					elemetDetail += '<div class="col-sm">';

					$.each(data, function(dataIndex, dataValue) {

						console.log(dataValue.detail)
						console.log(dataValue.subdetail)

					});

					elemetDetail += '</div>';
					elemetDetail += '</div>';
					$('#detail').html(elemetDetail);
				})
				.fail(function() {
					console.log('error');
				})
		})

		checkbox()

		function checkbox() {
			$('input:checkbox').click(function() {
				console.log('jalan');
				var obj = $(this);
				var valLevel = $(obj).val();
				var container = obj.closest('.d-flex.flex-row');
				var arrCheckBox = $(container).find('input:checkbox');
				var inputHidden = $(container).find('input[type=hidden]');
				$(inputHidden).val(valLevel);
				$.each(arrCheckBox, function(key, value) {
					$(value).prop('checked', false);
				})
				$(obj).prop('checked', true);
			})

		}
	});
</script>