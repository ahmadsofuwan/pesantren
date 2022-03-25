<div class="container py-5">
    <img style="width: 100px;" src="<?php echo base_url('uploads/' . $dataCompany[0]['logo']) ?>" class="rounded mx-auto d-block" alt="Responsive image">
    <div class="row py-3">
        <div class="col-sm-12">
            <h5 class="text-danger text-center"><b>SISTEM INFORMASI HAFALAN SISWA MI AL-IKHLAS</b></h5>
        </div>
        <div class="col-sm-12">
            <div class="alert alert-danger text-center" role="alert">DETAIL STATUS HAFALAN</div>
        </div>
        <div class="col-sm-12 text-center text-white bg-success">IDENTITAS PESERTA DIDIK</div>
        <div class="col-sm-12">
            <table class="table ">
                <tr>
                    <th style="width: 161px;">Nama Siswa/Siswi</th>
                    <th style="width: 1px;">:</th>
                    <td><?php echo $studentData[0]['name'] ?></td>
                </tr>
                <tr>
                    <th style="width: 161px;">Nis</th>
                    <th style="width: 1px;">:</th>
                    <td><?php echo $studentData[0]['nis'] ?></td>
                </tr>
                <tr>
                    <th style="width: 161px;">Tempat / Tgl Lahir</th>
                    <th style="width: 1px;">:</th>
                    <td><?php echo $studentData[0]['birthdaynoted'] . ' ' . date("d / m / Y", $studentData[0]['birthday']) ?></td>
                </tr>
                <tr>
                    <th style="width: 161px;">Kelas</th>
                    <th style="width: 1px;">:</th>
                    <td><?php echo $studentData[0]['classname'] ?></td>
                </tr>
                <tr>
                    <th style="width: 161px;">Nama Orang Tua</th>
                    <th style="width: 1px;">:</th>
                    <td><?php echo $studentData[0]['father'] . ' / ' . $studentData[0]['mother'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12 text-center text-white bg-success">STATUS HAFALAN</div>
        <table class="table table-responsive-sm">
            <?php $number = 1 ?>
            <?php foreach ($dataMemori as $dataMemoriKey => $dataMemoriValue) { ?>
                <tr>
                    <th colspan="2"><b><?php echo $number++ . '. ' . $dataMemoriValue['name'] ?></b></th>
                </tr>
                <?php foreach ($dataDetail as $dataDetailKey => $dataDetailValue) { ?>
                    <?php if ($dataDetailValue['memorikey'] != $dataMemoriValue['pkey']) continue ?>
                    <tr>
                        <td><?php echo $dataDetailValue['memoridetailname'] ?></td>
                        <td>
                            <div class="row">
                                <?php foreach ($level as $levelKey => $levelValue) { ?>
                                    <?php $status = 'disabled';
                                    if ($levelValue['pkey'] == $dataDetailValue['levelkey']) $status = 'checked' ?>

                                    <div class="col-sm-3">
                                        <div class="form-check" style="width: auto;">
                                            <input type="checkbox" class="form-check-input" value="<?php echo $levelValue['pkey'] ?>" <?php echo $status ?>>
                                            <label class="form-check-label"><?php echo $levelValue['name'] ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <button class="btn btn-success btn-block no-print" onclick="window.print()">CETAK</button>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('input:checkbox').click(function() {
            $(this).prop('checked', true);
        })
    });
</script>
<style type="text/css" media="print">
    .no-print {
        display: none;
    }
</style>