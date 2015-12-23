<?php
namespace Controller;
class Pdf extends \Core\Controller{
	private $html = '';

	public function _initialize(){
		//初始化
		//将要生成的pdf用html写好即可转换为pdf %s 代表要替换的变量，使用sprintf($this->html, $data1, $data2);进行一一替换
		$this->html = file_get_contents('./'. shortUrl('view','/Pdf/template.html',false));
	}

	public function priview(){
		//模板预览
		$this->display('Pdf/template');
	}

	public function test(){
		require_once '/Data/ClassLib/Pdf.class.php';
		
		$config = array(
			'info' => array(
				'Title' => '测试'
			),
		);
		$data1 = '数据1';
		$data2 = '数据2';

		$this->html = sprintf($this->html, $data1, $data2);
		$a = new \Pdf($config);
		$a->setHtmlBody($this->html);
		$a->build();
	}

	public function download(){
		// header("Content-type: text/html; charset: utf-8;");
		require_once '/Data/ClassLib/Pdf.class.php';
		$a = new \Pdf();
		$a->setHtmlBody($this->html);
		$a->build('downloadtest.pdf', 'D');
	}

// 	private $html = <<<EOD
// <style type="text/css">
// 	table{border-collapse:collapse;border-spacing:0;border-left:1px solid #888;border-top:1px solid #888;background:#efefef;}
// 	th,td{border-right:1px solid #888;border-bottom:1px solid #888;padding:5px 15px;}
// 	th{font-weight:bold;background:#ccc;}
// </style>

// <h1>中文测试：Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
// <i>This is the first example of TCPDF library.</i>
// <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
// <table>
// <tr>
// <th>%s</th>
// <th>%s</th>
// </tr>
// <tr>
// <td>1</td>
// <td>2</td>
// </tr>
// </table>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p><p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p><p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p><p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p><p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
// EOD;

}