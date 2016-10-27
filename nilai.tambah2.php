<?php
// user login
require ( __DIR__ . '/init.php');
checkUserAuth();
checkUserRole(array(1, 10));

/*template control*/
$ui_register_page     = 'nilai';
$ui_register_assets   = array('datepicker');

/*load header*/
loadAssetsHead('Tambah Data Nilai');

/*form processing*/
$kelas = $_GET['kelas'];

?>

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
            <img class="uk-margin-bottom" width="500px" height="50px" src="assets/images/banner.png" alt="Sistem Informasi Akademik SDN II Manangga" title="Sistem Informasi Akademik SDN II Manangga">
          </div>
          <hr class="uk-article-divider">
                 <?php $kls = mysql_fetch_array(mysql_query("SELECT nm_kelas FROM kelas WHERE id_kelas = $kelas"));?>
                 <?php echo $kls; ?>   
          <h1 class="uk-article-title">Input Nilai <span class="uk-text-large">{ Tambah Data Nilai 
 
          }</span></h1>
          <br>
          <a href="./nilai" class="uk-button uk-button-primary uk-margin-bottom" type="button" title="Kembali ke Manajemen Nilai"><i class="uk-icon-angle-left"></i> Kembali</a>
          <!-- <hr class="uk-article-divider"> -->
          <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
             
        <form id="formnilai" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" action="nilai.tambah2.php" onKeyUp="highlight(event)" onClick="highlight(event)" onsubmit="return validate(this)" method="get">

      <div class="item form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_guru">Pilih Siswa<span class="required">*</span>
           </label>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="nis" id="nis" value="<?php echo $datanis; ?>" class="form-control col-md-7 col-xs-12">
              <option value="">--- Pilih Siswa --</option>
              <?php
              $query = "SELECT * from kelas";
              $hasil = mysql_query($query);
              while ($data = mysql_fetch_array($hasil))
              {
                echo "<option value=".$data['id_kelas'].">".$data['nm_kelas']."</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div style="text-align:center" class="form-actions no-margin-bottom">
            <td colspan="3"><div align="center">
      <input type="submit" name="Submit" value="Input Nilai" />
    <input type="reset" name="reset" value="Reset" />
    </div></td>
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
 var formkelas = $("#formkelas").serialize();
 var validator = $("#formkelas").bootstrapValidator({
  framework: 'bootstrap',
  feedbackIcons: {
    valid: "glyphicon glyphicon-ok",
    invalid: "glyphicon glyphicon-remove", 
    validating: "glyphicon glyphicon-refresh"
  }, 
  excluded: [':disabled'],
  fields : {
    
nm_kelas: {
  message: 'Nama Kelas Tidak Benar',
  validators: {
    notEmpty: {
      message: 'Nama Kelas Harus Diisi'
    },
    stringLength: {
      min: 1,
      max: 50,
      message: 'Nama Kelas Harus Lebih dari 1 Huruf dan Maksimal 50 Huruf'
    },
    regexp: {
      regexp: /^[a-zA-Z0-9_ \. ]+$/,
      message: 'Karakter Boleh Digunakan (Angka, Huruf, Titik, Underscore)'
    },
    remote: {
      type: 'POST',
      url: 'remote/remote_namakelas.php',
      message: 'Nama Kelas Telah Tersedia'
    },

  }
}

}
});
</script>

</body>

<?php
// LOAD FOOTER
loadAssetsFoot();

ob_end_flush();
?>
