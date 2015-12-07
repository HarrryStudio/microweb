<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class TestController extends Controller
{
	
	function __construct()
	{
		# code...
	}

	public function articlelist()
	{
		$ArticleList = new \Home\Widget\ArticleListWidget();
		$ArticleList->Controller();
	}
}

?>