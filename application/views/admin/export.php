<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php //print_r($data) 
?>

<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Hafalan</th>
                <th>Nama Hafalan</th>
                <th>Status Hafalan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $value['nis'] ?></td>
                    <td><?php echo $value['name'] ?></td>
                    <td><?php echo $value['classname'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>