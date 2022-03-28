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
            <thead>
                <tr>
                    <th scope="col" colspan="2">Jenis Hapalan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($memori as $memoriKey => $memoriValue) { ?>
                    <tr>
                        <td colspan="2"><?php echo $no++ . '. ' . $memoriValue['name'] ?></td>
                    </tr>
                    <?php foreach ($detailMemori as $detailMemoriKey => $detailMemoriValue) { ?>
                        <?php if ($memoriValue['pkey'] !== $detailMemoriValue['memorikey']) continue; ?>
                        <tr>
                            <td colspan="2"><?php echo $detailMemoriValue['name'] ?></td>
                            <td>
                                <div class="row">
                                    <input type="hidden" name="<?php echo 'level_' . $memoriValue['pkey'] . '_' . $detailMemoriValue['pkey'] ?>">
                                    <?php foreach ($level as $levelKey => $levelValue) { ?>
                                        <?php
                                        $status = 'disabled';
                                        foreach ($studentDetail as $studentDetailKey => $studentDetailValue) {
                                            if ($studentDetailValue['memorikey'] == $memoriValue['pkey'] && $studentDetailValue['detailmemorikey'] == $detailMemoriValue['pkey'] && $studentDetailValue['levelkey'] == $levelValue['pkey'])
                                                $status = 'checked';
                                        }
                                        ?>
                                        <div class="col-sm-3">
                                            <div class="form-check">
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
            </tbody>
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