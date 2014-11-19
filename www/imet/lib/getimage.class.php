<?php
require_once(SERVICE_LOCAL.'projectCommon.class.php');

class getimage extends projectCommon
{
	public $conn;
	
	function __construct()
	{
		$GLOBALS['portal'] = &$this;
		
		if($this->conn=$this->connectDB())
		{
			$id_image=intval($this->getGET('id'));
			$x=intval($this->getGET('x'));
			$y=intval($this->getGET('y'));
			$l=intval($this->getGET('l'));
			$box=intval($this->getGET('box'));
			$rc=intval($this->getGET('rc')); //resize cropped
			$ri=intval($this->getGET('ri')); //resize inscribed
			$crop=$this->getGET('crop');
			if($x==0 and $y==0) $nocache=1; else $nocache=0;
			if($id_image )
			{
				$imageThunb=new imageThumb($id_image);
				if($imageThunb->imageExist)
				{
					$img='';
					if($rc and $x and $y)
					{
						$img=$imageThunb->resizeAndCropWithRadio($x,$y);
					}
					if($ri and $x and $y)
					{
						$img=$imageThunb->resizeInscribed($x,$y);
					}
					elseif ($x and $y)
					{
						$img=$imageThunb->resize($x,$y,$crop);
					}
					elseif ($x)
					{
						$img=$imageThunb->resizeProportional($x,RESIZE_X,$crop);
					}
					elseif ($y)
					{
						$img=$imageThunb->resizeProportional($y,RESIZE_Y,$crop);
					}
					elseif ($l)
					{
						$img=$imageThunb->resizeProportional($l,RESIZE_LONGER,$crop);
					}
					elseif ($box)
					{
						$img=$imageThunb->resizeBoxed($box,$crop);
					}
					elseif($info=$this->getCMSFileInfo($id_image))
					{
						$img=$info['www_path'];
					}
						
					if($img)
					{
						header("Location:$img");
					}
				}
			}
		}
	}	
}


?>