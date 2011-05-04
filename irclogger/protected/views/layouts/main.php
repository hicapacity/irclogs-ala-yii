<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="container" id="page">
	<div id="header">
		<div id="logo"><a href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a></div>
	</div><!-- header -->
	<div id="mainmenu">
	</div><!-- mainmenu -->
	<?php echo $content; ?>
	<div id="footer">
		<p>Made for HiCapacity</p>
	</div><!-- footer -->
</div><!-- page -->
</body>
</html>
