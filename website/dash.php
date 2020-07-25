<?php
session_start();
error_reporting(0);
include 'config.php';
if(!$_SESSION['status']){
  header("location:index.php");
  exit;
}
$date=date("Y-m-d H:i:s");
 ?>
 <!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <title>
       <?php
       if(!$_GET){
         echo "Admin | Catatan - Transaksi";
       }elseif ($_GET['menu']=="tambah") {
         echo "Admin | Catatan - Tambah barang";
       }elseif ($_GET['menu']=="lihat_barang") {
         echo "Admin | Catatan - Lihat barang";
       }elseif ($_GET['menu']=="edit_barangnya") {
         echo "Admin | Catatan - Perbarui barang";
       }elseif ($_GET['menu']=="delete_barang") {
         echo "Admin | Catatan - Hapus barang";
       }elseif ($_GET['menu']=="lihat_transaksi") {
         echo "Admin | Catatan - Lihat transaksi";
       }elseif ($_GET['menu']=="lihat") {
         echo "Admin | Catatan - Lihat total semuanya";
       }elseif ($_GET['menu']=="set_user") {
         echo "Admin | Catatan - Setting user";
       }else {
         echo "404 Pages Not Found";
       }
        ?>
     </title>
     <style>
       .nav-link:hover{
         text-decoration: underline;
       }
       .bordere{
         width: 50px;
         border-top:3px solid;
       }
     </style>
   </head>
   <body>
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <div class="container">
         <a class="navbar-brand" href="dash.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill-rule="evenodd" d="M11.03 2.59a1.5 1.5 0 011.94 0l7.5 6.363a1.5 1.5 0 01.53 1.144V19.5a1.5 1.5 0 01-1.5 1.5h-5.75a.75.75 0 01-.75-.75V14h-2v6.25a.75.75 0 01-.75.75H4.5A1.5 1.5 0 013 19.5v-9.403c0-.44.194-.859.53-1.144l7.5-6.363zM12 3.734l-7.5 6.363V19.5h5v-6.25a.75.75 0 01.75-.75h3.5a.75.75 0 01.75.75v6.25h5v-9.403L12 3.734z"></path></svg></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNavDropdown">
           <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link" href="dash.php">[ Transaksi ]</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?menu=tambah">[ Tambah barang ]</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?menu=lihat_barang">[ Lihat barang ]</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?menu=lihat_transaksi">[ Lihat transaksi ]</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?menu=set_user">[ Set user ]</a>
             </li>
             <li class="nav-item">
               <a href="?menu=logout" class="nav-link">
                 [ Logout ]
               </a>
             </li>
           </ul>
         </div>
      </div>
     </nav>
     <?php
     if($_GET['menu']=="logout"){
       session_destroy();
       header("location:index.php");
     }
      ?>
      <br>
      <div class="container">
        <?php
        if(!$_GET){
        $q_dataBarang=mysqli_query($conn,"SELECT * FROM barang");
        ?>
        <h1>Transaksi</h1>
        <form class="form-group mt-3" action="" method="post">
          <label for="nama"><b>Nama barang</b></label>
          <select class="form-control" name="barang" required>
            <option value="" id="nama">Nama barang</option>
            <?php
            while ($var=mysqli_fetch_array($q_dataBarang)) {
              ?>
              <option value="<?php echo $var['nama_barang']."-".$var['harga_awal']."-".$var['harga_akhir']; ?>"><?php echo $var['nama_barang']; ?></option>
              <?php
            }
             ?>
          </select>
          <br>
          <label for="jumlah"> <b>Jumlah</b> </label>
          <input type="number" name="jumlah" value="" id="jumlah" class="form-control" placeholder="jumlah.." min="1" required>
          <br>
          <input type="submit" name="submit" value="Tambah transaksi" class="btn btn-primary">
        </form>
        <?php
        if($_POST){
          $nama=htmlentities(mysqli_real_escape_string($conn,$_POST['barang']));
          $jumlah=htmlentities(mysqli_real_escape_string($conn,$_POST['jumlah']));
          $pisahin=explode("-",$nama);
          $total_hargaTanpaLaba=$pisahin[1]*$jumlah;
          $a=$pisahin[2]-$pisahin[1];
          $total_hargaLaba=$a*$jumlah;
          $total_hargaSemua=$pisahin[2]*$jumlah;
          if(mysqli_query($conn,"INSERT INTO transaksi(nama,jumlah,total_hargaLaba,total_hargaTanpaLaba,total_hargaSemua,tanggal) values('$nama','$jumlah','$total_hargaLaba','$total_hargaTanpaLaba','$total_hargaSemua','$date')")){
            echo "<div class='alert alert-success'>Data berhasil ditambahkan!</div>";
          }else{
            echo "<div class='alert alert-danger'>Cek config!</div>";
          }
        }
         ?>
      <?php
      }elseif($_GET['menu']=="tambah"){
      ?>
        <h1>Tambah data barang</h1>
        <form class="form-group mt-3" action="?menu=tambah" method="post">
          <label for="Nama"><b>Nama barang</b></label>
          <input type="text" name="nama" value="" placeholder="Nama barang..." class="form-control" id="Nama">
          <br>
          <label for="hargaAwal"><b>Harga sebelum ada laba</b></label>
          <input type="number" name="harga_awal" value="" placeholder="Harga sebelum ada laba(9000)" class="form-control" min="1" id="hargaAwal">
          <br>
          <label for="hargaAkhir"><b>Harga sesudah ada laba</b></label>
          <input type="number" name="harga_akhir" value="" placeholder="Harga sesudah ada laba(10000)" id="hargaAkhir" class="form-control" min="1">
          <br>
          <input type="submit" name="submit" value="Tambah" class="btn btn-primary">
        </form>
      <?php
        if($_POST){
          $nama=htmlentities(mysqli_real_escape_string($conn,$_POST['nama']));
          $harga_awal=htmlentities(mysqli_real_escape_string($conn,$_POST['harga_awal']));
          $harga_akhir=htmlentities(mysqli_real_escape_string($conn,$_POST['harga_akhir']));
          $q="INSERT INTO barang(nama_barang,harga_awal,harga_akhir,tanggal) values('$nama','$harga_awal','$harga_akhir','$date')";
          if(mysqli_query($conn,$q)){
            echo "<div class='alert alert-success'>Sukses tambah data!</div>";
          }else {
            echo "<div class='alert alert-danger'>Cek config!</div>";
          }
        }
      }elseif ($_GET['menu']=="lihat_barang") {
        $q=mysqli_query($conn,"SELECT * FROM barang order by id DESC");
      ?>
      <h1>Lihat barang</h1>
      <pre>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Barang</th>
              <th>Harga awal</th>
              <th>Harga akhir</th>
              <th>Settings</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($var=mysqli_fetch_array($q)) {
            ?>
            <tr>
              <td><?php echo $var['nama_barang'] ?></td>
              <td><?php echo $var['harga_awal'] ?></td>
              <td><?php echo $var['harga_akhir'] ?></td>
              <td><a href="?menu=edit_barangnya&id=<?php echo $var['id'] ?>" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M5.433 2.304A4.494 4.494 0 003.5 6c0 1.598.832 3.002 2.09 3.802.518.328.929.923.902 1.64v.008l-.164 3.337a.75.75 0 11-1.498-.073l.163-3.33c.002-.085-.05-.216-.207-.316A5.996 5.996 0 012 6a5.994 5.994 0 012.567-4.92 1.482 1.482 0 011.673-.04c.462.296.76.827.76 1.423v2.82c0 .082.041.16.11.206l.75.51a.25.25 0 00.28 0l.75-.51A.25.25 0 009 5.282V2.463c0-.596.298-1.127.76-1.423a1.482 1.482 0 011.673.04A5.994 5.994 0 0114 6a5.996 5.996 0 01-2.786 5.068c-.157.1-.209.23-.207.315l.163 3.33a.75.75 0 11-1.498.074l-.164-3.345c-.027-.717.384-1.312.902-1.64A4.496 4.496 0 0012.5 6a4.494 4.494 0 00-1.933-3.696c-.024.017-.067.067-.067.16v2.818a1.75 1.75 0 01-.767 1.448l-.75.51a1.75 1.75 0 01-1.966 0l-.75-.51A1.75 1.75 0 015.5 5.282V2.463c0-.092-.043-.142-.067-.159zm.01-.005z"></path></svg>Edit</a> <a href="?menu=delete_barang&id=<?php echo $var['id']; ?>" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M6.5 1.75a.25.25 0 01.25-.25h2.5a.25.25 0 01.25.25V3h-3V1.75zm4.5 0V3h2.25a.75.75 0 010 1.5H2.75a.75.75 0 010-1.5H5V1.75C5 .784 5.784 0 6.75 0h2.5C10.216 0 11 .784 11 1.75zM4.496 6.675a.75.75 0 10-1.492.15l.66 6.6A1.75 1.75 0 005.405 15h5.19c.9 0 1.652-.681 1.741-1.576l.66-6.6a.75.75 0 00-1.492-.149l-.66 6.6a.25.25 0 01-.249.225h-5.19a.25.25 0 01-.249-.225l-.66-6.6z"></path></svg>Delete</a></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </pre>
      <?php
    }elseif ($_GET['menu']=="edit_barangnya") {
      if($_GET['id']){
        $id=mysqli_real_escape_string($conn,$_GET['id']);
        $cocokID=mysqli_query($conn,"SELECT * FROM barang where id='$id'");
        $q_tampil=mysqli_fetch_array($cocokID);
        if(mysqli_num_rows($cocokID)>0){
          ?>
          <h1>Perbarui barang</h1>
          <br>
          <form class="form-group" action="?menu=edit_barangnya&id=<?php echo $_GET['id'] ?>" method="post">
            <label for="nama_barang"> <b>Nama barang</b> </label>
            <input type="text" name="nama_barang" value="<?php echo $q_tampil['nama_barang'] ?>" class="form-control" id="nama_barang" placeholder="Nama barang...">
            <br>
            <label for="harga_awal"> <b>Harga sebelum ada laba</b> </label>
            <input type="number" name="harga_awal" value="<?php echo $q_tampil['harga_awal'] ?>" class="form-control" id="harga_awal" placeholder="Harga sebelum ada laba(9000)" min="1">
            <br>
            <label for="harga_akhir"><b>Harga sesudah ada laba</b></label>
            <input type="number" name="harga_akhir" value="<?php echo $q_tampil['harga_akhir'] ?>" class="form-control" id="harga_akhir" placeholder="Harga sebelum ada laba(10000)" min="1">
            <br>
            <input type="submit" name="submit" value="Perbarui" class="btn btn-primary">
          </form>
          <?php
          if ($_POST) {
            $nama=htmlentities(mysqli_real_escape_string($conn,$_POST['nama_barang']));
            $harga_awal=htmlentities(mysqli_real_escape_string($conn,$_POST['harga_awal']));
            $harga_akhir=htmlentities(mysqli_real_escape_string($conn,$_POST['harga_akhir']));
            $q_edit="UPDATE barang SET nama_barang='$nama',harga_awal='$harga_awal',harga_akhir='$harga_akhir',tanggal='$date' where id='$id'";
            if(mysqli_query($conn,$q_edit)){
              echo "<div class='alert alert-success'>Perbarui data sukses!</div>";
            }else{
              echo "<div class='alert alert-danger'>Cek config!</div>";
            }
          }
        }else{
          echo "<h1 class='text-center'>404 Pages Not Found</h1>";
        }
      }else{
        echo "<h1 class='text-center'>404 Pages Not Found</h1>";
      }
      }elseif ($_GET['menu']=="delete_barang") {
        if ($_GET['id']) {
          $id=mysqli_real_escape_string($conn,$_GET['id']);
          $qID=mysqli_query($conn,"SELECT * FROM barang where id='$id'");
          if(mysqli_num_rows($qID)>0){
            $q_deleteBarang="DELETE FROM barang where id='$id'";
            if (mysqli_query($conn,$q_deleteBarang)) {
              echo '<div class="alert alert-success">Berhasil hapus data!</div>
              <script>
              setTimeout(
                    function(){
                      window.location = "?menu=lihat_barang"
                    },
                    2000);
              </script>
              ';
            }else {
              echo "<div class='alert alert-danger'>Cek config!</div>";
            }
          }else{
            echo "<div class='text-center'>404 Pages Not Found</div>";
          }
        }else {
          echo "<h1 class='text-center'>404 Pages Not Found</h1>";
        }
      }elseif ($_GET['menu']=="lihat_transaksi") {
        $q_transaksi=mysqli_query($conn,"SELECT * FROM transaksi");
        if ($_GET['hapus']=="semua_data") {
          $q_cekDataTransaksi=mysqli_query($conn,"SELECT * FROM transaksi");
          if(mysqli_num_rows($q_cekDataTransaksi)<1){
            echo "<h1 class='text-center'>404 Pages Not Found</h1>";
          }else{
            $q_semuaData="DELETE FROM transaksi";
            if (mysqli_query($conn,$q_semuaData)) {
              echo '
              <div class="alert alert-success">Berhasil hapus semua data transaksi!</div>
              <script>
              setTimeout(
                    function(){
                      window.location = "?menu=lihat_transaksi"
                    },
                    2000);
              </script>
              ';
            }else{
              echo "<div class='alert alert-danger'>Cek config!</div>";
            }
          }
        }
        if ($_GET['hapus']=="hapus_id") {
          if ($_GET['id']) {
            $id=mysqli_real_escape_string($conn,$_GET['id']);
            $q_cocokID_hapus=mysqli_query($conn,"SELECT * FROM transaksi where id='$id'");
            if(mysqli_num_rows($q_cocokID_hapus)>0){
              if(mysqli_query($conn,"DELETE FROM transaksi WHERE id='$id'")){
                echo '<div class="alert alert-success">Hapus data success!</div>
                <script>
                setTimeout(
                      function(){
                        window.location = "?menu=lihat_transaksi"
                      },
                      2000);
                </script>
                ';
              }else{
                echo "<div class='alert alert-danger'>Cek config!</div>";
              }
            }
          }
        }
      ?>
      <h1>Lihat transaksi</h1>
      <br>
      <a href="?menu=lihat" class="btn btn-info">Lihat total transaksi semua</a>
      <?php
      $q_cekTransaksi=mysqli_query($conn,"SELECT * FROM transaksi");
      if(mysqli_fetch_array($q_cekTransaksi)>0){
      ?>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusDataSemua">Hapus semua data</button>
      <?php
      }
       ?>
      <pre>
        <table class="table table-striped">
          <thead>
            <tr>
              <th width="300px">Nama barang</th>
              <th width="100px">Jumlah</th>
              <th width="230px">total harga</th>
              <th width="230px">Total laba</th>
              <th width='30px'>Menu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($var=mysqli_fetch_array($q_transaksi)) {
            $exp=explode("-",$var['nama']);
            ?>
            <tr>
              <td><?php echo $exp[0]; ?></td>
              <td><?php echo $var['jumlah'] ?></td>
              <td><?php echo $var['total_hargaSemua']; ?></td>
              <td><?php echo $var['total_hargaLaba']; ?></td>
              <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusDataID" data-href="?menu=lihat_transaksi&hapus=hapus_id&id=<?php echo $var['id'] ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M6.5 1.75a.25.25 0 01.25-.25h2.5a.25.25 0 01.25.25V3h-3V1.75zm4.5 0V3h2.25a.75.75 0 010 1.5H2.75a.75.75 0 010-1.5H5V1.75C5 .784 5.784 0 6.75 0h2.5C10.216 0 11 .784 11 1.75zM4.496 6.675a.75.75 0 10-1.492.15l.66 6.6A1.75 1.75 0 005.405 15h5.19c.9 0 1.652-.681 1.741-1.576l.66-6.6a.75.75 0 00-1.492-.149l-.66 6.6a.25.25 0 01-.249.225h-5.19a.25.25 0 01-.249-.225l-.66-6.6z"></path></svg></button></td>
            </tr>
            <?php
            }
             ?>
          </tbody>
        </table>
      </pre>
      <br>
      <a href="?menu=lihat" class="btn btn-info">Lihat total transaksi semua</a>

      <!-- modal hapus data transaksi semua -->
      <div id="modalHapusDataSemua" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">ANDA YAKIN, AKAN MENGHAPUS SEMUA DATA TRANSAKSI???</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal"> Batal</button>
              <a href="?menu=lihat_transaksi&hapus=semua_data" class="btn btn-danger">Hapus</a>
            </div>
          </div>
        </div>
      </div>
      <!-- modal hapus data transaksi ID -->
      <div class="modal fade" id="modalHapusDataID" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                      <b>Anda yakin ingin menghapus data ini?</b><br><br>
                      <a class="btn btn-danger btn-ok">Hapus</a>
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                  </div>
              </div>
          </div>
      </div>
      <?php
      }elseif ($_GET['menu']=="lihat") {
        $q=mysqli_query($conn,"SELECT * FROM transaksi");
      ?>
      <h1>Lihat transaksi</h1>
      <br>
      <pre>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Deskripsi</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Total laba(Rupiah)</td>
              <td><?php
                        $total=0;
                        while ($var=mysqli_fetch_array($q)) {
                          $total+=$var["total_hargaLaba"];
                        }
                        echo "<strong>Rp. ".number_format($total,0,',','.').",-</strong>";
                         ?></td>
            </tr>
            <tr>
              <td>Total semua tanpa laba(Rupiah)</td>
              <td><?php
              $q2=mysqli_query($conn,"SELECT * FROM transaksi");
                        $total1=0;
                        while ($var_satu=mysqli_fetch_array($q2)) {
                          $total1+=$var_satu["total_hargaTanpaLaba"];
                        }
                        echo "<strong>Rp. ".number_format($total1,0,',','.').",-</strong>";
                         ?></td>
            </tr>
            <tr>
              <td><strong>Total penghasilan saat ini(Rupiah)</strong></td>
              <td><?php
              $q3=mysqli_query($conn,"SELECT * FROM transaksi");
                        $total2=0;
                        while ($var_dua=mysqli_fetch_array($q3)) {
                          $total2+=$var_dua["total_hargaSemua"];
                        }
                        echo "<strong><i><u>Rp. ".number_format($total2,0,',','.').",-</u></i></strong>";
                         ?></td></tr>
          </tbody>
        </table>
      </pre>
      <br>
      *Note:
      <br>
      1. Total laba = Total untung anda.
      <br>
      2. Total semua tanpa laba = total harga tanpa untung(harga pembelian barang).
      <br>
      3. Total harga semua = Total laba + total harga tanpa untung.
      <?php
      }elseif ($_GET['menu']=="set_user") {
      ?>
      <h1>Atur user</h1>
      <br>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_tambahUser"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M8 2a.75.75 0 01.75.75v4.5h4.5a.75.75 0 010 1.5h-4.5v4.5a.75.75 0 01-1.5 0v-4.5h-4.5a.75.75 0 010-1.5h4.5v-4.5A.75.75 0 018 2z"></path></svg> Tambah user</button>
      <br><br>
      <?php
      $no=1;
      $username=mysqli_real_escape_string($conn,$_POST['username']);
      $password=md5($_POST['password']);
      $q_tambah="INSERT INTO admin(username,password) values('$username','$password')";
      if($_POST){
        if(mysqli_query($conn,$q_tambah)){
          echo "<div class='alert alert-success'>Sukses tambah user!</div>";
        }else {
          echo "<div class='alert alert-danger'>Cek config!</div>";
        }
      }
      if($_GET['hapus']=="user"){
        if($_GET['id']){
          $id=mysqli_real_escape_string($conn,$_GET['id']);
          $q_hapusUserID="DELETE FROM admin where id='$id'";
          $q_userSiapa=mysqli_query($conn,"SELECT * FROM admin where id='$id'");
          $q_userSiapa_arr=mysqli_fetch_array($q_userSiapa);
          if(mysqli_query($conn,$q_hapusUserID)){
            echo "<div class='alert alert-success'>Sukses hapus user ".htmlentities($q_userSiapa_arr['username'])."</div>
            <script>
            setTimeout(
                  function(){
                    window.location = '?menu=set_user'
                  },
                  2000);
            </script>
            ";
          }else {
            echo "<div class='alert alert-danger'>Cek config!</div>";
          }
        }
      }
       ?>
      <table class="table table-boardered">
        <thead>
          <tr>
            <th width='30px'>No</th>
            <th>Username</th>
            <th>Setting</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q_tampilUser=mysqli_query($conn,"SELECT * FROM admin");
          while($var=mysqli_fetch_array($q_tampilUser)){
          ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo htmlentities($var['username']); ?></td>
            <td><a class='btn btn-danger' data-toggle='modal' data-target='#konfirmasi_hapusUser' data-href='?menu=set_user&hapus=user&id=<?php echo $var['id'] ?>'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M6.5 1.75a.25.25 0 01.25-.25h2.5a.25.25 0 01.25.25V3h-3V1.75zm4.5 0V3h2.25a.75.75 0 010 1.5H2.75a.75.75 0 010-1.5H5V1.75C5 .784 5.784 0 6.75 0h2.5C10.216 0 11 .784 11 1.75zM4.496 6.675a.75.75 0 10-1.492.15l.66 6.6A1.75 1.75 0 005.405 15h5.19c.9 0 1.652-.681 1.741-1.576l.66-6.6a.75.75 0 00-1.492-.149l-.66 6.6a.25.25 0 01-.249.225h-5.19a.25.25 0 01-.249-.225l-.66-6.6z"></path></svg></a></td>
          </tr>
          <?php
          }
           ?>
        </tbody>
      </table>
      <div class="modal fade" id="konfirmasi_hapusUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-body">
                      <b>Anda yakin ingin menghapus data ini ?</b><br><br>
                      <a class="btn btn-danger btn-ok"> Hapus</a>
                      <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="modal_tambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah user</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-group" action="?menu=set_user" method="post">
                <label for="username"> <strong>Username</strong> </label>
                <input type="text" name="username" value="" class="form-control" placeholder="Username..." id="username">
                <br>
                <label for="password"> <strong>Password</strong> </label>
                <input type="text" name="password" value="" class="form-control" placeholder="Password..." id="password">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <input type="submit" name="submit" value="Tambah" class="btn btn-primary">
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php
      }else{
          echo "<h1 class='text-center'>404 Pages Not Found</h1>";
      }
       ?>
       <br><br><br>
      </div>

     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
     <script type="text/javascript">
       //Hapus Data
       $(document).ready(function() {
           $('#modalHapusDataID').on('show.bs.modal', function(e) {
               $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
           });
       });
     </script>
     <script type="text/javascript">
       $(document).ready(function() {
           $('#konfirmasi_hapusUser').on('show.bs.modal', function(e) {
               $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
           });
       });
     </script>
     <script>
     $("ul > li").hover(
         function() {
             $(this).addClass('active');
         }, function() {
             $( this ).removeClass('active');
         }
     );
     $( "ul > li" ).click(function(){
             $(this).toggleClass('active');
     });
     </script>
   </body>
 </html>
