<?php
namespace Core;

/**
* 按指定方式输出通信数据
* @param array $data 数据
* @param string $msg 提示信息
* @param integer $code 状态码
* @return string
*/
class Response{
	public function response($msg = 'success', $data=array(), $code = 200, $type = 'json'){		
		if(!is_numeric($code)) return 'error';//die('error!');		
		$format = array('json', 'xml', 'array');//允许通过的数据方式
		$type = isset($_GET['format']) ? $_GET['format'] : $type;
		if(!in_array($type, $format)) return 'no format';//die('no format');	
		$result = array('code' => $code, 'msg' => $msg, 'data' => $data);
		$call_func_name = $type . 'Encode';
		exit($this->{$call_func_name}($result));
	}
	
	private function arrayEncode($data){
		return var_dump($data);
	}

	private function jsonEncode($data){
		header('Content-Type:text/json');
		return json_encode($data);
	}

	private function xmlEncode($data){
		header('Content-Type:text/xml');
		$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml .= "<root>\n";
		$xml .= $this->xml_to_encode($data);
		$xml .= "</root>";
		return $xml;
	}

	private function xml_to_encode($data){
		$xml = '';
		$attr = '';
		foreach ($data as $key => $value) {
			if(is_numeric($key)){
				$attr = " id='{$key}'";
				$key = "item";
			}
			$xml .= "<{$key}{$attr}>";
			$xml .= is_array($value) ? $this->xml_to_encode($value) : $value;
			$xml .= "</{$key}>\n";
		}
		return $xml;
	}
}