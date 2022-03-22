<?php
$displayOnRole = '';
if (isset($_POST['role']) && $_POST['role'] == '1')
	$displayOnRole = 'style="display: none;"';

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
							<label for="name" class="col-sm-3 col-form-label">Name User</label>
							<div class="col-sm">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name">
							</div>
						</div>

						<div class="form-group row">
							<label for="username" class="col-sm-3 col-form-label">User Name</label>
							<div class="col-sm">
								<input type="text" class="form-control" id="username" name="username" placeholder="User Name">
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-sm-3 col-form-label">Password</label>
							<div class="col-sm">
								<input type="password" class="form-control" id="password" name="password" placeholder="*******">
							</div>
						</div>
						<div class="form-group row">
							<label for="bonus" class="col-sm-3 col-form-label">Role</label>
							<div class="col-sm">
								<select name="role" class="form-control">
									<?php foreach ($selVal as $key => $value) { ?>
										<option value="<?php echo $value['pkey'] ?>"><?php echo $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<!-- detaile -->
						<div class="form-group row detail-table" <?php echo $displayOnRole ?>>
							<div class="col-sm">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Kelas</th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<tr <?php echo $display ?>>
											<input type="hidden" name="detailKey[]">
											<td>
												<div class="form-group">
													<select name="detailClassKey[]" class="form-control">
														<?php foreach ($selValClass as $selValClassKey => $selValClassValue) { ?>
															<option value="<?php echo $selValClassValue['pkey'] ?>"><?php echo $selValClassValue['name'] ?></option>
														<?php } ?>
													</select>
												</div>
											</td>
											<td><b class="text-danger btn closeDetail">X</b></td>
										</tr>
										<?php
										//jika update/edit
										if ($action == 'update') {
										?>
											<?php foreach ($dataDetail as $dataDetailKey => $dataDetailValue) { ?>
												<tr>
													<input type="hidden" name="detailKey[]" value="<?php echo $dataDetailValue['pkey'] ?>">
													<td>
														<div class="form-group">
															<select name="detailClassKey[]" class="form-control">
																<?php foreach ($selValClass as $selValClassKey => $selValClassValue) { ?>
																	<option value="<?php echo $selValClassValue['pkey'] ?>" <?php if ($dataDetailValue['classkey'] == $selValClassValue['pkey']) echo 'selected' ?>><?php echo $selValClassValue['name'] ?></option>
																<?php } ?>
															</select>
														</div>
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
		$('[name="role"]').change(function() {
			var value = $(this).val()
			$('.detail-table').show();
			if (value == '1')
				$('.detail-table').hide();
		})
	});
</script>