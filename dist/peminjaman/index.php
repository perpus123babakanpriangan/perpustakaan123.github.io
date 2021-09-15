<script>
    $('title').text('Data Peminjaman');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Peminjaman</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Peminjaman</li>
        </ol>
        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah Peminjaman
            if (isset($_GET['add'])) {
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Peminjaman telah disimpan</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Peminjaman gagal disimpan</div>";
                }    
            }

            //Validasi untuk menampilkan pesan pemberitahuan saat user menghapus Peminjaman
            if (isset($_GET['hapus'])) {
                if ($_GET['hapus']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Peminjaman telah dihapus</div>";
                }else if ($_GET['hapus']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Peminjaman gagal dihapus</div>";
                }    
            }

            if (isset($_GET['hapus-peminjaman'])) {
                if ($_GET['hapus-peminjaman']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Peminjaman telah dihapus</div>";
                }else if ($_GET['hapus-peminjaman']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Peminjaman gagal dihapus</div>";
                }    
            }
        ?>

        <div class="card mb-4">
            <div class="card-header">
            <?php if ($_SESSION["level"]!="Manajer"): ?>
            <a href="index.php?page=input-peminjaman" class="btn btn-primary" role="button">Input Peminjaman</a>
            <?php endif; ?>
            </div>
            <div class="card-body">
                <div  class="collapse show">
                    <!-- form -->
                    <form action="#" method="get">
                    <input type="hidden" name="page" value="daftar-peminjaman"/>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="form-control" name="kode_peminjaman" id="kode_peminjaman">
                                        <option value="">Pilih Kode</option>
                                        <?php
                                        include '../config/database.php';
                                        //Perintah sql untuk menampilkan semua data pada tabel penulis
                                        $sql="select kode_peminjaman from peminjaman";
                                        $ket="";
                                        $hasil=mysqli_query($kon,$sql);
                                        $no=0;
                                        while ($data = mysqli_fetch_array($hasil)):
                                        $no++;
                                        if (isset($_GET['kode_peminjaman'])) {
                                            $kode_peminjaman = trim($_GET['kode_peminjaman']);
                            
                                            if ($kode_peminjaman==$data['kode_peminjaman'])
                                            {
                                                $ket="selected";
                                            }else {
                                                $ket="";
                                            }
                                        }
                                        ?>
                                        <option <?php echo $ket; ?> value="<?php echo $data['kode_peminjaman'];?>"><?php echo $data['kode_peminjaman'];?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                            <button  type="submit"  class="btn btn-dark"><span class="text"><i class="fas fa-search fa-sm"></i> Pilih</span></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Anggota</th>
                                <th>Jumlah Pustaka</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
        
                        <tbody>
                        <?php
                            // include database
                            include '../config/database.php';
                        
                            
                            if (isset($_GET['kode_peminjaman']) and $_GET['kode_peminjaman']!=''){

                                $kode_peminjaman = $_GET['kode_peminjaman'];

                                $sql="select p.kode_peminjaman,an.nama_anggota,count(*) as jumlah_pustaka
                                from peminjaman p
                                inner join anggota an on an.kode_anggota=p.kode_anggota
                                inner join detail_peminjaman dp on dp.kode_peminjaman=p.kode_peminjaman
                                inner join pustaka pk on pk.kode_pustaka=dp.kode_pustaka
                                where p.kode_peminjaman=$kode_peminjaman
                                group by an.nama_anggota,p.kode_peminjaman
                                order by p.kode_peminjaman desc";

                            }else {
                                $sql="select p.kode_peminjaman,an.nama_anggota,count(*) as jumlah_pustaka
                                from peminjaman p
                                inner join anggota an on an.kode_anggota=p.kode_anggota
                                inner join detail_peminjaman dp on dp.kode_peminjaman=p.kode_peminjaman
                                inner join pustaka pk on pk.kode_pustaka=dp.kode_pustaka
                                group by an.nama_anggota,p.kode_peminjaman
                                order by p.kode_peminjaman desc";
                            }
                    
                        
                            $hasil=mysqli_query($kon,$sql);
                            $no=0;
                            //Menampilkan data dengan perulangan while
                            while ($data = mysqli_fetch_array($hasil)):
                            $no++;
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>

                            <td><?php echo $data['kode_peminjaman']; ?></td>
                            <td><?php echo $data['nama_anggota']; ?></td>
                            <td><?php echo $data['jumlah_pustaka']; ?></td>
                           
                     
                            <td>
                                <a href="index.php?page=detail-peminjaman&kode_peminjaman=<?php echo $data['kode_peminjaman']; ?>" class="btn btn-success btn-circle"><i class="fas fa-mouse-pointer"></i></a>
                                <a href="Peminjaman/hapus-Peminjaman.php?kode_peminjaman=<?php echo $data['kode_peminjaman']; ?>" class="btn-hapus-Peminjaman btn btn-danger btn-circle" ><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- bagian akhir (penutup) while -->
                        <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Bagian header -->
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Bagian body -->
      <div class="modal-body">
        
        <div id="tampil_data">
          <!-- Data akan ditampilkan disini dengan AJAX -->                   
        </div>
            
      </div>
      <!-- Bagian footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>

   // fungsi hapus Peminjaman
   $('.btn-hapus-Peminjaman').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus data Peminjaman ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>