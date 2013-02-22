<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : LiHaibo_ISLee
 *  time		:2012/12/06
 *  ======================================= 
 */  
require_once APPPATH."/third_party/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
	
	public function simple_output($columnName, $data)
	{
		/**
		*简便的输出函数
		*$columnName为一维数组，为输出的Excel的每个列名，$data为二维数组，为输出的数据
		*/
		$this->array_to_sheet($columnName, $data);
		$this->output();
	}
	
	public function output()
	{
	//输出excel文件
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel2007');
		$objWriter->save('php://output');
	}
	
	public function array_to_sheet($columnName, $data)
	{
		//数组转换到excel，但并不输出，可以再调整一下格式后再输出
		$this->setActiveSheetIndex(0);
		$activeSheet = $this->getActiveSheet();
		$columnIndex = 0;
		$rowCounter = 1;
		$ceil = '';
		
		foreach ( $columnName as $val )
		{
			$ceil = chr(ord('A') + $columnIndex) . '1';
			$activeSheet->getColumnDimension(chr(ord('A') + $columnIndex))->setAutoSize(true);
			$activeSheet->setCellValue($ceil, $val);
			$columnIndex++;
		}
		
		foreach ( $data as $index => $record )
		{
			$rowCounter++;
			$columnIndex = 0;
			foreach ( $record as $key => $val )
			{
				$ceil = chr(ord('A') + $columnIndex) . $rowCounter;
				$activeSheet->setCellValue($ceil, $val);
				$activeSheet->getStyle($ceil)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$columnIndex++;
			}
		}
	}
	
	
	public function excel_reader($file_path,$ext)
	{
		//读取excle文件到数组，返回
        if($ext==".xls" || $ext==".xlsx"){
            if($ext==".xls"){
                $objReader = PHPExcel_IOFactory::createReader('Excel5');//读取 xlsx 用excel2007，如果xls用excel5，excel2007不向下兼容，艹～～ 
            }else if($ext==".xlsx"){
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            }
            $objPHPExcel = $objReader->load($file_path); 
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); //获取总行数
            $highestColumn = $objWorksheet->getHighestColumn(); //获取总列数
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
            
            $result = Array(); //转存数组
            for ($row = 1;$row <= $highestRow;$row++) 
            {
                $row_array = array();
                //注意highestColumnIndex的列数索引从0开始
                for ($col = 0;$col < $highestColumnIndex;$col++)
                {
                    $row_array[] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                $result[] = $row_array;
            }
            
            return $result;
        }else{
            return false;
        }
	}
}