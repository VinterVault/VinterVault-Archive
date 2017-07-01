<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Vinter Vault</title>
<link href="./files/style.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
</head>
<body>


<div class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container-non-responsive text-center">

</div>
</div>


<div class="maincontain">

<div class="col-xs-12">

<?php
$files = glob('archive_files/*.{php}', GLOB_BRACE);
foreach($files as $file) {
require($file);
echo "<div class='col-xs-4'>";
echo "<a href='".$radiolink."'>";
echo "<img class='image' src=".$imglink." alt='' draggable='false'>";
echo '<div class="details">"'.$displayname.'"</div> </a> </div>';
}
?>



</div>
</div>

</body>
</html>
