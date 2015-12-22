<?php
namespace Controller;

class User extends \Core\Controller{
	public function login(){
		$this->redirect_url = I('redirect_url', null, 'string');
		$this->display();
	}

	public function loginHandle(){
		$redirect_url = I('redirect_url', null, 'string');
		$username = I('username', null, 'string');
		$password = md5(md5(I('password', null, 'string')));

		$result = D()->getAll("select * from user where username='$username' limit 1");
		if(!$result){
			$this->response('该用户尚未注册！', null, 400);
		}elseif($result[0]['password'] != $password){
			$this->response('密码错误!', null, 400);
		}else{
			session('user_id', $result[0]['id']);
			$this->response('登录成功！', array('redirect_url' => $redirect_url));
		}
		$this->response('用户名或密码不正确');
	}

	public function register(){
		$this->display();
	}

	public function registerHandle(){
		$username = I('username', null, 'string');
		$password = md5(md5(I('password', null, 'string')));

		//数据合法判断
		$result = D()->getAll("select id from user where username = '$username' limit 1");
		if($result){
			$this->response('用户名已经被注册！',$result,400);
		}
		//防刷

		$result = D()->query("insert into user (username,password) VALUES ('$username','$password')");
		if($result){
			$this->response('注册成功！');
		}else{
			$this->response('注册失败',null,400);
		}
	}

	public function info(){

	}	

	public function logout(){

	}
}