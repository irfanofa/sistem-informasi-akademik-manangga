<?php
// user login
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(1, 10));

/*template control*/
$ui_register_page     = 'guru';
$ui_register_assets   = array('datepicker');

/*load header*/
loadAssetsHead('Tambah Master Data guru');

/*form processing*/
if (isset ($_POST["guru_simpan"])) { 

	$nip  = $_POST['nip'];
	$password  = $_POST['password'];
	$password1  = $_POST['password1'];
	$nm_guru  = $_POST['nm_guru'];
	$tmpt_lahir  = $_POST['tmpt_lahir'];
	$date_tgl_lahir0  = $_POST['date_tgl_lahir'];
	$date_tgl_lahir=ubahformatTgl($date_tgl_lahir0);
	$jns_kelamin  = $_POST['jns_kelamin'];
	$id_agama  = $_POST['id_agama'];
	$status_guru  = $_POST['status_guru'];
	$gelar_depan  = $_POST['gelar_depan'];
	$gelar_depan_akademik  = $_POST['gelar_depan_akademik'];
	$gelar_belakang  = $_POST['gelar_belakang'];
	$id_kec  = $_POST['id_kec'];
	$id_kec  = str_replace("'","&acute;",$id_kec);

	$kota  = $_POST['kota'];
	$kota  = str_replace("'","&acute;",$kota);

	$prov  = $_POST['prov'];
	$prov  = str_replace("'","&acute;",$prov);

	$id_kel  = $_POST['id_kel'];
	$id_kel  = str_replace("'","&acute;",$id_kel);
	$almt_sekarang = $_POST['almt_sekarang'];
	$no_hp  = $_POST['no_hp'];
	$email  = $_POST['email'];
	$id_user =2;

      #VALIDASI UNTUK FORM JIKA FORM KOSONG

	function compress_image($source_url, $destination_url, $quality) 
	{ 
		$info = getimagesize($source_url); 
		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source_url); 
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source_url); 
		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source_url); 
		imagejpeg($image, $destination_url, $quality); 
		return $destination_url; 
	} 

	$nama_foto = $_FILES["file"]["name"];
      $file_sik_dipilih = substr($nama_foto, 0, strripos($nama_foto, '.')); // strip extention
      $bagian_extensine = substr($nama_foto, strripos($nama_foto, '.')); // strip name
      $ukurane = $_FILES["file"]["size"];

      $pesanError= array();
      if (trim($nip)=="") {
      	$pesanError[]="Data <b>NIP</b> masih kosong.";
      }
      if (trim($password)=="") {
      	$pesanError[]="Data <b>Password</b> masih kosong.";
      }
      if (trim($password1)=="") {
      	$pesanError[]="Data Konfirmasi<b>Password</b> masih kosong.";
      }
      if (trim($nm_guru)=="") {
      	$pesanError[]="Data <b>Nama Guru</b> masih kosong.";
      }
      if (trim($tmpt_lahir)=="") {
      	$pesanError[]="Data <b>Tempat Lahir</b> masih kosong.";
      }
      if (trim($date_tgl_lahir)=="") {
      	$pesanError[]="Data <b>Tanggal Lahir</b> masih kosong.";
      }
      if (trim($jns_kelamin)=="") {
      	$pesanError[]="Data <b>Jenis Kelamin</b> masih kosong.";
      }
      if (trim($id_agama)=="") {
      	$pesanError[]="Data <b>Agama</b> masih kosong.";
      }
      if (trim($status_guru)=="") {
      	$pesanError[]="Data <b>Status Guru</b> masih kosong.";
      }
      if (trim($prov)=="") {
      	$pesanError[] = "Data <b>Provinsi</b> tidak boleh kosong !";    
      }
      if (trim($kota)=="") {
      	$pesanError[] = "Data <b>Kabupaten</b> tidak boleh kosong !";    
      }
      if (trim($id_kec)=="") {
      	$pesanError[]="Data <b>Kecamatan</b> Masih kosong !!";
      }
      if (trim($id_kel)=="") {
      	$pesanError[]="Data <b>Kelurahan</b> Masih kosong !!";
      }
      if (trim($almt_sekarang)=="") {
      	$pesanError[]="Data <b>Alamat Sekarang</b> masih kosong.";
      }
      if (trim($no_hp)=="") {
      	$pesanError[]="Data <b>Nomor HP</b> masih kosong.";
      }
      if (trim($id_user)=="") {
      	$pesanError[] = "Data <b>id_user</b> tidak boleh kosong !";    
      }
      if (empty($file_sik_dipilih)){
      	$pesanError[] = "Anda Belum Memilih Foto !";    
      }

      #JIKA ADA PESAN ERROR DARI VALIDASI FORM 
      if (count($pesanError)>=1) {
      	echo "
      	<div class='alert alert-danger alert-dismissable'>
      		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
      		$noPesan= 0;
      		foreach ($pesanError as $indeks => $pesan_tampil) {
      			$noPesan++;
      			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
      		}
      		echo "</div><br />";
      	}
      	else{

      		if(($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")){
      			$lokasi = 'gallery/news/';

             //$jeneng = $id_pegawai.'.jpg';

      			$file = md5(rand(1000,1000000000))."-".$nama_foto;
      			$newfilename = $file . $bagian_extensine;
      			$jeneng=str_replace(' ','-',$file);
      			$url = $lokasi . $jeneng;
      			$filename = compress_image($_FILES["file"]["tmp_name"], $url, 80); 

      			$query = mysql_query("INSERT INTO guru 
      				SET id_user ='$id_user', 
      					nip='$nip', 
      					password='$password',
      					nm_guru='$nm_guru',
      					tmpt_lahir='$tmpt_lahir',
      					date_tgl_lahir='$date_tgl_lahir',
      					jns_kelamin='$jns_kelamin',
      					id_agama='$id_agama',
      					status_guru='$status_guru',
      					gelar_depan='$gelar_depan',
      					gelar_depan_akademik='$gelar_depan_akademik',
      					gelar_belakang='$gelar_belakang',
      					almt_sekarang='$almt_sekarang',
      					no_hp='$no_hp',
      					email='$email',
      					foto='$jeneng',
      					id_kel='$id_kel'
      					") or die(mysql_error());


      		}
      		if ($query){
      			header('location: ./guru');
      		}
      		else { $error = "Uploaded image should be jpg or gif or png"; } 

      	}
      }



    // simpan pada form, dan jika form belum terisi
      $datanip  = isset($_POST['nip']) ? $_POST['nip'] : '';
      $datapassword  = isset($_POST['password']) ? $_POST['password'] : '';
      $datanamaguru  = isset($_POST['nm_guru']) ? $_POST['nm_guru'] : '';
      $datatempatlahir  = isset($_POST['tmpt_lahir']) ? $_POST['tmpt_lahir'] : '';
      $datatanggallahir  = isset($_POST['date_tgl_lahir']) ? $_POST['date_tgl_lahir'] : '';
      $datajeniskelamin  = isset($_POST['jns_kelamin']) ? $_POST['jns_kelamin'] : '';
      $dataagama  = isset($_POST['id_agama']) ? $_POST['id_agama'] : '';
      $dataalamat  = isset($_POST['almt_sekarang']) ? $_POST['almt_sekarang'] : '';
      $datanohp  = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
      $dataemail  = isset($_POST['email']) ? $_POST['email'] : '';

      ?>
      <script type="text/javascript">
      	var htmlobjek;
      	$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=prov>
  $("#prov").change(function(){
  	var prov = $("#prov").val();
  	$.ajax({
  		url: "inc/jikuk_kabupaten.php",
  		data: "prov="+prov,
  		cache: false,
  		success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=kota>
            $("#kota").html(msg);
        }
    });
  });
  $("#kota").change(function(){
  	var kota = $("#kota").val();
  	$.ajax({
  		url: "inc/jikuk_kecamatan.php",
  		data: "kota="+kota,
  		cache: false,
  		success: function(msg){
  			$("#id_kec").html(msg);
  		}
  	});
  });
  $("#id_kec").change(function(){
  	var id_kec = $("#id_kec").val();
  	$.ajax({
  		url: "inc/jikuk_kelurahan.php",
  		data: "id_kec="+id_kec,
  		cache: false,
  		success: function(msg){
  			$("#id_kel").html(msg);
  		}
  	});
  });
});

      </script>
  <script type="text/javascript">
  function convertAngkaNIP(objek) {
    
    a = objek.value;
    b = a.replace(/[^\d]/g,"");
    
    objek.value = b;

  }            
</script>

<script type="text/javascript">
  function convertAngkaHP(objek) {
    
    a = objek.value;
    b = a.replace(/[^\d]/g,"");
    
    objek.value = b;

  }            
</script>
      <body>

      	<?php
  // LOAD MAIN MENU
      	loadMainMenu();
      	?>

      	<div class="uk-container uk-container-center uk-margin-large-top">
      		<div class="uk-grid" data-uk-grid-margin data-uk-grid-match>
      			<div class="uk-width-medium-1-6 uk-hidden-small">
      				<?php loadSidebar() ?>
      			</div>
      			<div class="uk-width-medium-5-6 tm-article-side">
      				<article class="uk-article">
      					<div class="uk-vertical-align uk-text-right uk-height-1-1">
      						<img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="Sistem Informasi Akademik SD Negeri II Manangga" title="Sistem Informasi Akademik SD Negeri II Manangga">
      					</div>
      					<hr class="uk-article-divider">
      					<h1 class="uk-article-title">Guru<span class="uk-text-large">{ Tambah Master Data Guru }</span></h1>
      					<br>
      					<a href="./guru" class="uk-button uk-button-primary uk-margin-bottom" type="button" title="Kembali ke Manajemen Guru"><i class="uk-icon-angle-left"></i> Kembali</a>
      					<!-- <hr class="uk-article-divider"> -->
      					<div class="uk-grid" data-uk-grid-margin>
      						<div class="uk-width-medium-1-1">
      							<form id="formguru" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Image <span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<div class="col-lg-8">
      											<div class="fileupload fileupload-new" data-provides="fileupload">
      												<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="./assets/fileupload/images/nopict.jpg" alt="" /></div>
      												<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
      												<div>
      													<span class="btn btn-file btn-primary btn-xs"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" accept="image/*" name="file" id="file" placeholder="file" /></span>
      													<a href="#" class="btn btn-danger btn-xs fileupload-exists" data-dismiss="fileupload">Remove</a>
      												</div>
      											</div>
      										</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nip">NIP<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="nip" name="nip" value="<?php echo $datanip; ?>" onkeyup="convertAngkaNIP(this);" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Contoh: 126500182411. Jumlah minimal 18 angka. Wajib diisi (Digunakan sebagai username untuk login sistem)</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nm_guru">Nama Guru<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="nm_guru" name="nm_guru" value="<?php echo $datanamaguru; ?>" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Contoh: Fajar Nurrohmat. Jumlah minimal 1 huruf. Wajib diisi (Tuliskan nama saja, tidak dengan gelar akademik)</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="password" name="password" value="<?php echo $datapassword; ?>" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Contoh: 126500182411. Jumlah minimal 6 karakter. Wajib diisi (Digunakan untuk login)</div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password1">Konfirmasi Password<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="password1" name="password1" value="<?php echo $datapassword; ?>" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Contoh: 126500182411. Jumlah minimal 6 karakter. Harus Sama dengan Password. Wajib diisi (Digunakan untuk login)</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_tgl_lahir">Tanggal Lahir<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="date_tgl_lahir" name="date_tgl_lahir" value="<?php echo $datatanggallahir; ?>" required="required" class="form-control col-md-7 col-xs-12" data-uk-datepicker="{format:'DD/MM/YYYY'}" >
      										<div class="reg-info">Format: <code>DD/MM/YYYY</code></div>
      										<div class="reg-info">Contoh: 31/12/1994</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tmpt_lahir">Tempat Lahir<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="tmpt_lahir" name="tmpt_lahir" value="<?php echo $datatempatlahir; ?>" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Contoh: Gunungkidul, Tempat Lahir berupa nama kabupaten</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="jns_kelamin">Jenis Kelamin<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select name="jns_kelamin" id="jns_kelamin" value="<?php echo $datajeniskelamin; ?>" class="form-control col-md-7 col-xs-12">
      											<option value="">--- Pilih Jenis Kelamin --</option>
      											<option value="Laki-Laki">Laki-Laki</option>
      											<option value="Perempuan">Perempuan</option>
      										</select>
      										<div class="reg-info">Jenis Kelamin hanya Laki-Laki dan Perempuan, Pilih Salah Satu!</div>
      									</div>
      								</div>

      <div class="item form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_agama">Agama<span class="required">*</span>
           </label>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="id_agama" id="id_agama" value="<?php echo $dataagama; ?>" class="form-control col-md-7 col-xs-12">
              <option value="">--- Pilih agama yang dianut --</option>
               <?php
                    //MENGAMBIL NAMA PROVINSI YANG DI DATABASE
                            $agama =mysql_query("SELECT * FROM agama ORDER BY nm_agama");
                            while ($dataagama=mysql_fetch_array($agama)) {
                              echo "<option value=\"$dataagama[id_agama]\">$dataagama[nm_agama]</option>\n";
                            }
                            ?>
            </select>
          </div>
        </div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="jns_kelamin">Status Guru<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select name="status_guru" id="status_guru" value="<?php echo $datastatusguru; ?>" class="form-control col-md-7 col-xs-12">
      											<option value="">--- Pilih Status Guru --</option>
      											<option value="WiyataBhakti">Wiyata Bhakti</option>
      											<option value="PNS">Pegawai Negri Sipil</option>
      										</select>
      										<div class="reg-info">Status Guru hanya Wiyata Bhakti dan Pegawai Negri Sipil(PNS), Pilih Salah Satu!</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelar_depan">Gelar Depan Non Akademik<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="gelar_depan" name="gelar_depan" value="<?php echo $datagelardepan; ?>"  class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Kosongkan Jika Tidak Ada Gelar Depan Non Akademik </div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelar_depan_akademik">Gelar Depan Akademik<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="gelar_depan_akademik" name="gelar_depan_akademik" value="<?php echo $datagelardepanakademik; ?>"  class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Kosongkan Jika Tidak Ada Gelar Depan Akademik</div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelar_belakang">Gelar Belakang<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="gelar_belakang" name="gelar_belakang" value="<?php echo $datagelarbelakang; ?>"  class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Kosongkan Jika Tidak Ada Gelar Belakang</div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="prov">Provinsi <span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select type="text" class="form-control chzn-select col-md-7 col-xs-12" id="prov" name="prov" required>
      											<option value="">-Pilih Provinsi-</option>
      											<?php
                    //MENGAMBIL NAMA PROVINSI YANG DI DATABASE
      											$provinsi =mysql_query("SELECT * FROM provinsi ORDER BY nama_prov");
      											while ($dataprovinsi=mysql_fetch_array($provinsi)) {
      												echo "<option value=\"$dataprovinsi[id_prov]\">$dataprovinsi[nama_prov]</option>\n";
      											}
      											?>
      										</select>
      										<div class="reg-info">Wajib Pilih  Provinsi  </div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">Kabupaten <span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select type="text" class="form-control chzn-select col-md-7 col-xs-12" id="kota" name="kota" required>
      											<option value="">-Pilih Kabupaten-</option>
      										</select>
      										<div class="reg-info">Wajib Pilih  Kabupaten  </div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_kec">Kecamatan <span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select type="text" class="form-control chzn-select col-md-7 col-xs-12" id="id_kec" name="id_kec" required>
      											<option value="">-Pilih Kecamatan-</option>
      										</select>
      										<div class="reg-info">Wajib Pilih  Kecamatan  </div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_kel">Kelurahan <span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<select type="text" class="form-control chzn-select col-md-7 col-xs-12" id="id_kel" name="id_kel" required>
      											<option value="">-Pilih Kelurahan-</option>
      										</select>
      										<div class="reg-info">Wajib Pilih  Kelurahan  </div>
      									</div>
      								</div>
      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="almt_sekarang">Alamat Rumah Sekarang<span class="required">*</span>
      									</label>
      									
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<textarea rows="9" id="almt_sekarang" required="required" name="almt_sekarang" class="form-control col-md-7 col-xs-12"><?php echo $dataalamat; ?></textarea>
<div class="reg-info">Wajib diisi data alamat rumah sekarang, isi data alamat rumah sekarang dengan lengkap</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_hp">No. HP<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="no_hp" name="no_hp" onkeyup="convertAngkaHP(this);" value="<?php echo $datanohp; ?>" required="required" class="form-control col-md-7 col-xs-12">
      										<div class="reg-info">Wajib Isi Data No Hp</div>
      									</div>
      								</div>

      								<div class="item form-group">
      									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span>
      									</label>
      									<div class="col-md-6 col-sm-6 col-xs-12">
      										<input type="text" id="email" name="email" value="<?php echo $dataemail; ?>" class="form-control col-md-7 col-xs-12">
      									</div>
      								</div>

      								<div class="uk-form-row">
      									<div class="uk-alert">Pastikan semua isian sudah terisi dengan benar!</div>
      								</div>
      								<div style="text-align:center" class="form-actions no-margin-bottom">
      									<button type="submit" id="guru_simpan" name="guru_simpan" class="btn btn-success">Submit</button>
      								</div>
      							</form>    
      						</div>
      					</div>
      				</div>
      				</article>
      				</div>
      				</div>

      				<script src="assets/validator/js/bootstrapValidator.min.js" type="text/javascript"></script>
      				<link rel="stylesheet" href="/vendor/formvalidation/css/formValidation.min.css">
      				<link rel="stylesheet" href="/asset/css/demo.css">
      				<script src="/vendor/formvalidation/js/formValidation.min.js"></script>
      				<script src="/vendor/formvalidation/js/framework/uikit.min.js"></script>

      				<script type="text/javascript">

      					var formguru = $("#formguru").serialize();
      					var validator = $("#formguru").bootstrapValidator({
      						framework: 'bootstrap',
      						feedbackIcons: {
      							valid: "glyphicon glyphicon-ok",
      							invalid: "glyphicon glyphicon-remove", 
      							validating: "glyphicon glyphicon-refresh"
      						}, 
      						excluded: [':disabled'],
      						fields : {
      							file : {
      								validators : {
      									notEmpty: {
      										message: 'Belum Memilih Gambar'
      									},
      									file : {
      										extention : 'jpeg,jpg,png',
      										type : 'image/jpeg,image/png',
              //maxSize : 2097152, //2048*1024
              message : 'file tidak benar'
          }
      }
  } ,
  nip : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Isi NIP'
  		},
  		stringLength: {
       min: 18,
        max: 18,
  			message: 'NIP minimal 18 angka.'
  		},
  		remote: {
  			type: 'POST',
  			url: 'remote/remote_guru.php',
  			message: 'NIP Guru Telah Tersedia'
  		},
  	}
  },
  nm_guru: {
  	message: 'Nama Tidak Benar',
  	validators: {
  		notEmpty: {
  			message: 'Nama Harus Diisi'
  		},
  		stringLength: {
  			min: 1,
  			max: 50,
  			message: 'Nama Harus Lebih dari 1 Huruf dan Maksimal 50 Huruf'
  		},
  		regexp: {
  			regexp: /^[a-zA-Z ]+$/,
  			message: 'Karakter Yang Boleh Digunakan hanya huruf'
  		},
  	}
  },
  password: {
  	message: 'Data Password Tidak Benar',
  	validators: {
  		notEmpty: {
  			message: 'Password Harus Diisi'
  		},
  		stringLength: {
  			min: 1,
  			max: 30,
  			message: 'Nama kelurahan Harus Lebih dari 1 Huruf dan Maksimal 30 Huruf'
  		},
  		different: {
  			field: 'email',
  			message:'Password Harus Beda dengan Email'
  		},					
  	}
  },
  password1: {
  	message: 'Data Password Tidak Benar',
  	validators: {
  		identical:{
  			field:'password',
  			message: 'Konfirmasi Password Harus Sama Dengan Password'
  		},
  		notEmpty: {
  			message: 'Password Harus Diisi'
  		},
  		stringLength: {
  			min: 1,
  			max: 30,
  			message: 'Nama kelurahan Harus Lebih dari 1 Huruf dan Maksimal 30 Huruf'
  		},
  		different: {
  			field: 'email',
  			message:'Password Harus Beda dengan Email'
  		},
  	}
  },


  tmpt_lahir : {
  	validators: {
  		notEmpty: {
  			message: 'Harus diisi tempat lahir'
  		}
  	}
  },    
  jns_kelamin : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Jenis Kelamin'
  		}
  	}
  }, 
  id_agama : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Agama'
  		}
  	}
  },    
  status_guru : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Status Guru'
  		}
  	}
  },       


  prov : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Provinsi'
  		}
  	}
  },    
  kota : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Kabupaten'
  		}
  	}
  }, 
  id_kec : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Kecamatan'
  		}
  	}
  }, 
  id_kel : {
  	validators: {
  		notEmpty: {
  			message: 'Harus Pilih Kelurahan'
  		}
  	}
  }, 
  almt_sekarang : {
  	message: 'Alamat Tidak Benar',
  	validators: {
  		notEmpty: {
  			message: 'Alamat Harus Diisi'
  		},
  		stringLength: {
  			min: 10,
  			max: 100,
  			message: 'Alamat Harus Lebih dari 10 Huruf dan Maksimal 100 Huruf'
  		},


  	}
  }, 
  no_hp: {
  	message: 'No HP Tidak Benar',
  	validators: {
  		notEmpty: {
  			message: 'No HP Harus Diisi'
  		},
  		stringLength: {
  			min: 0,
  			max: 30,
  			message: 'No Hp Harus Lebih dari 0 Huruf dan Maksimal 30 Huruf'
  		},
  		regexp: {
  			regexp: /^[0-9+]+$/,
  			message: 'Format Tidak Benar'
  		},

  	}
  },




}
});
</script>

</body>

<?php
// LOAD FOOTER
loadAssetsFoot();

ob_end_flush();
?>
