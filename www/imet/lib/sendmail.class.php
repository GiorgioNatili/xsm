<?php
require_once(SERVICE_LOCAL.'lib/smarty/Smarty.class.php');
if(defined('MAIL_SERVER')) 
{
	require_once(SERVICE_LOCAL.'lib/PHPMailer/class.phpmailer.php');
}


class sendmail extends projectCommon 
{
	public $from;
	public $fromName;
	public $to;
	public $toName;
	public $subject;
	public $body;
	public $html=1;
	public $template='';

	private $attachements=array();
	
	
	public $useSMTP=false;
	public $errorMessage;
	
	
	//Mechanizm PHP
	private $photos=''; #zalaczniki 
	private $boundary; #rozdzialacz czesci wiadomosci
	private $boundaryMain;
	
	private $message_src='';
	private $message_header='';
	//Koniec Mechanizm PHP
	
	//Mechanizm SMTP
	public $smtpServer;
	public $smtpPort=25;
	public $smtpAuth=true;
	public $smtpUser;
	public $smtpPassword;
	public $smtpSSL=false;
	public $smtpTLS=false;
	//Koniec Mechanizm SMTP
	
	
	public  $attachNotCmsImages=false;
	public	$unsubscribe_src='';
	
	
	#
	public $smarty_template='';
	public $smarty_assigns=array();
	#
	
	public function __construct()
	{
		if(defined('MAIL_SERVER'))
		{
			$this->useSMTP=true;
			$this->smtpServer=MAIL_SERVER;
			
			if(defined('MAIL_SERVER_PORT')) $this->smtpPort=MAIL_SERVER_PORT;
			if(defined('MAIL_SERVER_AUTH')) $this->smtpAuth=MAIL_SERVER_AUTH;
			if(defined('MAIL_SERVER_USER')) $this->smtpUser=MAIL_SERVER_USER;
			if(defined('MAIL_SERVER_PASSWORD')) $this->smtpPassword=MAIL_SERVER_PASSWORD;
			if(defined('MAIL_SERVER_SSL') and MAIL_SERVER_SSL)
			{
				$this->smtpSSL=true;
			}
			elseif (defined('MAIL_SERVER_TLS') and MAIL_SERVER_TLS)
			{
				$this->smtpTLS=true;
			}
		}
	}
	
	private function process_attachements()
	{
		if($this->fromName and $this->isEmail($this->from))
		{
			$this->from='=?UTF-8?B?'.base64_encode($this->fromName).'?= <'.$this->from.'>';
		}
		
		if($this->toName and $this->isEmail($this->to))
		{
			$this->to='=?UTF-8?B?'.base64_encode($this->toName).'?= <'.$this->to.'>';
		}
		
		$header= "X-Mailer: Emocni.CMS\n";
		$header.= "X-Sender: ". $this->from . "\n";
		$header = "Reply-To: " . $this->from . "\n";	
		$header = "From: " . $this->from . "\n";
		
		
		if($this->template and $template_src=@file_get_contents($this->template))
		{
			$this->boundary = md5(uniqid(rand(), true));
			$this->photos='';
				
			#$header = "From: " . $this->from . "\n";
			#$header.= "Reply-To: " . $this->from . "\n";
			#$header.= "X-Mailer: Emocni.CMS\n";
			#$header.= "X-Sender: ". $this->from . "\n";
			#$header.= "Sender: " . $this->from . "\n";
			$header.= "MIME-version: 1.0\n";
			$header.= "Content-type: multipart/related; ";
			$header.= "boundary=\"{$this->boundary}\"\n";
			$header.= "\n";

			$mail='';
			/*
			//wersja txt
			$mail.= "--{$this->boundary}\n";
			$mail.= "Content-Type: text/plain; charset=\"utf-8\" format=\"flowed\" \n";
			$mail.= "Content-Transfer-Encoding: 7bit\n"; //8
			$mail.= "\n";
			$mail.= "Twój program pocztowy nie obsługuje HTML";
			*/
			//wersja html
			$mail.= "--{$this->boundary}\n";
			$mail.= "Content-Type: text/html; charset=\"utf-8\" format=\"flowed\" \n";
			$mail.= "Content-Transfer-Encoding: 8bit\n";
			$mail.= "\n";
			$mail.= $this->decodeHTML(str_replace('*BODY*',$this->body,$template_src));
			$mail.= "\n\n";
			
			//załączniki/zdjęcia
			$mail.= $this->photos;
			$mail.  "--{$this->boundary}--";
		
			$this->message_src=$mail;
			$this->message_header=$header;
		}
		elseif ($this->smarty_template and file_exists(SERVICE_LOCAL.'templates/'.$this->smarty_template))
		{
			$smarty=new Smarty();
			$smarty->template_dir=SERVICE_LOCAL.'templates';
			$smarty->compile_dir=CACHE_DIR.'template_c';
			$smarty->assign('emailBody',$this->body);
			if(is_array($this->smarty_assigns) and count($this->smarty_assigns)>0)
			{
				$smarty->assign($this->smarty_assigns);
			}
			$this->body=$smarty->fetch($this->smarty_template); 
			#
			$this->boundary = md5(uniqid(rand(), true));
			$this->boundaryMain=md5(uniqid(rand(), true));
			$this->photos='';
			#	
			
			
			#$header= "From: " . $this->from . "\n";
			#$header.= "Reply-To: " . $this->from . "\n";
			#$header.= "X-Mailer: Emocni.CMS\n";
			#$header.= "X-Sender: ". $this->from . "\n";
			#$header.= "Sender: " . $this->from . "\n";
			
			$header.= "MIME-version: 1.0\n";
			$header.= "Content-type: multipart/alternative; ";
			$header.= "boundary=\"{$this->boundaryMain}\"\n";
			$header.= "\n";
			$header.= "This is a multi-part message in MIME format.\n";
			
			
			//$header.= "MIME-version: 1.0\n";
			//$header.= "Content-type: multipart/related; ";
			//$header.= "boundary=\"{$this->boundary}\"\n";
			//$header.= "\n";
			
			$mail='';
			//wersja txt
			$mail.= "--{$this->boundaryMain}\n";
			$mail.= "Content-Type: text/plain; charset=\"utf-8\" format=\"flowed\" \n";
			$mail.= "Content-Transfer-Encoding: 7bit\n"; //8
			$mail.= "\n";
				//$mail.= "Twój program pocztowy nie obsługuje HTML";
				$mail.=strip_tags($this->body);
			$mail.= "\n\n";
			
			$mail.= "--{$this->boundaryMain}\n";
			$mail.= "Content-type: multipart/related; ";
			$mail.= "boundary=\"{$this->boundary}\"\n";
			$mail.= "\n";
			
			//wersja html
			$mail.= "--{$this->boundary}\n";
			$mail.= "Content-Type: text/html; charset=\"utf-8\" format=\"flowed\" \n";
			$mail.= "Content-Transfer-Encoding: 8bit\n";
			$mail.= "\n";
			$mail.= $this->decodeHTML($this->body);
			$mail.= "\n\n";
			//załaczniki zdjęcia
			$mail.= $this->photos;
			
			$mail.= "\n";
			$mail.  "--{$this->boundary}--";
			$mail.= "\n";
			$mail.  "--{$this->boundaryMain}--";
			$mail.= "\n";
			
			$this->message_src=$mail;
			$this->message_header=$header;
		}
		else
		{
			$body='';
			$body.='<html>';
			$body.='<head>';
			$body.='</head>';
			$body.='<body>';
				$body.=$this->body;
			$body.='</body>';
			$body.='</html>';
			
			$this->boundary = md5(uniqid(rand(), true));
			$this->photos='';
				
			$header.= "MIME-version: 1.0\n";
			$header.= "Content-type: multipart/related; ";
			$header.= "boundary=\"{$this->boundary}\"\n";
			$header.= "\n";
			$mail= "--{$this->boundary}\n";
			$mail.= "Content-Type: text/html; charset=\"utf-8\" format=\"flowed\" \n";
			$mail.= "Content-Transfer-Encoding: 8bit\n";
			
			$mail.= "\n";
			$mail.= $this->decodeHTML($body);
			$mail.= "\n\n";
			$mail.= $this->photos;
			$mail.  "--{$this->boundary}--";
		
			$this->message_src=$mail;
			$this->message_header=$header;
			
			/*
			$body='';
			$body.='<html>';
			$body.='<head>';
			$body.='</head>';
			$body.='<body>';
				$body.=$this->body;
			$body.='</body>';
			$body.='</html>';
			
			
			#$header='';
			
			#$header = "From: " . $this->from . "\n";
			#$header = "Reply-To: " . $this->from . "\n";
			#$header.= "X-Mailer: Emocni.CMS\n";
			#$header.= "X-Sender: ". $this->from . "\n";
			#$header.= "Sender: " . $this->from . "\n";
			$header.= "MIME-version: 1.0\n";
			$header.= "Content-Type: text/html; charset=\"utf-8\"\n";
			$header.= "Content-Transfer-Encoding: 8bit\n";
			$header.= "\n";
			$mail=$body;
			$mail.= "\n\n";
			$this->message_src=$mail;
			$this->message_header=$header;
			*/
		}
	}

	private function process_textMessage()
	{
		/*
		$body='';
			$body.='<html>';
			$body.='<head>';
			$body.='</head>';
			$body.='<body>';
				$body.=$this->body;
			$body.='</body>';
			$body.='</html>';
		*/	
			
		if($this->fromName and $this->isEmail($this->from))
		{
			$this->from='=?UTF-8?B?'.base64_encode($this->fromName).'?= <'.$this->from.'>';
		}
		
		if($this->toName and $this->isEmail($this->to))
		{
			$this->to='=?UTF-8?B?'.base64_encode($this->toName).'?= <'.$this->to.'>';
		}
		
		$header='';
		$header.= "X-Mailer: Emocni.CMS\n";
		$header.= "X-Sender: ". $this->from . "\n";
		$header = "From: " . $this->from . "\n";
		$header.= "MIME-version: 1.0\n";
		$header.= "Content-Type: text/plain; charset=\"utf-8\"\n";
		$header.= "Content-Transfer-Encoding: 8bit\n";
		$header.= "\n";
		$mail=strip_tags($this->body);
		$mail.= "\n\n";
		$this->message_src=$mail;
		$this->message_header=$header;
	}

	public function send() 
	{
		$this->errorMessage='';
		
		if($this->useSMTP)
		{
			return $this->smtpSend();
		}
		else
		{
			$subject="=?UTF-8?B?".base64_encode($this->subject)."?=";
			
			if($this->html)
			{
				if($this->message_header=='' or $this->message_src=='')
				{
					$this->process_attachements();
				}	
			}
			else 
			{
				if($this->message_header=='' or $this->message_src=='')
				{
					$this->process_textMessage();
				}
			}
			
			
			if($this->message_header and $this->message_src)
			{
				$message_src='';
				if(strstr($this->message_src,'*UNSUBSCRIBE*'))
				{
					$message_src=str_replace('*UNSUBSCRIBE*',$this->unsubscribe_src,$this->message_src);
				}
				else 
				{
					$message_src=$this->message_src;
				}
				
				if(function_exists('imap_mail'))
				{
					if(imap_mail($this->to,$subject,$message_src,$this->message_header))
						return true;
					else 
						return false;	
				}
				else 
				{
					if(mail($this->to,$subject,$message_src,$this->message_header))
						return true;
					else 
						return false;
				}
			}
			else 
				return false;
		}
	}



	private function decodeHTML($str)
	{
		$str=trim(stripslashes($str));
		
		//gd do obraz�w
		if(strstr($str,'<img'))
		{		
			//wyszukiwanie obrazkow html;
			$imgtags=array();
			$htmlImages=array();
			preg_match_all("|<img[^>]*?>|si",$str,$imgtags);
			for ($i=0;$i<count($imgtags[0]);$i++)
			{
				$src='';
				$id_img=0;
				$width='0';
				$height='0';
				
				if(!($src=$this->getPregValue('|src="[^>]*?"|si',$imgtags[0][$i])))
				{
					$src=$this->getPregValue("|src='[^>]*?'|si",$imgtags[0][$i]);
				}
				$src=str_replace(array('src=','"',"'"),array('','',''),$src);
				
				if(substr($src,0,12)=='getimage.php')
				{
					$id_img=explode('=',$src); $id_img=$id_img[1];
					$id_img=explode('&',$id_img); $id_img=$id_img[0];
					
					if(!($width=$this->getPregValue('|width="[^>]*?"|si',$imgtags[0][$i])))
					{
						$width=$this->getPregValue("|width='[^>]*?'|si",$imgtags[0][$i]);
					}
					$width=intval(str_replace(array('width=','"',"'"),array('','',''),$width));
					
					if(!($height=$this->getPregValue('|height="[^>]*?"|si',$imgtags[0][$i])))
					{
						$height=$this->getPregValue("|height='[^>]*?'|si",$imgtags[0][$i]);
					}
					$height=intval(str_replace(array('height=','"',"'"),array('','',''),$height));
					$new_src='';
					if($src and $id_img  and ($width or $height))
					{
						$im=new imageThumb($id_img);
						$img='';
						if($width and $height)
						{
							$img=$im->resize($width,$height);
						}
						elseif ($width)
						{
							$img=$im->resizeProportional($width,RESIZE_X);
						}
						elseif ($height)
						{
							$img=$im->resizeProportional($height,RESIZE_Y);
						}
						//if($img=$this->getImgPathDB($id_img,$width,$height))
						if($img)
						{
							$this->photos.=$this->attachment($img,$cid);
							$new_src="cid:$cid";
						}
					}
					if($new_src)
					{
						$newImg=str_replace($src,$new_src,$imgtags[0][$i]);
						$str=str_replace($imgtags[0][$i],$newImg,$str);
					}
				}
				elseif($this->attachNotCmsImages) //załaczenie zwykłego obrazka
				{
					$new_src='';
					if($src)
					{
						$this->photos.=$this->attachment($src,$cid);
						$new_src="cid:$cid";
					}
					if($new_src)
					{
						$newImg=str_replace($src,$new_src,$imgtags[0][$i]);
						$str=str_replace($imgtags[0][$i],$newImg,$str);
					}
				}
			}
		}
		
		return $str;
	}
	/*
	private function getPregValue($pattern,$string)
	{
		$par=array();
		preg_match($pattern,$string,$par);
		if(isset($par[0]) and $par[0]!='')
			return $par[0];		
		else 
			return '';
	}
	*/
	
	private  function attachment($file,&$cid) 
	{
 		$str='';
		if($plik=@file_get_contents($file))
		{
			$encoded = chunk_split(base64_encode($plik));
			$str="--{$this->boundary}\n";
			$str.="Content-Type: " . $this->getimagetype($file) ."\n";	
			$filename=md5(uniqid(rand(), true));
			$str.="Content-Transfer-Encoding: base64\n";
			$str.="Content-Disposition: inline; filename=\"" .$filename  . "\"\n";
			$cid=md5($file);
			$str.="Content-ID: <$cid>\n\n";
			$str.=$encoded;
		}
		return $str;
	}	 
	
	
	
	
	
	public function attachFile($filePath,$fileName='',$encoding='',$type='')
	{
		if($this->useSMTP)
		{
			if(file_exists($filePath) and is_file($filePath))
			{
				
				$this->attachements[]=array(
					'name'=>$fileName,
					'path'=>$filePath,
				);
				return 1;
			}
			else
			{
				return 0;
			}			
			
		}
	}
	
	
	private function getimagetype($file)
	{
		if (strpos($file,'.jpg')==strlen($file)-4)
			return "image/jpeg";	
		if (strpos($file,'.jpeg')==strlen($file)-5)
			return "image/jpeg";	
		if (strpos($file,'.jpe')==strlen($file)-4)
			return "image/jpeg";	
		elseif (strpos($file,'.gif')==strlen($file)-4)
			return "image/gif";	
		elseif (strpos($file,'.png')==strlen($file)-4)
			return "image/png";
		else 
			return "image/gif";	
	}

	//mechanizm smtp
	private function smtpSend()
	{
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		try 
		{
			$mail->Host       = $this->smtpServer; // SMTP server
		  	//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		  	$mail->SMTPAuth   = $this->smtpAuth;                  // enable SMTP authentication
		  	$mail->Host       = $this->smtpServer; // sets the SMTP server
		  	$mail->Port       = $this->smtpPort;                    // set the SMTP port for the GMAIL server
		  	if($this->smtpSSL)
		  	{
		  		$mail->SMTPSecure='ssl';
		  	}
		  	elseif($this->smtpTLS)
		  	{
		  		$mail->SMTPSecure='tls';
		  	}
		  	$mail->Username   = $this->smtpUser; // SMTP account username
		  	$mail->Password   = $this->smtpPassword; // SMTP account password
		  
			$mail->AddReplyTo($this->from, $this->fromName);
		  	$mail->AddAddress($this->to, $this->toName);
		  	if($this->smtpAuth and $this->isEmail($this->smtpUser))
		  	{
		  		$mail->SetFrom($this->smtpUser,$this->fromName);
			}
			else
			{
				$mail->SetFrom($this->from, $this->fromName);
			}
			
			$mail->CharSet='utf-8';
		  	$mail->Subject = $this->subject;
		  	
		  	if(count($this->attachements))
		  	{
		  		foreach($this->attachements as $attachement)
		  		{
		  			$mail->AddAttachment($attachement['path'],$attachement['name']);
		  		}
		  	}
		  	
		  	
		  	if($this->html)
		  	{
				$this->smtpProcessHtmlImages($mail);
		  		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		  		$mail->MsgHTML($this->body);
		  		
		  	}
		  	else 
		  	{
		  		$mail->Body=strip_tags($this->body);
		  	}
		  	$mail->Send();
		  	//echo "Message Sent OK</p>\n";
		  	return true;
		} 
		catch (phpmailerException $e) 
		{
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			$this->errorMessage=$e->errorMessage();
		  	return false;
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage(); //Boring error messages from anything else!
			$this->errorMessage=$e->errorMessage();
			return false;
		}
		
		
		
		
	}
	
	private function smtpProcessHtmlImages(&$mailer)
	{
		$str='';
		if($this->template and $template_src=@file_get_contents($this->template))
		{
			$str=str_replace('*BODY*',$this->body,$template_src);
		}
		elseif ($this->smarty_template and file_exists(SERVICE_LOCAL.'templates/'.$this->smarty_template))
		{
			$smarty=new Smarty();
			$smarty->template_dir=SERVICE_LOCAL.'templates';
			$smarty->compile_dir=CACHE_DIR.'template_c';
			$smarty->assign('emailBody',$this->body);
			if(is_array($this->smarty_assigns) and count($this->smarty_assigns)>0)
			{
				$smarty->assign($this->smarty_assigns);
			}
			$str=$smarty->fetch($this->smarty_template); 
		}
		else 
		{
			$str=$this->body;
		}
		
		
		
		if(strstr($str,'<img'))
		{		
			//wyszukiwanie obrazkow html;
			$imgtags=array();
			$htmlImages=array();
			preg_match_all("|<img[^>]*?>|si",$str,$imgtags);
			for ($i=0;$i<count($imgtags[0]);$i++)
			{
				$src='';
				$id_img=0;
				$width='0';
				$height='0';
				
				if(!($src=$this->getPregValue('|src="[^>]*?"|si',$imgtags[0][$i])))
				{
					$src=$this->getPregValue("|src='[^>]*?'|si",$imgtags[0][$i]);
				}
				$src=str_replace(array('src=','"',"'"),array('','',''),$src);
				
				if(!($width=$this->getPregValue('|width="[^>]*?"|si',$imgtags[0][$i])))
				{
					$width=$this->getPregValue("|width='[^>]*?'|si",$imgtags[0][$i]);
				}
				$width=intval(str_replace(array('width=','"',"'"),array('','',''),$width));
					
				if(!($height=$this->getPregValue('|height="[^>]*?"|si',$imgtags[0][$i])))
				{
					$height=$this->getPregValue("|height='[^>]*?'|si",$imgtags[0][$i]);
				}
				$height=intval(str_replace(array('height=','"',"'"),array('','',''),$height));
					
				//echo $src.'<br/>';
				
				if(substr($src,0,12)=='getimage.php')
				{
					$id_img=explode('=',$src); $id_img=$id_img[1];
					$id_img=explode('&',$id_img); $id_img=$id_img[0];
					
					$new_src='';
					if($src and $id_img)
					{
						$cid=$this->createCID($src);
						$im=new imageThumb($id_img);
						if($im->imageExist)
						{
							if($width and $height)
							{
								$im->resize($width,$height);
							}
							elseif ($width)
							{
								$im->resizeProportional($width,RESIZE_X);
							}
							elseif ($height)
							{
								$im->resizeProportional($height,RESIZE_Y);
							}
							
							//if($img=$this->getImgPathDB($id_img,$width,$height))
							if($resultFile=$im->getResultLocalFile())
							{
								if($mailer->AddEmbeddedImage($resultFile,$cid,$im->getImageFileName(),'base64',$im->getImageFileMime()))
								{
									$new_src="cid:$cid";
								}
							}
							else
							{
								$file = $this->getCMSFileInfo($id_img);
								if($mailer->AddEmbeddedImage($file['file_path'],$cid,$im->getImageFileName(),'base64',$im->getImageFileMime()))
								{
									$new_src="cid:$cid";
								}
							}
						}
					}
					if($new_src)
					{
						$newImg=str_replace($src,$new_src,$imgtags[0][$i]);
						$str=str_replace($imgtags[0][$i],$newImg,$str);
					}
				}
				elseif($this->attachNotCmsImages) //załaczenie zwykłego obrazka
				{
					$new_src='';
					if($src)
					{
						$cid=$this->createCID($src);
						
						$im=new imageThumb($src);
						if($im->imageExist)
						{
							if(!$width and !$height)
							{
								$width=$im->imageX;
								$height=$im->imageY;
							}
								
							if($width and $height)
							{
								$im->resize($width,$height);
							}
							elseif($width)
							{
								$im->resizeProportional($width,RESIZE_X);
							}
							elseif($height)
							{
								$im->resizeProportional($height,RESIZE_Y);
							}
							
							if($resultFile=$im->getResultLocalFile())
							{
								if($mailer->AddEmbeddedImage($resultFile,$cid,$im->getImageFileName(),'base64',$im->getImageFileMime()))
								{
									$new_src="cid:$cid";
								}
							}
						}
					}
					if($new_src)
					{
						$newImg=str_replace($src,$new_src,$imgtags[0][$i]);
						$str=str_replace($imgtags[0][$i],$newImg,$str);
					}
				}
			}
		}
		
		$this->body=$str;
	}
	
	
	private function createCID($filePath)
	{
		return md5($filePath);
	}
	
	
	
}
?>