<?php
namespace Controller;
class Pdf extends \Core\Controller{
	private $html = '';

	public function _initialize(){
		//初始化
		//将要生成的pdf用html写好即可转换为pdf %s 代表要替换的变量，使用sprintf($this->html, $data1, $data2);进行一一替换
		//获取模板的html数据   /View/Pdf/template.html
		$this->html = file_get_contents('./'. shortUrl('view','/Pdf/template.html',false));
	}

	public function previewHtmlTemplate(){
		//模板预览
		$this->display('Pdf/template');
	}

	public function previewPdf(){		
		//pdf初始设置
		$config = array(
			'info' => array(
				'title' => '测试'
			),
			'header' => array(
				'imageWidth' => 60,
			),
		);


		$experts = '大强老师、伟煌、超明、百川';//专家姓名及陪同人员
		$organization = '华南师范大学-数学科学学院';//单位
		$visit_time = '2999-12-31';//访问时间
		$expert_profile = '主讲课程：
● 数学院、全校理科综合1班：  数学分析（1）、数学分析（2）、数学分析（3）、微分方程数值方法
● 全校公共课：   高等数学I、高等数学II、高等数学III
● 互开课：       线性代数、工程数学（复变函数、积分变换、概率论）

奖励：
● 获得 2010 年“为了明天”教学奖中青年教师课堂教学优秀奖三等奖
● 获得 “2009—2010 学年度课堂教学质量优秀教师” 称号:

指导本科生科研实践：  全国大学生数学建模竞赛、美国数学建模竞赛
论文
钟柳强, 关于《数学分析》课程教学的几点思考,华南师范大学学报社会科学版(教育研究增刊),2011年6月, 166-167.
研究生主讲课程：
● 三年制学术型（数学、统计学类）研究生学科学位课程： 数值分析  
● 专业方向课程：偏微分方程数值解、有限元方法的数学理论、电磁场有限元方法、快速算法研究、论文选读 等';//专家简介
		$report_title = 'LWHPHP';//报告题目
		$summary = 'PHP框架';//摘要
		$level_major_scale = '0—0-0';//层次、专业方向、规模
		$report_time_address = '2999-12-31 25:00 阶梯教室';//报告时间及地点
		$dean_suggestion = '<img src="'. shortUrl('assets','/images/ok.png') .'">';//数学所所长意见
		$leader_suggestion = '';//学院领导意见


		//变量替换
		$this->html = sprintf($this->html,$experts,$organization,$visit_time,$expert_profile,$report_title,$summary,$level_major_scale,$report_time_address,$dean_suggestion,$leader_suggestion);

		require_once '/Data/ClassLib/Pdf.class.php';
		$a = new \Pdf($config);
		$a->setHtmlBody($this->html);
		$a->build();
	}

	public function downloadPdf(){
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
// <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
// EOD;

}