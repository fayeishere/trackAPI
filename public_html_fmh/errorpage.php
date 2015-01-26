<?php
	require_once $_SERVER['DOCUMENT_ROOT']. "/globals.php";
	$vendor = "fmh";

	/**
	* FileMaker PHP Site Assistant Generated File
	*/
	global $errormessage;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Status Error - Global Resources Tracking - Portland Oregon</title>
  <meta name="robots" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="author" content="Heath@HeathSchweitzer.com" />
  <link href="/css/style.css" rel="stylesheet" type="text/css" />
  <!--[if lte IE 7]><link href="/css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
  <script type="text/javascript" src="/js/jquery.js"></script>
  <!--[if IE 6]>
  <script type="text/javascript" src="/js/ie6pngfix.js"></script>
  <script type="text/javascript">
    DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6, span, input, textarea, td');
  </script>
  <![endif]-->
</head>

<body>

<!-- wrapper -->
<div class="siwpr">

  <!-- header -->
  <?php include($_SERVER['DOCUMENT_ROOT'] ."/header.php"); ?>

  <!-- main body -->
  <div id="mainbody">
  
  <!-- error message -->
  <div class="track_delivery">
    <h1>Error:</h1>
    <p><?php echo $errormessage ?></p>
    <p>Please check your Tracking Number and <a href="http://www.fmhtracking.com/">try again</a>.</p>
  </div>
  <!-- / error message -->
  
  </div>
  <!-- / main body -->

  <!-- bottom links -->
  <?php include($_SERVER['DOCUMENT_ROOT'] ."/bottomlinks.php"); ?>
  <!-- / bottom links -->

</div>
<!-- / wrapper -->

<!-- footer -->
<?php include($_SERVER['DOCUMENT_ROOT'] ."/footer.php"); ?>
<!-- / footer -->
</body>
</html>