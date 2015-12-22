<?php
namespace Controller;

class Home extends \Core\Controller{
	public function _initialize(){
		//初始化
	}

	public function index(){
		var_dump($a);
		//获取参数param1，默认为false，数据类型强制转换为string类型
		$param1 = I('param1', false, 'string');
		if($param1) p($param1);									//打印变量内容
		// $result = D('Test')->getAll('select * from test');	//数据库查询

		$this->title = 'LWH_PHP';
		$this->msg = 'This is the LWHPHP first test!';	
		// $data['msg'] = 'This is the LWHPHP first test!';
		// $this->assign($data);		
		// $this->layout('index');
		$this->layout('default')->display('Index/index');
		// $this->layout('Home/index')->display('Index/index');
		// $this->display('Home/index');
		// $this->display();
	}

	public function downloadExcel(){
		include '/Data/ClassLib/Excel.class.php';
		$a = new \Excel();
		$a->set(array('A1'=>'test data'));
		$a->download('test');
	}
}