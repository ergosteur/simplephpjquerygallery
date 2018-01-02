<?php
$dir = 'images/';
$maxi = 2500;
# parse GET arguments
if (empty($_GET)) {
	$page = 0;
	$pageSize = 25;
	}
elseif ($_GET['random']) {
	$pageSize = 1;
}
else {
	$page = $_GET['page'];
	$pageSize = $_GET['pagesize'];
	$json = $_GET['json'];
	}
# open finfo to get mime types
$finfo = new finfo();
# get files in specified directory
$files = preg_grep('/^([^.])/', scandir($dir)); #preg_grep to remove dotfiles https://stackoverflow.com/questions/8532569/exclude-hidden-files-from-scandir
# inject directory/path into files array
foreach ($files as &$value) {
    $value = $dir.$value;
}
unset($value);

# break up array by chunks according to arguments
$pagedFiles = array_chunk($files, $pageSize, true);
# random page case
if ($_GET['random']) {
	$page = rand(0, sizeof($pagedFiles));
}
$i = 0;
$j = 0;

# create pagedFilesObj for json output
$pagedFilesObj->nPages = sizeof($pagedFiles);
$pagedFilesObj->data = $pagedFiles;


//print_r($files);

if ($json == 1 AND $page == 'all') {
	echo json_encode($pagedFilesObj);
}
elseif ($json == 1 AND !is_null($page)) {
	echo json_encode($pagedFiles[$page]);
}
elseif ($json == 0 OR is_null($json)) {
	foreach ($pagedFiles[$page] as &$filename) {
		$i++;
		$fileMimeType = $finfo->file($filename, FILEINFO_MIME_TYPE);
		if (strpos($fileMimeType, "image") !== false AND $i <= $maxi) {
			echo '<a class="swipeboxImg" href="' . $filename . '"><img title="'.$page.'" alt="'. str_replace($dir,"",$filename) . '" src="' . $filename . '" /></a>'; #remove dir from alt-text
			}
			elseif ($i > $maxi) {
				break;
			}
			#print_r($filename . " " . $fileMimeType . "\n");
	}
}
else { echo "nomatch";}
?>
