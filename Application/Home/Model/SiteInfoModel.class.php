<?php
namespace Home\Model;
use Think\Model;
/**
* 网站信息模型	
*/
class SiteInfoModel extends Model{
	protected $_validate = array(
		array('site_name', '/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){2,10}+$/u', '网站名为2到20位汉字、字母、数字的组合',1),
		// array('url', '/^([0-9A-Za-z][0-9A-Za-z-]{0,61})?[0-9A-Za-z]$/', "域名不合法"),
		// array('url', '/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/', "域名不合法"),
		array('url', '/^([0-9A-Za-z][0-9A-Za-z-]{3,30})$/', "二级域名不合法"),

		array('url', 'checkUrl', '此二级域名已经被占用', 0, 'callback', 3)
		);
	/**
	 * 取得网站列表
	 * @param  [int] 	$user_id 		[用户id]
	 * @return [array] 	$site_list      [以数组返回该用户的网站列表]
	 */
	public function get_site_list($user_id){
		$map['user_id'] = $user_id;
		$map['status'] = 0;
		$site_list = $this->where($map)->select();
		return $site_list;
	}

	protected function checkUrl(){
		$url = I('post.url');
		$result = $this->where(array('status' => 0,'url' => $url))->find();
		return empty($result);
	}
}