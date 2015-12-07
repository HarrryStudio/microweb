<?php
namespace Home\Widget;
use Home\Widget;

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

	public function index()
	{
		// 就跟 controller 的 index的一样
	}

	public function insert_content()
	{
		// Panel 里 会调用这个方法去获取 widget 插入到手机面板里的html
		// 平时用的$this->display()  就改成 $this->insert_content()
	}
}

?>