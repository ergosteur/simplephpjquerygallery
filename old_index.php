<html>
<head>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="initial-scale=1.0">
<script src="src/js/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="src/css/justifiedGallery.min.css" />
<script src="src/js/jquery.justifiedGallery.min.js"></script>
<script src="src/js/jquery.swipebox.min.js"></script>
<link rel="stylesheet" href="src/css/swipebox.maximgsize.css">
<style>
.button {
    padding: 10px 10px;
    text-align: center;
    text-decoration: none;
    display: block;
    font-size: 16px;
    width: 200px;
    margin: auto;
    cursor: pointer;
}
</style>
</head>
<?php
$dir = '.';
$maxi = 2500;
$pageSize = 10;

$files = scandir($dir);
$finfo = new finfo();
$pagedFiles = array_chunk($files, $pageSize, true);
$i = 0;
$page = $_POST['page'];
//print_r($files);
?>
<body>
<div id="gallery">
<?php
foreach ($pagedFiles[0] as &$filename) {
	$i++;
	$fileMimeType = $finfo->file($path . $filename, FILEINFO_MIME_TYPE);
	if ($fileMimeType == "image/gif" AND $i <= $maxi) {
		echo '<a class="swipeboxImg" href="' . $filename . '"><img alt="'. $filename . '" src="' . $filename . '" /></a>';
		}
	elseif ($i > $maxi) {
		break;
		}
	#print_r($filename . " " . $fileMimeType . "\n");
	}
?>
</div>
<div><input type="button" class="button" value="Load more..." /></div>
<script>
var jsPage = 1;
$("#gallery").justifiedGallery().on('jg.complete', function () {
    $('.swipeboxImg').swipebox();
});
$(":button").click(function() {
	//alert("click!");
	$.get('paginate.php', {page: jsPage, pagesize: <?php echo $pageSize; ?>})
		.done(function (data) {
			$('#gallery').append(data);
			//alert( "Data Loaded: " + data );
		});
    $('#gallery').justifiedGallery('norewind');
    jsPage++;
});
</script>
</body>
</html>
