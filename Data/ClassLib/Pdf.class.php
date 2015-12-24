<?php
/**
* 生成pdf
*/
class Pdf{
	private $pdf;
	
	public function __construct($config = array()){
		// $config = array(
		// 	'info' => array(
		// 		'creator' => '',
		// 		'author' => '',
		// 		'title' => '',
		// 		'subject' => '',
		// 		'keywords' => '',
		// 	),	
		// 	'header' => array(
		// 		'imgUrl' => '',
		// 		'imageWidth' => '',
		// 		'bigTitle' => '',
		// 		'smallTitle' => '',
		// 		'titleColor' => '',
		// 		'lineColor' => '',
		// 	),
		// 	'footer' => array(
		// 		'textColor' => '',
		// 		'lineColor' => '',
		// 	),
		// 	//more ... 参考tcpdf的example，然后对下面的类进行修改，有问题请联系LWH
		// );
		$this->init($config);
	}

	/**
	 * 将html转化为pdf
	 * @param string $html [description]
	 */
	public function setHtmlBody($html=''){
		$this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	}

	/**
	 * 将pdf在浏览器上展示，后进行下载
	 * @param  string $name   文件名字
	 * @param  string $action 'I'展示在浏览器上，'D'直接下载
	 * @return [type]         [description]
	 */
	public function build($name='example.pdf', $action = 'I'){
		$this->pdf->Output($name, $action);
	}

	public function init($config){
		require_once dirname(__FILE__) . '/Pdf/tcpdf.php';
		$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		//设置文档信息
		$this->pdf->SetCreator(isset($config['info']['creator']) ? $config['info']['creator'] : 'LWHPHP');
		$this->pdf->SetAuthor(isset($config['info']['author']) ? $config['info']['author'] : 'LWH');
		$this->pdf->SetTitle(isset($config['info']['title']) ? $config['info']['title'] : 'LWH TCPDF TEST');
		$this->pdf->SetSubject(isset($config['info']['subject']) ? $config['info']['subject'] : 'TCPDF CLASS');
		$this->pdf->SetKeywords(isset($config['info']['keywords']) ? $config['info']['keywords'] : 'TCPDF, PDF');

		//设置页眉页脚
		$this->pdf->SetHeaderData(
			(isset($config['header']['imgUrl']) ? $config['header']['imgUrl'] : '/img/logo.png'),
			(isset($config['header']['imageWidth']) ? $config['header']['imageWidth'] : 30),
			(isset($config['header']['bigTitle']) ? $config['header']['bigTitle'] : 'LWHPHP'),
			(isset($config['header']['smallTitle']) ? $config['header']['smallTitle'] : 'Personal Php FrameWork'),
			(isset($config['header']['titleColor']) ? $config['header']['titleColor'] : array(0,0,0)),
		    (isset($config['header']['lineColor']) ? $config['header']['lineColor'] : array(0,0,0))
		); 
		$this->pdf->setFooterData(isset($config['footer']['textColor']) ? $config['footer']['textColor'] : array(0,0,0), isset($config['footer']['lineColor']) ? $config['footer']['lineColor'] : array(0,0,0));
		

		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$this->pdf->AddPage();
	}
}