<?php $this->pageTitle=Yii::app()->name; ?>

<h1><i><?php echo CHtml::encode(Yii::app()->name); ?></i> for <?php echo $date; ?></h1>
<ul>
<?php foreach ($lines as $line){
	$log_line = new LogLine($line);
	echo '<li>';
	echo '<span class="time">', $log_line->time, '</span> ';
	echo '<span class="speaker">', $log_line->speaker, '</span> ';
	echo '<span class="text ', $log_line->type, '">', $log_line->text, '</span> ';
	echo '</li>';
}?>
</ul>
