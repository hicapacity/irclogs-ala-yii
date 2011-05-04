<?php $this->pageTitle=Yii::app()->name; ?>

<h1><i><?php echo CHtml::encode(Yii::app()->name); ?></i> for <?php echo $date; ?></h1>
<ul class="log_lines">
<?php
$last_speaker = null; 
$speaker_list = array();
foreach ($lines as $line){
	$log_line = new LogLine($line);
	if (!in_array($log_line->speaker, $speaker_list)){
		$speaker_list[] = $log_line->speaker;
	}
	$pos = array_search($log_line->speaker, $speaker_list) % 5;
	echo '<li class="speaker', $pos ,'">';
	echo '<span class="time">', $log_line->time, '</span> ';
	echo '<span class="speaker">', $log_line->speaker, '</span> ';
	echo '<span class="text ', $log_line->type, '">', $log_line->text, '</span> ';
	echo '</li>';
}?>
</ul>
