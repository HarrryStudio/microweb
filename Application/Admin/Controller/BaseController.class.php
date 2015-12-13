<?php
namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller {


	/**
	 * [初始化方法,查询导航和子导航]
	 * @return [type]
	 * @author FTD
	 */
    final public function _initialize(){
        if(!session('?id')){
            $this->redirect('Public/login');
        }
        $user_id = session('id');
        $base_model = D('Base');
        $top_menu = $base_model->get_top_menu();
        $parent_id = '';
        $top_menu_count = count($top_menu);
        foreach ($top_menu as $k => $v) {
        	if($v['node_url'] ==  MODULE_NAME.'/'.CONTROLLER_NAME){
        		$parent_id = $v['id'];
        		break;
        	}
        }

        $top_menu = $this->change_url($top_menu);
        $child_menu = $base_model->get_child_menu($parent_id);
        $child_menu = $this->make_child_menu($child_menu);
        $this->assign('urlcolor',__MODULE__.'/'.CONTROLLER_NAME); //
        $this->assign('lefturlcolor',__ACTION__);
        $this->assign('top_menu',$top_menu);
        $this->assign('child_menu',$child_menu);
        $this->assign('admin_user',session('admin_user'));
    }

    /**
     * [构造一个二维导航数组]
     * @param  [type] $child_menu [子导航]
     * @return [array]            
     */
    public function make_child_menu($child_menu){
        $parent_arr = array();   		//存放二级导航
		$children_arr = array();  		//存放三级导航
		$child_menu_count = count($child_menu);  //该一级导航下的所有子导航
		for($i = 0,$j = 0,$k = 0;$i < $child_menu_count;$i++){
			if($child_menu[$i]['depth'] == 2){
				$parent_arr[$j++] = $child_menu[$i];
			}else if($child_menu[$i]['depth'] == 3){
				$children_arr[$k++] = $child_menu[$i];                
			}
		}
		$parent_count = count($parent_arr);  		//2级导航总数
		$children_count = count($children_arr); 	//3级导航总数
		for($m = 0,$p = 0;$m < $parent_count;$m++){
			for($n = 0;$n < $children_count ;$n++){
				if($parent_arr[$m]['id'] == substr($children_arr[$n]['id'],0,4)){
					$arr[$parent_arr[$m]['node_name']][$p++] = $children_arr[$n];
				}
			}
		}
		return $arr; 	 //该数组的一维键等于二级导航
    }

    /**
     * [改变主导航url,加上index]
     * @param  [type] $top_menu [description]
     * @return [type]           [description]
     */
   	public function change_url($top_menu){
   		$top_menu_count = count($top_menu);
   		for($i = 0 ;$i < $top_menu_count;$i++){
   			$top_menu[$i]['node_url'] = $top_menu[$i]['node_url'].'/index';
   		}

   		return $top_menu;
   	}


    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model,$where=array(),$order='',$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
       
        if(is_string($model)){
            $model  =   M($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }

        unset($REQUEST['_order'],$REQUEST['_field']);

        if(empty($where)){
            $where  =   array('status'=>array('egt',0));
        }
        if( !empty($where)){
            $options['where']   =   $where;
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new \Think\Page($total, $listRows, $REQUEST);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;
        $model->setProperty('options',$options);

        return $model->field($field)->select();
    }


   	
   	final public function __clone(){

    	return false;
    }

    final public function __destruct(){

    	return false;
    }
}