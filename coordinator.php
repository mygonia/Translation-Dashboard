<?PHP
//---
require('header.php');
require('functions.php');
//---
$gg = '';
//---
$ty = $_REQUEST['ty'];
//---
if (!isset($_REQUEST['nonav'])) {
	echo '
	<div class="row content">
		<div class="col-md-2" style="padding-right:-10px;">
			<h5>coordinator tools</h5>
			<ul class="nav flex-column nav-pills">
				<li id="Home" class="nav-item"><a class="nav-link" href="coordinator.php">Home</a></li>
				<li id="Campaigns" class="nav-item"><a class="nav-link" href="coordinator.php?ty=Campaigns">Campaigns</a></li>
				<li id="process" class="nav-item"><a class="nav-link" href="coordinator.php?ty=Pending">Translations in process</a></li>
				<li id="Emails" class="nav-item"><a class="nav-link" href="coordinator.php?ty=Emails">Emails</a></li>
				<li id="others" class="nav-item"><a class="nav-link" href="coordinator.php?ty=others">Others</a></li>
				<li id="fixwikirefs" class="nav-item"><a target="_blank" class="nav-link" href="../fixwikirefs.php">Fixwikirefs</a></li>
			</ul>
		</div>
		<div class="col-md-10">
		<div class="card">
			<div class="card-body">
	';
};
//---
if ($_GET['test'] != '') {
	// echo(__file__);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
};
//---
$usrs = Array("Mr. Ibrahem", "Doc James");
if (!in_array($username, $usrs)) {
	echo "<meta http-equiv='refresh' content='0; url=index.php'>";
	exit;
};
//---
if (!isset($ty)) {
	require('coordinator/index.php');
	$ty = 'Home';
} else {
	$file = "coordinator/$ty.php";
	if (file_get_contents($file)) {
		require($file);
	} else {
		require('coordinator/404.php');
	};
};
//---
if (isset($ty)) {
	$gg = "<script>$('#" . $ty . "').addClass('active');</script>";
};
//---
echo $gg;
//---
print "
        </div>
      </div>
    </div>
  </div>
</div>
<div>";
//---
require('foter.php');
//---
?>