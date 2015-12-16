<?php
	function is_login(){
		// if(session('?user_id')){
		if(session('user_info')['id']){
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
    function xCopy($source, $destination){ 
        if(!is_dir($source)){ 
            return 0;
        } 
        if(!is_dir($destination)){ 
            mkdir($destination,0777);
        } 
        $handle=dir($source); 
        while($entry=$handle->read()) { 
            if(($entry!=".")&&($entry!="..")){ 
                if(is_dir($source."/".$entry)){ 
                    xCopy($source."/".$entry,$destination."/".$entry); 
                } else{
                    copy($source."/".$entry,$destination."/".$entry); 
                }
            } 
        } 
        return 1; 
    }

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
?>