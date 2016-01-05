<?php
	function is_login(){
		// if(session('?user_id')){
		if(session('user_info')['id']){
			return true;
		}else{
			return false;
		}
	}
	function is_choose_site(){
		if(session('site_info')['id']){
			return true;
		}else{
			return false;
		}
	}
	function formatSize($size){
		if(is_numeric($size)){
			$size = (int)$size;
		}else{
			return '未知';
		}
		$arr = array('B','KB','MB','GB');
		$i = 0;
		while(true){
			if($size < 1024){
				return $size.' '.$arr[$i++];
			}else{
				$size = $size / 1024;
			}
		}
		return '未知';
	}
	/**
	* 复制一个不存在的深层路径
	**/
	function hCopy($source, $destination){
        $array = explode('/', $destination);
        $i = 1;
        $path = $array[0];
        $count = count($array) - 1;
        for(;$i< $count; $i ++){
            $path = $path . "/" . $array[$i];
            if(!is_dir($path)){
                mkdir($path);
            }
        }
        copy($source, $destination);
    }
	/**
	* 复制文件夹(递归)到目标文件夹
	**/
    function xCopy($source, $destination){
		if(substr($source,-1) == "/"){
			$source = substr($source,0,-1);
		}
		if(substr($destination,-1) == "/"){
			$destination = substr($destination,0,-1);
		}

        if(!is_dir($source)){
            return 0;
        }
        if(!is_dir($destination)){
            mkdir($destination,0777);
        }
		$destination = $destination."/".basename($source);
		if(!is_dir($destination)){
            mkdir($destination,0777);
        }
        $handle=dir($source);
        while($entry=$handle->read()) {
            if(($entry!=".")&&($entry!="..")){
                if(is_dir($source."/".$entry)){
                    xCopy($source."/".$entry,$destination);
                } else{
                    copy($source."/".$entry,$destination."/".$entry);
                }
            }
        }
        return 1;
    }
	/**
	* 删除文件夹下的所有文件
	* @param $empty true 只清空文件夹  false 清空后删除
	**/
    function deleteAll($directory, $empty = false) {
        if(substr($directory,-1) == "/") {
            $directory = substr($directory,0,-1);
        }

        if(!file_exists($directory) || !is_dir($directory)) {
            return false;
        } elseif(!is_readable($directory)) {
            return false;
        } else {
            $directoryHandle = opendir($directory);

            while ($contents = readdir($directoryHandle)) {
                if($contents != '.' && $contents != '..') {
                    $path = $directory . "/" . $contents;

                    if(is_dir($path)) {
                        deleteAll($path);
                    } else {
                        unlink($path);
                    }
                }
            }

            closedir($directoryHandle);

            if($empty == false) {
                if(!rmdir($directory)) {
                    return false;
                }
            }

            return true;
        }
    }

	/**
	* 合并两个排好序的数组
	**/
    function merge_sort($arr1,$arr2){
        $arr3 = [];
        $len1 = count($arr1);
        $len2 = count($arr2);
        $i = 0; $j = 0;
        for(;;){
            if($i >= $len1 || $j >= $len2 ){
                break;
            }
            if($arr1[$i]['sort'] <= $arr2[$j]['sort']){
                $arr3[] = $arr1[$i];
                $i ++;
            }else{
                $arr3[] = $arr2[$j];
                $j ++;
            }
        }
        for(;$i < $len1; $i ++){
            $arr3[] = $arr1[$i];
        }
        for(;$j < $len2; $j ++){
            $arr3[] = $arr2[$j];
        }
        return $arr3;
    }
?>
