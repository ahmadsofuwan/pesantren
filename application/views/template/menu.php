<?php
$role = $this->session->userdata('role');
?>
<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('admin'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Master Data
</div>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa fa-database" aria-hidden="true"></i>
        <span>Master Data</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Input:</h6>
            <a class="collapse-item" href="<?= base_url('Admin/studentList') ?>">Data Siswa</a>
            <a class="collapse-item" href="<?= base_url('Admin/classList') ?>">Data Kelas</a>
            <a class="collapse-item" href="<?= base_url('Admin/memoriList') ?>">Data Hafalan</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Data Nilai
</div>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datavalue" aria-expanded="true" aria-controls="datavalue">
        <i class="fa fa-database" aria-hidden="true"></i>
        <span>Data Nilai</span>
    </a>
    <div id="datavalue" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Input:</h6>
            <a class="collapse-item" href="<?= base_url('Admin/levelList') ?>">Input Tingkat Hafalan</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Export Import
</div>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#exportImport" aria-expanded="true" aria-controls="exportImport">
        <i class="fa fa-database" aria-hidden="true"></i>
        <span>Export Import</span>
    </a>
    <div id="exportImport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Input:</h6>
            <a class="collapse-item" href="<?= base_url('Admin/importStudent') ?>">Import Data Siswa</a>
            <a class="collapse-item" href="<?= base_url('Admin/exportStudent') ?>">Export Data Siswa</a>
        </div>
    </div>
</li>

<?php if ($role == '1') { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#galery" aria-expanded="true" aria-controls="galery">
            <i class="fas fa-users"></i>
            <span>User</span>
        </a>
        <div id="galery" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Input:</h6>
                <a class="collapse-item" href="<?= base_url('Admin/userList') ?>">User</a>
            </div>
        </div>
    </li>
<?php } ?>