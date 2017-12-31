<?php
$dir = 'images/';
$maxi = 2500;
if (empty($_GET)) {
	$page = 0;
	$pageSize = 25;
	}
else {
	$page = $_GET['page'];
	$pageSize = $_GET['pagesize'];
	}

$files = scandir($dir);
$finfo = new finfo();
$pagedFiles = array_chunk($files, $pageSize, true);
$i = 0;

//print_r($files);
?>
<?php //echo json_encode($pagedFiles[$page]);
foreach ($pagedFiles[$page] as &$filename) {
	$i++;
	$fileMimeType = $finfo->file($dir . $filename, FILEINFO_MIME_TYPE);
	if (strpos($fileMimeType, "image") !== false AND $i <= $maxi) {
		echo '<a class="swipeboxImg" href="' . $dir . $filename . '"><img alt="'. $filename . '" src="' . $dir . $filename . '" /></a>';
		}
	elseif ($i > $maxi) {
		break;
		}
	#print_r($filename . " " . $fileMimeType . "\n");
	} 
?>
