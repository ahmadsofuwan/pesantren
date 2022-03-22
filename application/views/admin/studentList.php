<div class="row py-2">
    <div class="col-sm-1">
        <a href="<?php echo base_url($form) ?>" id="add"><i class="fa fa-plus fa-2x"></i></a>
    </div>
    <div class="col-sm-2">
        <select name="class" class=" form-control" id="class" onchange="location = this.value;">
            <option value="<?php echo base_url('Admin/studentList/') ?>" <?php if (empty($classKey)) echo 'selected' ?>>Semua Kelas</option>
            <?php foreach ($selValClass as $key => $value) { ?>
                <option value="<?php echo base_url('Admin/studentList/' . $value['pkey']) ?>" <?php if ($classKey == $value['pkey']) echo 'selected' ?>><?php echo $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<table class="table table-responsive-sm" id="dataTable">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col">NIS</th>
            <th scope="col">Nama</th>
            <th scope="col">Kelas</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($dataList as $value) { ?>
            <tr>
                <th scope="row"><?php echo $i++ ?></th>
                <td><?php echo $value['nis'] ?></td>
                <td><?php echo $value['name'] ?></td>
                <td class="align-right"><?php echo $value['classname']  ?></td>
                <td style="width: 140px;text-align: center;">
                    <a href="<?php echo base_url($form . '/' . $value['pkey']) ?>" class="btn btn-primary">Edit</a>
                    <?php if ($role == 1) { ?>
                        <button class="btn btn-danger" name="delete" value="<?php echo $value['pkey'] ?>">Delete</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('tbody').find('[name=delete]').click(function() {
        var pkey = $(this).val();
        var obj = $(this);
        Swal.fire({
            title: 'yakin?',
            text: "Data Akan Di Hapus Secara Permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        url: '<?= base_url('Admin/ajax') ?>',
                        type: 'POST',
                        data: {
                            action: 'deleteStudent',
                            pkey: pkey,
                        },
                    })
                    .done(function(a) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Berhasil Di Deleted',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        obj.closest('tr').remove();
                        $.each($('tbody').find('tr > th'), function(index, elemt) {
                            $(elemt).html(index + 1)
                        });
                    })
                    .fail(function(a) {
                        console.log("error");
                        console.log(a);
                    })



            }
        })
    })
</script>