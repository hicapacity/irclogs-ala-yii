<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<h2>View Logs For</h2>
<ul>
<?php foreach($dates as $date){
	$l = CHtml::link(CHtml::encode($date), array('logger/view', 'date'=>$date));
	echo '<li><a href="">', $l, '</a></li>';
}?>

<?php if (isset($file)){
	echo $file;
}?>
</ul>
