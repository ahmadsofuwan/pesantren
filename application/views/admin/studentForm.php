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
									<option selected="true" disabled="disabled">-Pilih Kelas-</option>
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

						<div id="detail">
							<?php if ($action == 'update') { ?>
								<div class="form-group row">
									<div class="col-sm">
										<table class="table table-responsive-sm">
											<thead>
												<tr>
													<th scope="col" colspan="2">Jenis Hapalan</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($dataMemori as $dataMemoriKey => $dataMemoriValue) { ?>
													<tr>
														<td colspan="2"><b><?php echo $dataMemoriValue['name'] ?></b></td>
													</tr>
													<?php foreach ($dataDetail as $dataDetailKey => $dataDetailValue) { ?>
														<?php if ($dataDetailValue['memorikey'] != $dataMemoriValue['pkey']) continue ?>
														<tr>
															<td><?php echo $dataDetailValue['memoridetailname'] ?></td>
															<td>
																<div class="row">
																	<input type="hidden" name="<?php echo 'level_' . $dataMemoriValue['pkey'] . '_' . $dataDetailValue['detailmemorikey'] ?>">
																	<?php foreach ($level as $levelKey => $levelValue) { ?>
																		<div class="col-sm-3">
																			<div class="form-check">
																				<input type="checkbox" class="form-check-input" value="<?php echo $levelValue['pkey'] ?>" <?php if ($levelValue['pkey'] == $dataDetailValue['levelkey']) echo 'checked' ?>>
																				<label class="form-check-label"><?php echo $levelValue['name'] ?></label>
																			</div>
																		</div>
																	<?php } ?>
																</div>
															</td>
														</tr>
													<?php } ?>

												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							<?php } ?>
						</div>



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
					var elemetDetail = '<div class="form-group row">';
					elemetDetail += '<div class="col-sm">';
					elemetDetail += '<table class="table table-responsive-sm">';
					elemetDetail += '<thead>';
					elemetDetail += '<tr>';
					elemetDetail += '<th scope="col" colspan="2">Jenis Hapalan</th>';
					elemetDetail += '</tr>';
					elemetDetail += '</thead>';
					elemetDetail += '<tbody>';
					$.each(data, function(dataIndex, dataValue) {
						elemetDetail += '<tr><th>' + dataValue.detail.name + '<th><input type="hidden"  name="detailKey[]"></tr>';
						elemetDetail += '<input type="hidden" name="detailMemori[]" value="' + dataValue.detail.pkey + '">';
						$.each(dataValue.subdetail, function(subdetailIndex, subdetailValue) {
							elemetDetail += '<tr>';
							elemetDetail += '<td colspan="2">' + subdetailValue.name + '</td>';
							elemetDetail += '<td>';
							elemetDetail += '<div class="row">';
							elemetDetail += '<input type="hidden" name="level_' + dataValue.detail.pkey + '_' + subdetailValue.pkey + '">';
							$.each(level, function(levelIndex, levelValue) {
								elemetDetail += '<div class="col-sm-3">';
								elemetDetail += '<div class="form-check">';
								elemetDetail += '<input type="checkbox" class="form-check-input" value="' + levelValue.pkey + '">';
								elemetDetail += '<label class="form-check-label">' + levelValue.name + '</label>';
								elemetDetail += '</div>';
								elemetDetail += '</div>';
							});
							elemetDetail += '</div>';
							elemetDetail += '</input>';
							elemetDetail += '</tr>';
						});
					});
					elemetDetail += '<tbody>';
					elemetDetail += '</table>';
					elemetDetail += '</div>';
					elemetDetail += '</div>';
					$('#detail').html(elemetDetail);
					checkbox()
				})
				.fail(function() {
					console.log('error');
				})
		})

		checkbox()

		var obj = $('#detail');
		var checkboxCheked = obj.find('input:checkbox:checked')
		$.each(checkboxCheked, function(index) {
			$(this).click()
		});



		function checkbox() {
			$('input:checkbox').click(function() {
				var obj = $(this);
				var valLevel = $(obj).val();
				var container = obj.closest('.row');
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