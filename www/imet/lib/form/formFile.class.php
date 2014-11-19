<?php
class formFile extends projectCommon
{
	public $name='';
	public $id='';
	public $cssClass='';
	public $cssStyle='';
	public $errClass='';
	public $errStyle='';
	public $required=false;
	
	public $fieldSize=0;
		
	public $maxlength='0';
	public $allowed_extensions=array();
	public $allowed_mimes=array();
	public $allowed_fileSize=0;
	

	
	public $uploaded_fileName='';
	public $uploaded_fileSize='';
	public $uploaded_fileMime='';
	public $uploaded_fileExtension='';
	public $uploaded_filePath=''; 
	
	
	#public $onFocus='';
	#public $onBlur='';
	#public $onChange='';
		
	public $disabled=false;
	public $readOnly=false;
	
	//błedy
	public $error=0;
	public $error_noFile=0;
	public $error_fileSize=0;
	public $error_fileMime=0;
	public $error_fileExtension=0;
	public $errMsg='';
	
	
	public $isSubmitted=false;
	
	public $tabIndex=0;
	
	private $form;
	
	function __construct(&$form,$name,$required,$cssStyle,$cssClass,$errStyle,$errClass)
	{
		$this->name=$name;
		$this->required=$required;
		$this->cssClass=$cssClass;
		$this->cssStyle=$cssStyle;
		$this->errClass=$errClass;
		$this->errStyle=$errStyle;
		
		if(!$this->errClass and !$this->errStyle)
		{
			$this->errStyle='border:1px solid red;';
		}
		
				
		$this->form=$form;
		$this->autoComplete=$this->form->autoComplete;
		$this->form->upload=true;
		
		if(!$this->allowed_fileSize)
		{
			$max_post=$this->getMaxPost();
			$max_upload=$this->getMaxUpload();
			if($max_post<$max_upload)
			{
				$this->allowed_filesize=$max_post;
			}
			else 
			{
				$this->allowed_filesize=$max_upload;
			}
			
		}		
		
		$form->add_component($this);
	}
	
	public function init()
	{
		if($this->form->isSubmitted())
		{
			if(isset($_FILES[$this->name]))
			{
				$file=$_FILES[$this->name];
				if(!$file['error'])
				{
					$this->uploaded_fileName=$file['name'];
					$this->uploaded_fileSize=$file['size'];
					if(version_compare(PHP_VERSION, '5.3.0') >= 0 && function_exists('finfo_open'))
					{
						$finfo = finfo_open(FILEINFO_MIME_TYPE); 
						$this->uploaded_fileMime = finfo_file($finfo, $file['tmp_name']);
					}
					else
					{
						$this->uploaded_fileMime = @mime_content_type($file['tmp_name']);
					}
					$this->uploaded_filePath=$file['tmp_name'];
					$this->uploaded_fileExtension=$this->getFileExtension($this->uploaded_fileName);
					
					if($this->allowed_fileSize and $this->uploaded_fileSize>$this->allowed_fileSize)
					{
						$this->error=1; 
						$this->error_fileSize=1;
					}
					
					if(is_array($this->allowed_extensions) and count($this->allowed_extensions)>0)
					{
						if(!in_array($this->uploaded_fileExtension,$this->allowed_extensions))
						{
							$this->error=1;
							$this->error_fileExtension=1;
						}
					}
					if(is_array($this->allowed_mimes) and count($this->allowed_mimes)>0)
					{
						if(!in_array($this->uploaded_fileMime,$this->allowed_mimes))
						{
							$this->error=1;
							$this->error_fileMime=1;
						}
					}
				}
				elseif($this->required)
				{
					$this->error=1;
					$this->error_noFile=1;
				}
			}
			elseif($this->required)
			{
				$this->error=1;
				$this->error_noFile=1;
			}
			
			$this->isSubmitted=true;
		}
	}
	
	public function show()
	{
		$html='';
		
		$html.='<input type="file" ';
			if($this->name) $html.='name="'.$this->name.'" ';
			if($this->id) $html.='id="'.$this->id.'" ';
			
			if($this->fieldSize>0) $html.='size="'.$this->fieldSize.'" ';
			
			if($this->cssStyle or $this->errStyle) 
			{
				$html.='style="';
					if($this->cssStyle) $html.=$this->cssStyle;
					if($this->error and $this->errStyle) $html.=$this->errStyle;
				$html.='" ';
			}
			if($this->cssClass or $this->errClass) 
			{
				$html.='class="';
					if($this->cssClass) $html.=$this->cssClass;
					if($this->error and $this->errClass) 
					{	
						if($this->cssClass) $html.=' ';
						$html.=$this->errClass;
					}
				$html.='" ';
			}
			
			
			if($this->disabled)
			{
				$html.=' disabled="disabled"';
			}
			if($this->readOnly)
			{
				$html.=' readonly="readonly"';
			}
			if($this->tabIndex)
			{
				$html.=' tabindex="'.$this->tabIndex.'"';
			}
			
		$html.='/>';
		return $html;
	}
	
	
	private function getMaxUpload()
	{
		$max_upload=ini_get('upload_max_filesize');
		if(is_numeric($max_upload))
		{
			return $max_upload;
		}
		else
		{
			return $this->convertPhpIniNumbuer($max_upload);	
		}
		return 0;
	}
	
	private function getMaxPost()
	{
		$max_post=ini_get('post_max_size');
		if(is_numeric($max_post))
		{
			return $max_post;
		}
		else
		{
			return $this->convertPhpIniNumbuer($max_post);	
		}
		return 0;
	}
	
	private function convertPhpIniNumbuer($value)
	{
		if($value{strlen($value)-1}=='M')
		{
			$value=intval(str_replace('M', '', $value));
			$value=1024*1024*$value;
			return $value;
		}
		return 0;
			
	}
	

}
?>