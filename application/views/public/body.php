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
        <table class="table ">
            <?php
            $number = 1;
            foreach ($detailData as $Detailkey => $detailVal) { ?>
                <tr>
                    <td colspan="0"><b><?php echo $number++ . '. ' . $detailVal['memoriname'] ?></b></td>
                </tr>
                <?php foreach ($subditail as $subditailKey => $subditailValue) {
                    if ($subditailValue['refkey'] != $detailVal['pkey'])
                        continue; ?>
                    <tr>
                        <td style="width: 130px;">
                            <?php foreach ($selValMemoriDetail as $selValMemoriDetailKey => $selValMemoriDetailValue) {
                                if ($subditailValue['subdetailkey'] == $selValMemoriDetailValue['pkey'])
                                    echo $selValMemoriDetailValue['name'];
                            } ?>
                        </td>
                        <th style="width: 1px;">:</th>
                        <td>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <?php foreach ($selValLevel  as $selValLevelKey => $selValLevelValue) { ?>
                                            <div class="col-sm-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-inputs" <?php if ($selValLevelValue['pkey'] == $subditailValue['levelkey']) {
                                                                                                            echo 'checked';
                                                                                                        } else {
                                                                                                            echo 'disabled';
                                                                                                        } ?>>
                                                    <label class="form-check-label"><?php echo $selValLevelValue['name'] ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

            <?php } ?>
        </table>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('input:checkbox').click(function() {
            $(this).prop('checked', true);
        })
    });
</script>