<?php

class LoggerController extends Controller{
	public function actions(){
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex(){
		$model = new LogsModel;
		$dates = $model->getLogDates();
		$this->render('index', array('dates'=>$dates));
	}

	public function actionView($date){
		$model = new LogsModel;
		if (!$model->validateDate($date)){
			die('lol that don\'t look right');
		}
		$file = $model->getLogFromDate($date);
		$dates = $model->getLogDates();
		$this->render('view', array('date'=>$date, 'lines'=>$file->getLines()));
	}

	public function actionError(){
		if($error=Yii::app()->errorHandler->error){
		 	if(Yii::app()->request->isAjaxRequest){
		 		echo $error['message'];
			}else{
				$this->render('error', $error);
			}
		}
	}
}
