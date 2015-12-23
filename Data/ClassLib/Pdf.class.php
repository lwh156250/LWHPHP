<?php
/**
* 生成pdf
*/
class Pdf{
	private $pdf;
	
	public function __construct($config = array()){
		// $config = array(
		// 	'info' => array(
		// 		'Creator' => '',
		// 		'Author' => '',
		// 		'Title' => '',
		// 		'Subject' => '',
		// 		'Keywords' => '',
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

	public function setHtmlBody($html=''){
		$this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	}

	public function build($name='example.pdf', $action = 'I'){
		$this->pdf->Output($name, $action);
	}

	public function init($config){
		require_once dirname(__FILE__) . '/Pdf/tcpdf.php';
		$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		//设置文档信息
		$this->pdf->SetCreator(isset($config['info']['Creator']) ? $config['info']['Creator'] : 'LWHPHP');
		$this->pdf->SetAuthor(isset($config['info']['Author']) ? $config['info']['Author'] : 'LWH');
		$this->pdf->SetTitle(isset($config['info']['Title']) ? $config['info']['Title'] : 'LWH TCPDF TEST');
		$this->pdf->SetSubject(isset($config['info']['Subject']) ? $config['info']['Subject'] : 'TCPDF CLASS');
		$this->pdf->SetKeywords(isset($config['info']['Keywords']) ? $config['info']['Keywords'] : 'TCPDF, PDF');

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