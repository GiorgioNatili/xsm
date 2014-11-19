<?php
define('WATERMARK_CENTER',1);
define('WATERMARK_BOTTOM_LEFT',2);
define('WATERMARK_BOTTOM_RIGHT',3);
define('WATERMARK_TOP_LEFT',4);
define('WATERMARK_TOP_RIGHT',5);

define('RESIZE_X',1);
define('RESIZE_Y',2);
define('RESIZE_LONGER',3);



/**
 * Skalowane i kadrowanie plików jpg, gif, png
 *
 */
class imageThumb extends projectCommon
{
	public $conn;
	
	private $imageRes;
	
	private $waterMarkInfo=null;
	
	private $imagePath;
	public  $imageWebPath;
	private $imageName;
	private $imageSize;
	private $imageMime;
	private $imageExt;
	public 	$imageX;
	public	$imageY;
	public 	$greyScale=0;
	
	
	public  $resizedX;
	public  $resizedY;
	public $resultLocalPath;
	
	
	private $imageCache;
	
	//
	public $imageExist=0;
	
	
	function __construct($file)
	{
		if($file)
		{
			$this->conn=&$GLOBALS['portal']->conn;
			
			if(is_numeric($file))
			{
				$info = $this->getCMSFileInfo($file);
			}
			else 
			{
				if(substr($file,0,7)=='http://')
				{
					$info=$this->getRemoteFileInfo($file);
				}
				else 
				{
					$info= $this->getLocalFileInfo($file);
				}
			}
			if(!$info)
			{
				$info=$this->getLocalFileInfo(SERVICE_LOCAL.'framework/common/imageGD/noPhoto.jpg');
			}
		
			
			
			if($info)
			{
				$this->imageSize=$info['size'];
				$this->imagePath=$info['file_path'];
				$this->imageWebPath=$info['www_path'];
				$this->imageName=$info['file_name'];
				$this->imageMime=$info['mime'];
				switch($this->imageMime)
				{
					case 'image/gif':
						$this->imageExt='gif';
					break;
					case 'image/jpeg':
					case 'image/pjpeg':
						$this->imageExt='jpg';
					break;
					case 'image/png':
						$this->imageExt='png';
					break;
					default:
						$this->imageExt=$info['ext'];
				}
				$this->imageX=$info['x'];
				$this->imageY=$info['y'];
				$this->imageExist=1;
				
				if($this->getConfigValue('isMourning')==1)
				{
					$this->greyScale=1;
				}
			}
		}
	}
	
	
	
	#
	private function getCachePath($imagePath)
	{
		$depth=0;
		if(defined('CACHE_DEPTH'))
		{
			$depth=CACHE_DEPTH;
		}
		else
		{
			$depth=4;
		}
		
		if($depth>0)
		{
			$pathHash=md5($imagePath);
			$cachePath=substr($pathHash,0,3).'/'.substr($pathHash,3,3).'/'.substr($pathHash,6,3).'/'.substr($pathHash,9,3).'/';
		}
		else 
		{
			$cachePath='';
		}
		return $cachePath;
	}
	#
	private function makeCachePath($cachePath)
	{
		if($cachePath)
		{
			$cacheArray=explode('/',$cachePath);
			$folderExist=0;
			$tempPath='';
			for($i=0;$i<count($cacheArray);$i++)
			{
				$tempPath=CACHE_DIR;
				for($j=0;$j<=$i;$j++)
				{
					$tempPath.=$cacheArray[$j].'/';
				}
				if(!file_exists($tempPath))
				{
					if(FTP_CACHE)
					{
						if(!$this->ftp_MakeDir($tempPath,0777))
						{
							echo $tempPath; exit();
							return false;
						}
					}
					else 
					{
						if(!mkdir($tempPath))
						{
							return false;
						}
					}
				}
			}
		}
		return true;
	}
	#
	private function generateCacheFileName($txtParams)
	{
		$cachePath=$this->getCachePath($this->imagePath);
		
		if($this->makeCachePath($cachePath))
		{
			$cachePath.=md5($this->imageName).'_'.$this->imageSize.'_'.$txtParams;
			if(is_array($this->waterMarkInfo))
			{
				$cachePath.='_wm'.substr(md5(serialize($this->waterMarkInfo)),0,5);
			}
			
			$cachePath.='.'.$this->imageExt;
		}
		return $cachePath;
	}
	#
	private function getImageRes()
	{
		if(defined('GD_MEMORY'))
		{
			ini_set('memory_limit',intval(GD_MEMORY).'M');
		}
		switch($this->imageExt) //type, rozszerzenie
		{
			case 'gif':
				if ($img=imagecreatefromgif($this->imagePath))
				{
					return $img;
				}
			break;
			case 'jpg':
				if ($img=imagecreatefromjpeg($this->imagePath)) 
				{
					return $img;
				}
			break;
			case 'png':
				if ($img=imagecreatefrompng($this->imagePath)) 
				{
					return $img;
				}
			break;
		}
		return false;
	}
	#
	
	
	public function addWaterMark($file,$widthPercent=25,$position=WATERMARK_BOTTOM_LEFT,$alpha=50)
	{
		$this->waterMarkInfo=array(
			'file'=>$file,
			'widthPercent'=>$widthPercent,
			'position'=>$position,
			'alpha'=>$alpha
		);
	}
	
	public function delWaterMark()
	{
		$this->waterMarkInfo=null;
	}
	
	private function setWatermark($imageRes,$orygX,$orygY)
	{
		if(is_array($this->waterMarkInfo))
		{
			if($watermark=imagecreatefromjpeg($this->waterMarkInfo['file']))
			{
				$widthPercent=$this->waterMarkInfo['widthPercent'];
				$watermarkWidth=intval($orygX*($widthPercent/100));
				$waterMarkPercent=intval( ($watermarkWidth*100)/imagesx($watermark) );
				$watermarkHeight=intval(imagesy($watermark)*($waterMarkPercent/100));
				
					
				$watermark2=imagecreatetruecolor($watermarkWidth,$watermarkHeight);
				imagecopyresampled($watermark2,$watermark,0,0,0,0,$watermarkWidth,$watermarkHeight,imagesx($watermark),imagesy($watermark));
					
				$startx=0; $starty=0;
				switch($this->waterMarkInfo['position'])
				{
					case WATERMARK_TOP_LEFT:
						$startx=10; 
						$starty=0;
					break;
					case WATERMARK_TOP_RIGHT:
						$startx=$orygX-10-$watermarkWidth; 
						$starty=10;
					break;
					case WATERMARK_BOTTOM_LEFT:
						$startx=10; 
						$starty=$orygY-10-$watermarkHeight;
					break;
					case WATERMARK_BOTTOM_RIGHT:
						$startx=$orygX-10-$watermarkWidth; 
						$starty=$orygY-10-$watermarkHeight;
					break;
					case WATERMARK_CENTER:
						$startx=intval(($orygX/2)-($watermarkWidth/2));
						$starty=intval(($orygY/2)-($watermarkHeight/2));
					break;
				}
				if($startx and $starty)
				{
					imagecopymerge($imageRes,$watermark2,$startx,$starty,0,0,$watermarkWidth,$watermarkHeight,$this->waterMarkInfo['alpha']);
				}
			}
		}
		return $imageRes;
	}
	#
	
	public function resize($x,$y,$crop='')
	{
		if($this->imageExist)
		{
			if($imgSpecial=$this->isSpecialFile())
			{
				return $imgSpecial;
			}
			
			$txtParams="res_{$x}_{$y}"; if($crop) $txtParams.="_$crop";
			if($this->greyScale) $txtParams.='_bw';
			$cachePath=$this->generateCacheFileName($txtParams);
			
			
			if(file_exists(CACHE_DIR.$cachePath))
			{
				$this->resultLocalPath=CACHE_DIR.$cachePath;
				return CACHE_WWW.$cachePath;
			}
			else 
			{
				if($this->imageRes=$this->getImageRes($this->imagePath))
				{
					$orygX=$this->imageX; 
					$orygY=$this->imageY;
					
					if($crop)
					{
						$crop=explode(',',$crop);
	
						if(count($crop)==6)
						{
							$cropX=$crop[4];
							$cropY=$crop[5];
							$imgTemp=imagecreatetruecolor($cropX,$cropY);
							imagecopyresampled($imgTemp,$this->imageRes,0,0,$crop[0],$crop[1],$cropX,$cropY,$cropX,$cropY);
							$this->imageRes=$imgTemp;
							$orygX=$cropX;
							$orygY=$cropY;	
						}
						
					}
					
					
					if ($x and $y)
					{
						$nx=$x;
						$ny=$y;
					}
					$imgDest=imagecreatetruecolor($nx,$ny);
					$this->processTransparency($imgDest,$this->imageRes);
					
					imagecopyresampled($imgDest,$this->imageRes,0,0,0,0,$nx,$ny,$orygX,$orygY);
					
					if($this->greyScale)
					{
						$imgDest=$this->setGreyScale($imgDest,$nx,$ny);
					}
					$imgDest=$this->setWatermark($imgDest,$nx,$ny);
					
					
					$this->saveImage($imgDest,CACHE_DIR.$cachePath,80);
					
					#imagejpeg($imgDest,CACHE_DIR.$cachePath,80);
					
					$this->resultLocalPath=CACHE_DIR.$cachePath;
					return CACHE_WWW.$cachePath;
				}
				else 
				{
					$this->resultLocalPath=$this->imagePath;
					return $this->imageWebPath;
				}
			}
		}
	}
	#
	
	public function resizeProportional($x,$axe,$crop='')
	{
		if($this->imageExist)
		{
			if($imgSpecial=$this->isSpecialFile())
			{
				return $imgSpecial;
			}
			
			$txtParams="pr_{$x}_{$axe}"; if($crop) $txtParams.="_$crop";
			if($this->greyScale) $txtParams.='_bw';
			$cachePath=$this->generateCacheFileName($txtParams);
			
			if(file_exists(CACHE_DIR.$cachePath))
			{
				$this->resultLocalPath=CACHE_DIR.$cachePath;
				return CACHE_WWW.$cachePath;
			}
			else 
			{
				if($this->imageRes=$this->getImageRes($this->imagePath))
				{
					$orygX=$this->imageX; 
					$orygY=$this->imageY;
					
					if($crop)
					{
						$crop=explode(',',$crop);
	
						if(count($crop)==6)
						{
							$cropX=$crop[4];
							$cropY=$crop[5];
							$imgTemp=imagecreatetruecolor($cropX,$cropY);
							imagecopyresampled($imgTemp,$this->imageRes,0,0,$crop[0],$crop[1],$cropX,$cropY,$cropX,$cropY);
							$this->imageRes=$imgTemp;
							$orygX=$cropX;
							$orygY=$cropY;	
						}
						
					}
					
					
					
					if($axe==RESIZE_LONGER)
					{
						if($orygX>$orygY)
						{
							$axe=RESIZE_X;
						}
						else
						{
							$axe=RESIZE_Y;
						}
					}
					
					if ($x and $axe==RESIZE_X)
					{
						$procent=intval($x*100/$orygX);
						$nx=$x;
						$ny=intval($orygY*($procent/100));
					}
					elseif ($x and $axe==RESIZE_Y)
					{
						$procent=intval($x*100/$orygY);
						$nx=intval($orygX*($procent/100));
						$ny=$x;
					}
					$imgDest=imagecreatetruecolor($nx,$ny);
					$this->processTransparency($imgDest,$this->imageRes);
					
					$this->resizedX=$nx;
					$this->resizedY=$ny;
					
					imagecopyresampled($imgDest,$this->imageRes,0,0,0,0,$nx,$ny,$orygX,$orygY);
					
					
					
					
					
					if($this->greyScale)
					{
						$imgDest=$this->setGreyScale($imgDest,$nx,$ny);
					}
					
					$imgDest=$this->setWatermark($imgDest,$nx,$ny);
					
					$this->saveImage($imgDest,CACHE_DIR.$cachePath,80);
					$this->resultLocalPath=CACHE_DIR.$cachePath;
					return CACHE_WWW.$cachePath;
				}
				else 
				{
					$this->resultLocalPath=$this->imagePath;
					return $this->imageWebPath;
				}
			}
		}
		
	}
	#
	
	
	private function processTransparency(&$imgDest,&$imgSrc)
	{
		if(in_array($this->imageExt,array('gif','png')))
		{
			$transparencyIndex=	imagecolortransparent($imgSrc);	 
			if ($transparencyIndex >= 0) 
			{
				$transparencyColor=@imagecolorsforindex($imgSrc, $transparencyIndex);
				$transparencyIndex = @imagecolorallocate($imgDest, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
				@imagefill($imgDest, 0, 0, $transparencyIndex);
				@imagecolortransparent($imgDest, $transparencyIndex);
			}
			elseif ($this->imageExt=='png') 
			{
		        @imagealphablending($imgDest, false);
				$color = @imagecolorallocatealpha($imgDest, 0, 0, 0, 127);
				@imagefill($imgDest, 0, 0, $color);
				@imagesavealpha($imgDest, true);
			}
		}
	}
	
	public function resizeBoxed($x,$crop='')
	{
		if($this->imageExist)
		{
			if($imgSpecial=$this->isSpecialFile())
			{
				return $imgSpecial;
			}
			
			$txtParams="box_{$x}"; if($crop) $txtParams.="_$crop";
			if($this->greyScale) $txtParams.='_bw';
			$cachePath=$this->generateCacheFileName($txtParams);
			
			if(file_exists(CACHE_DIR.$cachePath))
			{
				$this->resultLocalPath=CACHE_DIR.$cachePath;
				return CACHE_WWW.$cachePath;
			}
			else 
			{
				if($this->imageRes=$this->getImageRes($this->imagePath))
				{
					$orygX=$this->imageX; 
					$orygY=$this->imageY;
					
					if($crop)
					{
						$crop=explode(',',$crop);
	
						if(count($crop)==6)
						{
							$cropX=$crop[4];
							$cropY=$crop[5];
							$imgTemp=imagecreatetruecolor($cropX,$cropY);
							$this->processTransparency($imgTemp,$this->imageRes);
							imagecopyresampled($imgTemp,$this->imageRes,0,0,$crop[0],$crop[1],$cropX,$cropY,$cropX,$cropY);
							$this->imageRes=$imgTemp;
							$orygX=$cropX;
							$orygY=$cropY;				
						}
						
					}
					
					
					$imgDest=imagecreatetruecolor($x,$x);
					$this->processTransparency($imgDest,$this->imageRes);
					
					if($orygX>$orygY)
					{
						$startX=intval(($orygX-$orygY)/2);
						imagecopyresampled($imgDest,$this->imageRes,0,0,$startX,0,$x,$x,$orygY,$orygY);
					}
					elseif($orygX<$orygY)
					{
						$startY=intval(($orygY-$orygX)/2);
						imagecopyresampled($imgDest,$this->imageRes,0,0,0,$startY,$x,$x,$orygX,$orygX);
					}
					else 
					{
						imagecopyresampled($imgDest,$this->imageRes,0,0,0,0,$x,$x,$orygX,$orygX);
					}
					//imagejpeg($imgDest,CACHE_DIR.$cachePath,80);
					
					if($this->greyScale)
					{
						$imgDest=$this->setGreyScale($imgDest,$x,$x);
					}
					
					$this->saveImage($imgDest,CACHE_DIR.$cachePath,80);
					
					$this->resultLocalPath=CACHE_DIR.$cachePath;
					return CACHE_WWW.$cachePath;
				}
				else 
				{
					$this->resultLocalPath=$this->imagePath;
					return $this->imageWebPath;
				}
			}
		}
	}
	#
	
	
	public function resizeAndCropWithRadio($x,$y)
	{
		$crop='';
		if($this->imageExist)
		{
			if($imgSpecial=$this->isSpecialFile())
			{
				return $imgSpecial;
			}
			
			$txtParams="cropratio_{$x}_{$y}"; if($crop) $txtParams.="_$ratio";
			if($this->greyScale) $txtParams.='_bw';
			$cachePath=$this->generateCacheFileName($txtParams);
			
			if(file_exists(CACHE_DIR.$cachePath))
			{
				$this->resultLocalPath=CACHE_DIR.$cachePath;
				return CACHE_WWW.$cachePath;
			}
			else 
			{
				if($this->imageRes=$this->getImageRes($this->imagePath))
				{
					$orygX=$this->imageX; 
					$orygY=$this->imageY;

					if($orygX>$orygY)
					{
						$orygRatio=$orygX/$orygY;
						$newRatio=$x/$y;
						if($orygRatio>$newRatio)
						{
							$cy=$orygY;
							$cx=intval(($orygY/3)*4);
							$start=intval(($orygX-$cx)/2);
							$crop="$start,0,0,0,$cx,$cy";
						}
						
					}
					elseif($orygX<$orygY)
					{
						$orygRatio=$orygX/$orygY;
						$newRatio=$y/$x;
						$x=intval($y*$newRatio);
						
						if($orygRatio>$newRatio)
						{
							$cy=$orygY;
							$cx=intval(($orygY/4)*3);
							$start=intval(($orygX-$cx)/2);
							$crop="$start,0,0,0,$cx,$cy";
						}
					}
					
					if($crop)
					{
						$crop=explode(',',$crop);
	
						if(count($crop)==6)
						{
							$cropX=$crop[4];
							$cropY=$crop[5];
							$imgTemp=imagecreatetruecolor($cropX,$cropY);
							$this->processTransparency($imgTemp,$this->imageRes);
							imagecopyresampled($imgTemp,$this->imageRes,0,0,$crop[0],$crop[1],$cropX,$cropY,$cropX,$cropY);
							$this->imageRes=$imgTemp;
							$orygX=$cropX;
							$orygY=$cropY;	
						}
						
					}
					
					
					if ($x and $y)
					{
						$nx=$x;
						$ny=$y;
					}
					$imgDest=imagecreatetruecolor($nx,$ny);
					$this->processTransparency($imgDest,$this->imageRes);
					imagecopyresampled($imgDest,$this->imageRes,0,0,0,0,$nx,$ny,$orygX,$orygY);
					
					if($this->greyScale)
					{
						$imgDest=$this->setGreyScale($imgDest,$nx,$ny);
					}
					
					$this->saveImage($imgDest,CACHE_DIR.$cachePath,80);
					
					$this->resultLocalPath=CACHE_DIR.$cachePath;
					return CACHE_WWW.$cachePath;
				}
				else 
				{
					$this->resultLocalPath=$this->imagePath;
					return $this->imageWebPath;
				}
			}
		}
		
	}
	
	private function setGreyScale($source,$width,$height)
	{
		$bwimage= imagecreate($width, $height);

		//Creates the 256 color palette
		for ($c=0;$c<256;$c++)
		{
			$palette[$c] = imagecolorallocate($bwimage,$c,$c,$c);
		}

		/*
		//Creates yiq function
		function yiq($r,$g,$b)
		{
			return (($r*0.299)+($g*0.587)+($b*0.114));
		} 
		*/
		
		for ($y=0;$y<$height;$y++)
		{
			for ($x=0;$x<$width;$x++)
			{
				$rgb = imagecolorat($source,$x,$y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				//This is where we actually use yiq to modify our rbg values, and then convert them to our grayscale palette
				//$gs = yiq($r,$g,$b);
				$gs = (($r*0.299)+($g*0.587)+($b*0.114));
				imagesetpixel($bwimage,$x,$y,$palette[$gs]);
			}
		}

		return $bwimage;
		
		
	}
	
	public function resizeInscribed($x,$y,$crop='')
	{
		if($this->imageExist)
		{
			if($imgSpecial=$this->isSpecialFile())
			{
				return $imgSpecial;
			}
			
			$txtParams="ins_{$x}_{$y}"; if($crop) $txtParams.="_$crop";
			if($this->greyScale) $txtParams.='_bw';
			$cachePath=$this->generateCacheFileName($txtParams);
			
			if(file_exists(CACHE_DIR.$cachePath))
			{
				$this->resultLocalPath=CACHE_DIR.$cachePath;
				return CACHE_WWW.$cachePath;
			}
			else 
			{
				if($this->imageRes=$this->getImageRes($this->imagePath))
				{
					//imagealphablending($this->imageRes, true);
					//imagesavealpha($this->imageRes, true);							
			
					$orygX=$this->imageX; 
					$orygY=$this->imageY;
					
					if($crop)
					{
						$crop=explode(',',$crop);
	
						if(count($crop)==6)
						{
							$cropX=$crop[4];
							$cropY=$crop[5];
							$imgTemp=imagecreatetruecolor($cropX,$cropY);
							imagecopyresampled($imgTemp,$this->imageRes,0,0,$crop[0],$crop[1],$cropX,$cropY,$cropX,$cropY);
							$this->imageRes=$imgTemp;
							$orygX=$cropX;
							$orygY=$cropY;				
						}
						
					}
					
					$this->imageRes=$this->setWatermark($this->imageRes,$orygX,$orygY);
					
					
					if($x>0 and $y>0)
					{
						if($x<$orygX)
							$procentX=intval($x*100/$orygX);
						else 
							$procentX=100;
							
						if($y<$orygY)
							$procentY=intval($y*100/$orygY);
						else 
							$procentY=100;
							
						#echo "$procentX - $procentY <br>";
						if($procentX<$procentY)
						{
							$nx=intval($orygX*($procentX/100));
							$ny=intval($orygY*($procentX/100));
						}
						else 
						{
							$nx=intval($orygX*($procentY/100));
							$ny=intval($orygY*($procentY/100));
						}
					}			
					
					$imgDest=imagecreatetruecolor($nx,$ny);
					
					$this->processTransparency($imgDest,$this->imageRes);
					$this->resizedX=$nx;
					$this->resizedY=$ny;
					imagecopyresampled($imgDest,$this->imageRes,0,0,0,0,$nx,$ny,$orygX,$orygY);
					if($this->greyScale)
					{
						$imgDest=$this->setGreyScale($imgDest,$nx,$ny);
					}
					
					$imgDest=$this->setWatermark($imgDest,$nx,$ny);
					
					$this->saveImage($imgDest,CACHE_DIR.$cachePath,80);
					
					$this->resultLocalPath=CACHE_DIR.$cachePath;
					return CACHE_WWW.$cachePath;
				}
				else 
				{
					$this->resultLocalPath=$this->imagePath;
					return $this->imageWebPath;
				}
			}
		}
	}
	
	
	private function saveImage($imgDest,$cacheFile,$quality=80)
	{
		//$imgDest=$this->imageRes;
		if(FTP_CACHE)
		{
			$tempFile=CACHE_DIR.md5($cacheFile).'.'.$this->imageExt;
			switch ($this->imageExt)
			{
				case 'jpg':
					imagejpeg($imgDest,$tempFile,$quality);
				break;
				case 'png':
					imagepng($imgDest,$tempFile);
				break;
				case 'gif':
					imagegif($imgDest,$tempFile);
				break;
			}
			
			if($this->ftp_CopyFile($tempFile,$cacheFile,0777))
			{
				unlink($tempFile);
			}
			
		}
		else 
		{
			switch ($this->imageExt)
			{
				case 'jpg':
					imagejpeg($imgDest,$cacheFile,$quality);
				break;
				case 'png':
					imagepng($imgDest,$cacheFile);
				break;
				case 'gif':
					imagegif($imgDest,$cacheFile);
				break;
			}
		}
		imagedestroy($imgDest);
	}
	
	
	private function ftp_MakeDir($path,$chmod=0)
	{
		#echo $path;
		$success=0;
		if($conn_id = ftp_connect(FTP_SERV))
		{
			if($login_result = ftp_login($conn_id, FTP_USER, FTP_PASS))
			{
				if (ftp_mkdir($conn_id, $path)) 
				{
					if($chmod)
					{
						$x=ftp_chmod($conn_id,$chmod,$path);
					}
					$success=1;
				}
				else
				{
					//$err_msg = "Problem z utworzeniem katalogu \n";
				}
			}
			else 
			{
				$err_msg = "Błąd serwera ftp: Nieprawidłowy login lub hasło \n";
			}
		}
		else 
		{
			$err_msg = "Błąd serwera ftp: Problem z połączeniem \n";
		}
		ftp_close($conn_id);
		return $success;
	}	
	
	
	function ftp_CopyFile($src,$dst,$chmod=0)
	{
		#echo $dst;
		$success=0;
		if($conn_id = ftp_connect(FTP_SERV))
		{
			if($login_result = ftp_login($conn_id, FTP_USER, FTP_PASS))
			{
				if (ftp_put($conn_id, $dst,$src,FTP_BINARY)) 
				{
					if($chmod)
					{
						$x=ftp_chmod($conn_id,$chmod,$dst);
					}
					$success=1;
				}
				else
				{
		 			$err_msg = "Problem z uploadem pliku \n";
				}
			}
			else 
			{
				$err_msg = "Błąd serwera ftp: Nieprawidłowy login lub hasło \n";
			}
		}
		else 
		{
			$err_msg = "Błąd serwera ftp: Problem z połaczeniem \n";
		}
		ftp_close($conn_id);
		return $success;
	}
	
	
	
	private function isSpecialFile()
	{
		
		
		switch($this->imageExt)
		{
			case 'swf':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/flash.gif';
			break;
			case 'odt':
			case 'ods':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/openoffice.gif';
			break;
			case 'xls':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/excel.gif';
			break;
			case 'doc':
			case 'docx':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/word.gif';
			break;
			case 'xls':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/excel.gif';
			break;
			case 'mpg':
			case 'mpeg':
			case 'avi':
			case 'wmv':
			case 'mpg':
			case 'flv':	
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/movie.gif';
			break;
			case 'mp3':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/audio.gif';
			break;
			case 'tiff':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/tiff.gif';
			break;
			case 'pdf':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/acrobat.gif';
			break;
			case 'ppt':
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/ppt.gif';
			break;
			case 'imv':	
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/imv.gif';
			break;
			case 'exe':	
				return SERVICE_WWW.'framework/common/imageGD/filetype_img/exe.gif';
			break;
		}
		
		
	}
	
	public function getImageFileName()
	{
		return $this->imageName;
	}
	public function getImageFileMime()
	{
		return $this->imageMime;
	}
	public function getImageFileSize()
	{
		return $this->imageSize;
	}
	public function getResultLocalFile()
	{
		return $this->resultLocalPath;
	}
}
?>