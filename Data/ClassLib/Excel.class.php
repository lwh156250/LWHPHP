<?php
class Excel{
	private static $objPHPExcel;

	public function __construct(){
		$this->init();
	}

	public static function set($data=array(), $worksheetName = 'sheet1'){
		// Add some data
		foreach ($data as $key => $value) {
			self::$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue($key, $value);
		}

		// Rename worksheet
		self::$objPHPExcel->getActiveSheet()->setTitle($worksheetName);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		self::$objPHPExcel->setActiveSheetIndex(0);
	}

	public static function download($downloadName = 'simple'){

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename='{$downloadName}.xls'");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter(self::$objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	private function init(){
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');
		require_once dirname(__FILE__) . '/Excel/PHPExcel.php';
		// Create new PHPExcel object
		self::$objPHPExcel = new PHPExcel();

		// Set document properties
		self::$objPHPExcel->getProperties()->setCreator("Liu weihuang")
									 ->setLastModifiedBy("Liu weihuang")
									 ->setTitle("Download From LWHPHP")
									 ->setSubject("LWHPHP")
									 ->setDescription("Document for Office XLS, generated using LWHPHP classes.")
									 ->setKeywords("LWHPHP office php")
									 ->setCategory("LWHPHP");
	}
}