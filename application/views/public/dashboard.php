<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('asset/sb_admin2/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('asset/sb_admin2/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<style>
    body {
        background-image: url('<?php echo base_url('/uploads/BackgroundPublic.jpeg') ?>');
        background-size: cover;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: green;">
        <a class="navbar-brand text-white" href="<?php echo base_url() ?>"><i class="fas fa-home"> Sistem Hafalan Siswa</i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarSupportedContent">
            <div class="my-2 my-lg-0 p-2">
                <a href="<?php echo base_url('Admin/') ?>" class="btn text-white"><i class="fas fa-sign-in-alt"></i> Login</a>
            </div>
        </div>
    </nav>



    <div class="container my-5">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-4">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-1">
                                    <div class="text-center">
                                        <img src="<?PHP echo base_url('uploads/logo.jpeg') ?>" class="rounded mx-auto d-block" alt="Logo" style="max-width: 100px;">
                                        <h5 class="text-danger"><b>SISTEM INFORMASI</b></h5>
                                        <h5 class="text-danger"> <b>HAFALAN SISWA MI AL-IKHLAS</b></h5>
                                        <div class="alert alert-success" role="alert">
                                            <span><b>SILAHKAN CEK NILAI HAFALAN DENGAN MEMASUKAN NIS SISWA</b></span>
                                        </div>
                                        <form class="user" method="POST" action="<?= base_url('Content/checkdata') ?>">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="nis" aria-describedby="emailHelp" placeholder="Masukan Nik...">
                                            </div>
                                            <button class="btn btn-danger btn-user btn-block" type="submit">PRIKSA DATA</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <footer class="text-white" style="background-color: green; height: 50px;min-width:100px;">
        <div class="container">
            <div class="copyright text-center">
                <span>
                    <div class="row text-center">
                        <div class="col-sm-12">MI AL-IKHLAS</div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-12">Sistem Hafalan Siswa &copy; 2022</div>
                    </div>
                </span>
            </div>
        </div>
    </footer>
</body>


</html>
<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('asset/sb_admin2/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('asset/sb_admin2/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('asset/sb_admin2/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('asset/sb_admin2/'); ?>js/sb-admin-2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var err = "<?php echo $_SESSION['arrErrMsg'] ?>";
    if (err != "")
        Swal.fire(err);
</script>
<?php unset($_SESSION['arrErrMsg']) ?>