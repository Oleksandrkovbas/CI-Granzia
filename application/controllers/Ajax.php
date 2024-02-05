<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() { 
		parent::__construct();
		$this->load->library('pdf');
	}
	public function getDraftPDF(){
			
			//ob_start();
			$c_html = $_POST['editor_content'];
			//echo $c_html;exit;
			$time = time();
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->setPrintHeader(false);
			$pdf->startPageGroup();
			$pdf->setPrintFooter(false);
			$pdf->SetFontSize(9);
			$pdf->SetMargins(0, 0, 0, true);
			$pdf->SetAutoPageBreak(false, 0);
			$pdf->AddPage('P', 'A4');
			
			$img_file1 = 'https://gestionale.istitutoelveticodigaranzia.ch/uploads/resources/front-it.jpg';
			$pdf->Image($img_file1, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			
			
			//$pdf->SetFont('helvetica', 'BI', 12);
			//$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('helvetica', '', 6.7);
			/*$tagvs = array(           
				'p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 1, 'n' => 1)),
				'ul' => array(0 => array('h' => 0.0001, 'n' => 1), 1 => array('h' => 1, 'n' => 1)),
				'ol' => array(0 => array('h' => 0.0001, 'n' => 1), 1 => array('h' => 1, 'n' => 1)),   
				'div' => array(0 => array('h' => 0.0001, 'n' => 1), 1 => array('h' => 0.0001, 'n' => 1)),
				'hr' => array(0 => array('h' => 0.0001, 'n' => 1), 1 => array('h' => 0.0001, 'n' => 1)),
			);
			$pdf->setHtmlVSpace($tagvs);*/
			//$pattern = "/<p[^>]*><\\/p[^>]*>/"; // regular expression
			
			/*$nc_html = preg_match("#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#",$c_html);*/
			//$nc_html = preg_replace($pattern, '', $c_html);
			
			//$c_html = str_replace('&nbsp;', '', $c_html);
			//$c_html = str_replace(array('<p> </p>', '<p></p>'), '', $c_html);
			
			$pdf->writeHTMLCell(151, 210, '28.6', '74.5', $c_html, 0, 0, 0, true, '', true);
			$pdf->setPageMark();
			//$pdf->SetMargins(0, 0, 0, true);
			$pdf->SetAutoPageBreak(false, 0);
			$pdf->Output(FCPATH.'uploads/drafts/'.$time.'.pdf', 'F');
			echo json_encode(array('status'=>TRUE,'image'=>$time.'.pdf'));
			
			exit;
		
	}
	
	public function getAppxDraftPDF(){
	
    $c_html = $_POST['editor_content'];
    $rif_codice = $_POST['rif_codice'];
    $adf_no = $_POST['adf_no'];
    
    $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	$pdf->SetMargins(10, 32, 10, true);
	//$pdf->SetAutoPageBreak(TRUE, 82);
	$pdf->SetFont('helvetica', '', 8);
	
	// Add a page
	//$pdf->AddPage();
	
	/**/
	//$pdf->writeHTMLCell(151, 210, '28', '70', $c_html, 0, 0, 0, true, 'L', false);
	//$pdf->SetFont('helvetica', '', 8);
	//$pdf->writeHTML($c_html,false, false, true, false, '');
	$html_count = str_word_count($c_html);
	$pdf->setPrintHeader(true);
	if($html_count > 610){
		$pdf->SetAutoPageBreak(true, 80);
	}
	else{
		$pdf->SetAutoPageBreak(false, 0);
	}
	
	$currentPage = $pdf->getPage();
    $currentX    = $pdf->GetX();
    $currentY    = $pdf->GetY();
	
    $pdf->AddPage('P','A4');
    
	$x     = $pdf->GetX();
    $start = $pdf->GetY();
	
	$pdf->SetFont('helvetica', '', 8);
	$pdf->setCellHeightRatio(1.7);
	
	$pdf->writeHTMLCell(151, 210, '28', '35', "<strong>COD. RIF:".$rif_codice."</strong>", 0, 0, 0, true, '', true);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(151, 210, '70', '40', "<strong>APPENDICE ALL'ATTO DI FIDEJUSSIONE N. ".strtoupper($adf_no)."</strong>", 0, 0, 0, true, 'L', false);
	
	$pdf->setCellHeightRatio(1.7);
	$pdf->SetFont('helvetica', '', 8);
	
	$static_text = "Con la presente appendice, facente parte integrante, sostanziale ed inscindibile del suindicato atto di fidejussione, ad integrazione di quanto riportato nell'atto di fidejussione suindicato, si conviene quanto segue:";
	
	$pdf->writeHTMLCell(151, 210, '28', '47',  '<p style="text-align:justify;">'.$static_text.'</p>', 0, 0, 0, true, '', true);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(151, 210, '85', '63', "<strong>OGGETTO DELL'APPENDICE:</strong>", 0, 0, 0, true, 'L', false);
	
	//$pdf->setCellHeightRatio(1.6);
	$pdf->SetFont('helvetica', '', 8);
    
	$pdf->writeHTMLCell(151, 210, '28', '70',$c_html, 0, 0, 0, true, 'L', false);
    
	$height = $pdf->GetY() - $start;
    
	if($currentPage==0){
		//$pdf->deletePage($pdf->getPage()+1);
	}
    // Output the PDF
    $time = time();
    $pdf->Output(FCPATH . 'uploads/drafts/' . $time . '.pdf', 'F');
    echo json_encode(array('status' => TRUE, 'image' => $time . '.pdf'));
    
    exit;
}



	public function removeDraftPDF(){
		$pdf_preview_file_name = $_POST['pdf_preview_file_name'];
		unlink(FCPATH.'uploads/drafts/'.$pdf_preview_file_name);
		echo json_encode(array('status'=>TRUE));
		exit;
	}
	public function removeAppxDraftPDF(){
		$pdf_preview_file_name = $_POST['appx_pdf_preview_file_name'];
		unlink(FCPATH.'uploads/drafts/'.$pdf_preview_file_name);
		echo json_encode(array('status'=>TRUE));
		exit;
	}
	public function closeTags( &$html, $length = 20 ){
    	$htmlLength = strlen($html);
    	$unclosed = array();
    	$counter = 0;
    	$i=0;
    	while( ($i<$htmlLength) && ($counter<$length) ){
    		if( $html[$i]=="<" ){
    			$currentTag = "";
    			$i++;
    			if( ($i<$htmlLength) && ($html[$i]!="/") ){
    				while( ($i<$htmlLength) && ($html[$i]!=">") && ($html[$i]!="/") ){
    					$currentTag .= $html[$i];
    					$i++;
    				}
    				if( $html[$i] == "/" ){  
    					do{ $i++; } while( ($i<$htmlLength) && ($html[$i]!=">") );	
    				} else {
    					$currentTag = explode(" ", $currentTag);
    					$unclosed[] = $currentTag[0];
    				}
    			} elseif( $html[$i]=="/" ){
    				array_pop($unclosed);
    				do{ $i++; } while( ($i<$htmlLength) && ($html[$i]!=">") );
    			}
    		} else{
    			$counter++;	
    		}
    		$i++;
    	}
    	$result = substr($html, 0, $i-1);
    	$unclosed = array_reverse( $unclosed );
    	foreach( $unclosed as $tag ) $result .= '</'.$tag.'>';
    	//print_r($result);
		return $result;
    }
	
}