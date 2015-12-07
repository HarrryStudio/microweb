<?php
namespace Home\Widget;
/**
* 
*/
class ImageTextWidget extends Widget
{
	
	function __construct($theme,$resource,$option)
	{
		parent::__construct($theme,$resource,$option);
		$this->name = 'image_text';
	}

	public function controller()
	{
		$this->display('panel/'.$this->name);
	}
}

?>