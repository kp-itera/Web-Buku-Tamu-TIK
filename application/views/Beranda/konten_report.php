<section class="content">
    <?php
//Connect API Mikrotik
use PEAR2\Net\RouterOS;

require_once 'PEAR2/Autoload.php';

$util = new RouterOS\Util(
    $client = new RouterOS\Client('10.50.50.1', 'kp', 'kp')
);
$util->setMenu('/ip/hotspot/active');

foreach ($util->getAll() as $item) {
    $user[] = $item->getProperty('user');
    $ip[]   = $item->getProperty('address');
    $mac[]  = $item->getProperty('mac-address');
}
$arrlength = count($user);
?>

        <!-- Database PC -->
        <?php
//Get ID PC Number from database pc
foreach ($pcdb->result() as $row){
  $pc_id[] = $row->id;
}
$jumlahpc = count($pc_id);
?>
            <?php
//Get Mac-address from database pc
foreach ($macdb->result() as $row) {
  $pc_mac[] = $row->mac_address;
}
?>

                <!-- Database Record -->
                <?php
//Get id from database record
foreach ($checkiddb->result() as $row) {
  $id_db[] = $row->id;
}
$jumlahrecord = count($id_db);
?>
                        <?php
//Get Nama from database record
foreach ($checknamadb->result() as $row) {
  $nama_db[] = $row->nama;
}
?>
                            <?php
//Get Nomor_PC from database record
foreach ($checknomorpcdb->result() as $row) {
  $nomorpc_db[] = $row->nomor_pc;
}
?>
                                <?php
//Get ip from database record
foreach ($checkipdb->result() as $row) {
  $ip_db[] = $row->ip;
}
?>
                                    <?php
//Get Mac-address from database record
foreach ($checkmacdb->result() as $row) {
  $mac_db[] = $row->mac_address;
}
?>

<!-- Get User Login -->
<?php
for ($j=0; $j<$jumlahrecord; $j++){
  //Cek Mikrotik to Database Record
  for ($x=0; $x<$arrlength; $x++){
    if($nama_db[$j] == $user[$x] && $ip_db[$j] == $ip[$x] && $mac_db[$j] == $mac[$x]){
      //Tidak masuk
      goto test;
    } else {
      $username_record = $user[$x];
      $ip_record = $ip[$x];
      $mac_record = $mac[$x];
      $recordmasuk=$this->db->query("INSERT INTO `record` (`nama`, `ip`, `mac_address`) VALUES ('$username_record', '$ip_record', '$mac_record')");
    } test:
  } 
}
?>

<!-- Content View -->
  <div class="row">
   <!-- ./col -->
    <div class="col-xs-12">
    <div class="box box-warning">
       <div class="box-header">
           <i class="fa fa-clipboard" aria-hidden="true"></i>
           <h3 class="box-title text-center">Cek Laporan</h3>
       </div>
       <form action="<?php base_url() ?>Report/laporanterkini" method="POST" enctype="multipart/form-data">
       <div class="form-group">
					<label class="col-sm-2 control-label">Masukkan Tanggal</label>
					<div class="col-sm-10">
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" name="tgl_report" id="datepicker">
						</div>
					</div>
				</div>
        <div>&nbsp</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-send"></i>&nbsp&nbspLihat</button>
				</div>
        </form>
    </div>
    </div>
 </div>

 <div class="row">
   <!-- ./col -->
   <div class="col-xs-12">
    <div class="box box-warning">
       <div class="box-header">
           <i class="fa fa-clipboard" aria-hidden="true"></i>
           <h3 class="box-title text-center">Laporan Saat ini</h3>
       </div>
       <table class="table">
        <tbody>
         <tr>
          <td>User Name</td>
          <td>Mac Address</td>
          <td>IP Address</td>
          <td>Waktu</td>
          <td>Tanggal</td>
         </tr>
        </tbody>
       </table>
    </div>
   </div>
 </div>
</section>
