<?php

class ProfilesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'register' action
				'actions'=>array('register', 'verifyRegistration', 'captcha', 'languageChanged', 'displaySavedImage'),
				'users'=>array('*'),
			),
			array('allow',  // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the register page
			'captcha'=>array(
				//'class'=>'CCaptchaAction',
            //'class'=>'CaptchaAction',
            'class'=>'CaptchaExtendedAction',
            //'minLength' => 1,
            //'maxLength' => 10,
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->checkRenderAjax('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	
	public function actionUploadImage(){
		$id = $_GET['id'];
		
		$Session_Profiles_Backup = Yii::app()->session['Profiles_Backup'];
		if (isset($Session_Profiles_Backup)){
			$oldmodel = $Session_Profiles_Backup;
		}
		if (isset($id)){
			if (!isset($oldmodel) || $oldmodel->PRF_UID != $id){
				$oldmodel = $this->loadModel($id, true);
			}
		}
		
		if (isset($oldmodel)){
			$model = $oldmodel;
			$oldPicture = $oldmodel->PRF_IMG;
		} else {
			$model=new Profiles;
			$oldPicture = null;
		}
		
		if(isset($_POST['Profiles'])){
			$model->attributes=$_POST['Profiles'];
			$sucessfull = Functions::uploadPicture($model,'PRF_IMG');
			Yii::app()->session['Profiles_Backup'] = $model;
			
			if ($sucessfull){
				echo "{imageId:'backup'}";
				exit;
			} else {
				echo "{error:'nofile'}";
				exit;
			}
		} else {
			echo "{error:'nodata'}";
			exit;
		}
	}
	
	private function prepareCreateOrUpdate($id, $view){
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$Session_Profiles_Backup = Yii::app()->session['Profiles_Backup'];
		if (isset($Session_Profiles_Backup)){
			$oldmodel = $Session_Profiles_Backup;
		}
		if (isset($id)){
			if (!isset($oldmodel) || $oldmodel->PRF_UID != $id){
				$oldmodel = $this->loadModel($id, true);
			}
		}
		
		if (isset($oldmodel)){
			$model = $oldmodel;
		} else {
			$model=new Profiles;
		}
		if (isset($id) && $id != Yii::app()->user->id){
			throw new CHttpException(403,'It\'s not allowed to change profile of other user.');
		}
		if(isset($_POST['Profiles'])) {
			$model->attributes=$_POST['Profiles'];
			
			Functions::updatePicture($model,'PRF_IMG', $oldPicture);
			
			Yii::app()->session['Profiles_Backup'] = $model;
			if (isset($model->new_pw) && $model->new_pw != ''){
				$model->setScenario('pw_change');
			} else {
				$model->setScenario('insert');
			}
			if($model->validate()){
				if (isset($model->new_pw) && $model->new_pw != ''){
					$model->PRF_PW = crypt($model->new_pw, Randomness::blowfishSalt());
				}
				if ($model->PRF_LOC_GPS_LAT != '' && $model->PRF_LOC_GPS_LNG != '' ){
					$model->PRF_LOC_GPS_POINT = 'POINT(' . $model->PRF_LOC_GPS_LAT . ' ' . $model->PRF_LOC_GPS_LNG . ')';
				} else {
					$model->PRF_LOC_GPS_POINT = null;
				}
				
				if($model->save(false)){
					unset(Yii::app()->session['Profiles_Backup']);
					if($this->useAjaxLinks){
						echo "{hash:'" . $this->createUrlHash('view', array('id'=>$model->PRF_UID)) . "'}";
						exit;
					} else {
						$this->redirect(array('view', 'id'=>$model->PRF_UID));
					}
				}
			}
		}

		$this->checkRenderAjax($view,array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->prepareCreateOrUpdate(null, 'create');
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->prepareCreateOrUpdate($id, 'update');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Profiles');
		$this->checkRenderAjax('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Profiles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Profiles']))
			$model->attributes=$_GET['Profiles'];

		$this->checkRenderAjax('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Displays the register page
	 */
	public function actionRegister() 
	{ 
		//$arg = $hash;
		$Session_Profiles_Backup = Yii::app()->session['Profiles_Backup'];
		if (isset($Session_Profiles_Backup)){
			$model = $Session_Profiles_Backup;
		} else {
			$model=new Profiles('register');
		}
		// uncomment the following code to enable ajax-based validation 
		if(isset($_POST['ajax']) && $_POST['ajax']==='profiles-register-form') { 
			echo CActiveForm::validate($model); 
			Yii::app()->end(); 
		}
		if(isset($_POST['Profiles'])) 
		{
			$model->attributes=$_POST['Profiles'];
			Yii::app()->session['Profiles_Backup'] = $model;
			if($model->validate()) {
				// all entered values are valid and no constraint has been violated
				
				// set default values
				$model->PRF_ACTIVE = 0;

				// generate random number for registration link:: needs to be unique
				$model->PRF_RND = Randomness::blowfishSalt();
				//$found = Profiles::model()->findByAttributes(array('PRF_RND'=>$model->PRF_RND));
		 //       while($found !== null) {
		 //          $model->PRF_RND = Randomness::blowfishSalt();
		 //          $found = Profiles::model()->findByAttributes(array('PRF_RND'=>$model->PRF_RND));
		 //       }
				
				// encrypt password
				$model->PRF_PW = crypt($model->PRF_PW, Randomness::blowfishSalt());
				
				// prepare encryption
				//$iterations = 0;
				
				// generate random number for salt and apply repeated crypt as hash to
				// reduce reversed brute-force decryption
				//$model->PRF_SALT = Randomness::blowfishSalt();
				//$model->PRF_PW = crypt($model->PRF_PW, $model->PRF_SALT);
				//for($i = 1; $i < $iterations; $i++) {
				//	$hash = crypt($hash . $password, $salt);
				//}
				if($model->save(false)) { //false = not validate again
					unset(Yii::app()->session['Profiles_Backup']);
					// no errors occured during save, send verification mail & and post message
					$subject = 'EveryCook Verification Mail';
					$body = "Tank you for your registration. Please follow the following link for registration verification.\n".CController::createUrl("Profiles/VerifyRegistration/", array("hash"=>$model->PRF_RND));
					$headers="From: {".Yii::app()->params['adminEmail']."}\r\nReply-To: {".Yii::app()->params['adminEmail']."}";
					
					mail($model->PRF_EMAIL,$subject,$body,$headers);//Yii::app()->params['adminEmail']
					
					Yii::app()->user->setFlash('register','Thank you for your registration. A verification mail has been sent to your email address '.$model->PRF_EMAIL.'. Please check your emails for verification of your EveryCook account.');
					
					
					// set the session language to the newly chosen one
					Yii::app()->session['lang'] = $model->PRF_LANG;
					
					// refresh the page to show the flash message
					$this->refresh();
					
					//$this->redirect(array('view','id'=>$model->PRF_UID));
				}
			} else {
				//print_r($model->getErrors());
			}
		}
		//$this->render('register',array('model'=>$model));
		$this->checkRenderAjax('register',array('model'=>$model,));
	}

   /*
    * Verifies registration and activates the user profile
    */
   public function actionVerifyRegistration()
   {
      // get hash code from url
      $hash = Yii::app()->getRequest()->getQuery('hash');
      // activate account
      $model = Profiles::model()->findByAttributes(array('PRF_RND'=>$hash));
      if($model!==null){
         $model->PRF_ACTIVE = '1';
         $model->save();
			Yii::app()->user->setFlash('register','Thank you for your verification. You can now login using the following link.');
//$this->refresh();
      }
      $this->checkRenderAjax('register',array('model'=>$model,));
   }

   /*
    * Changes to the selected language
    */
   public function actionLanguageChanged()
   {
      Yii::app()->session['lang'] = $_GET['lang'];
      self::$trans=new Translations(Yii::app()->session['lang']);
      $model=new Profiles('register');;
      $model->PRF_LANG = $_GET['lang'];
	  
	  Yii::app()->session['Profiles_Backup'] = $model;

	  $this->redirect(array('register'));
   }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		if ($id != Yii::app()->user->id){
			throw new CHttpException(403,'It\'s not allowed to open profile of other user.');
		}
		$model=Profiles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='profiles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
    public function actionDisplaySavedImage($id, $ext)
    {
		$model=$this->loadModel($id, true);
		$modified = $model->CHANGED_ON;
		if (!$modified){
			$modified = $model->CREATED_ON;
		}
		return Functions::getImage($modified, $model->PRF_IMG_ETAG, $model->PRF_IMG, $id);
    }
	
	/**
	 * Sends a verification mail to the newly created user.
	 * @param integer the ID o
	 */
}
