<?php

import('classes.lib.tcpdf.tcpdf');

class PDF extends TCPDF {
        
        
	function Header(){

                // Logo
                //$this->Image("public/site/images/mainlogo.png", 'C', 5, 40, '', '', false, 'C', false, 300, 'C', false, false, 0, false, false, false);
                $this->Image("public/site/images/PhilDOHs.png", 10, 10, 30, 30);
                $this->Image("public/site/images/PhilFDA.jpeg", 160, 13, 30, 24);

                $this->Ln(12);

		$this->SetFont('Times','',12);
                $hTitle = 'DEPARTMENT OF HEALTH';
		$wDOH = $this->GetStringWidth($hTitle)+20;
		$this->SetX((210-$wDOH)/2);
		$this->Cell($wDOH,9,$hTitle,0,1,'C');
                
		$this->SetFont('Times','B',12);
                $hSubTitle = 'FOOD AND DRUG ADMINISTRATION';
		$wFDA = $this->GetStringWidth($hSubTitle)+20;
		$this->SetX((210-$wFDA)/2);
		$this->Cell($wFDA,9,$hSubTitle,0,1,'C');
	}

	function Footer(){
		// Position at 1 cm from bottom
		$this->SetY(-10);
		// Arial italic 8
		$this->SetFont('Times','',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Title, subject, page number and date/time                
                $this->MultiRow3Columns(63, 64, $this->title.' - '.$this->subject, 'Page '.$this->PageNo(), date('d F Y H:i:s'), 'L', 'C', 'R');
                
	}

	function ChapterTitle($label, $style = 'B'){
		$this->SetFont('Times',$style,16);
		$this->MultiCell(0,6,$label,0,'C');
		$this->Ln();
	}

	function ChapterItemKeyVal($key, $val, $style = 'B'){
		$this->SetFont('Times', $style,12);
		$this->Cell(0,6,$key,0,1,'L',false);
		$this->SetFont('Times','',12); 
		$this->MultiCell(0,5,$val);
		// Line break
		$this->Ln();
	}
	
	function ChapterItemKey($key, $style = 'B'){
		$this->SetFont('Times', $style,12);
		$this->Cell(0,6,$key,0,1,'L',false);
		$this->SetFont('Times','',12); 		
		// Line break
		$this->Ln();
	}
	
	function ChapterItemVal($val, $style = ''){
		$this->SetFont('Times',$style,12); 
		$this->MultiCell(0,5,$val);
		// Line break
		$this->Ln();
	}
        
        function MultiRow($wLeft, $left, $right, $align = 'L', $alignR = null) {
                // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

                $page_start = $this->getPage();
                $y_start = $this->GetY();

                // write the left cell
                $this->MultiCell($wLeft, 0, $left, 0, $align, 0, 2, '', '', true, 0);

                $page_end_1 = $this->getPage();
                $y_end_1 = $this->GetY();

                $this->setPage($page_start);

                // write the right cell
                if ($alignR) {
                    $this->MultiCell(0, 0, $right, 0, $alignR, 0, 1, $this->GetX(), $y_start, true, 0);
                } else {
                    $this->MultiCell(0, 0, $right, 0, $align, 0, 1, $this->GetX(), $y_start, true, 0);
                }
                
                $page_end_2 = $this->getPage();
                $y_end_2 = $this->GetY();

                // set the new row position by case
                if (max($page_end_1,$page_end_2) == $page_start) {
                    $ynew = max($y_end_1, $y_end_2);
                } elseif ($page_end_1 == $page_end_2) {
                    $ynew = max($y_end_1, $y_end_2);
                } elseif ($page_end_1 > $page_end_2) {
                    $ynew = $y_end_1;
                } else {
                    $ynew = $y_end_2;
                }

                $this->setPage(max($page_end_1,$page_end_2));
                $this->SetXY($this->GetX(),$ynew);
        }
        
        function MultiRow3Columns($wLeft, $wMiddle, $left, $middle, $right, $align = 'L', $alignM = null, $alignR = null) {
                // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

                $page_start = $this->getPage();
                $y_start = $this->GetY();

                // write the left cell
                $this->MultiCell($wLeft, 0, $left, 0, $align, 0, 2, '', '', true, 0);

                $page_end_1 = $this->getPage();
                $y_end_1 = $this->GetY();

                $this->setPage($page_start);

                // write the middle cell
                if ($alignM) {
                    $this->MultiCell($wMiddle, 0, $middle, 0, $alignM, 0, 2, $this->GetX(), $y_start, true, 0);
                } else {
                    $this->MultiCell($wMiddle, 0, $middle, 0, $align, 0, 2, $this->GetX(), $y_start, true, 0);
                }
                $page_end_2 = $this->getPage();
                $y_end_2 = $this->GetY();
                
                $this->setPage($page_start);
                
                // write the right cell
                if ($alignR) {
                    $this->MultiCell(0, 0, $right, 0, $alignR, 0, 1, $this->GetX() ,$y_start, true, 0);
                } else {
                    $this->MultiCell(0, 0, $right, 0, $align, 0, 1, $this->GetX() ,$y_start, true, 0);
                }

                $page_end_3 = $this->getPage();
                $y_end_3 = $this->GetY();

                // set the new row position by case
                if (max($page_end_1,$page_end_2,$page_end_3) == $page_start) {
                    $ynew = max($y_end_1, $y_end_2, $y_end_3);
                } elseif ($page_end_1 == $page_end_2 && $page_end_1 == $page_end_3) {
                    $ynew = max($y_end_1, $y_end_2, $y_end_3);    
                } elseif ($page_end_1 == $page_end_2 && $page_end_1 > $page_end_3) {
                    $ynew = max($y_end_1, $y_end_2);
                } elseif ($page_end_1 == $page_end_3 && $page_end_1 > $page_end_2) {
                    $ynew = max($y_end_1, $y_end_3);
                } elseif ($page_end_2 == $page_end_3 && $page_end_2 > $page_end_1) {
                    $ynew = max($y_end_2, $y_end_3);
                } elseif ($page_end_1 > $page_end_2 && $page_end_1 > $page_end_3) {
                    $ynew = $y_end_1;
                } elseif ($page_end_2 > $page_end_1 && $page_end_2 > $page_end_3) {
                    $ynew = $y_end_2;
                } elseif ($page_end_3 > $page_end_1 && $page_end_3 > $page_end_2) {
                    $ynew = $y_end_3;
                }

                $this->setPage(max($page_end_1,$page_end_2,$page_end_3));
                $this->SetXY($this->GetX(),$ynew);
        }
         
}

?>
