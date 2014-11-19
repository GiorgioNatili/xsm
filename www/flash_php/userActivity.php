<?php
/*
activityType:
public static const NEXT_BUTTON:String = 'nextButton';

moduleType:
		public static const IMPORTANT_MODULE:String = 'importantModule';
		public static const CALCULATOR_MODULE:String = 'calculatorModule';
		public static const PROSCONS_MODULE:String = 'prosconsModule';
		public static const TAKE2_MODULE:String = 'take2Module';
		public static const DRAW_LINE_MODULE:String = 'drawLineModule';
		public static const EXPERIENCE_MODULE:String = 'expModule';
		public static const AVATAR_MODULE:String = 'avatarModule';
		public static const HERE_MODULE:String = 'hereModule';
		public static const MY_PAGE_MODULE:String = 'myPageModule';
		public static const WHAT_LIKE_MODULE:String = 'whatLikeModule';
		public static const REGISTRATION_MODULE:String = 'registrationModule';
		public static const SESSION1_COMPLETE_MODULE:String = 'session1CompleteModule';
		public static const SESSION2_COMPLETE_MODULE:String = 'session2CompleteModule';
		public static const LOGOUT_MODULE:String = 'logoutModule';
		public static const LOGIN_MODULE:String = 'loginModule';

userId
*/

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='userActivity';
chdir(FLASH_DIR);
require_once('index.php');

/*
if(isset($_POST['userId']) && intval($_POST['userId']))
{
  $f = fopen('D:/xampp/htdocs/imet/html/cache/activ_'.date('H_i_s').'.txt', 'a');
  foreach($_POST as $key => $value)
  {
    fwrite($f, $key.' => '.$value."\n");
  }
  fclose($f);
}
*/

?>
