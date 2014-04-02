<?php

import('classes.lib.fpdf.tfpdf');

class PDF extends tFPDF {
    
	function Header(){
                $this->AddFont('DejaVuBold','','DejaVuSansCondensed-Bold.ttf',true);
		$title = $this->title;
		$this->SetFont('Times','B',15);

                // Logo
                $this->Image("public/site/images/mainlogo.png", 85, 5, 40);
		$this->Ln(20);

		// Calculate width of title and position
		$w = $this->GetStringWidth($title)+6;
		$this->SetX((210-$w)/2);
		// Title
		$this->Cell($w,9,$title,0,1,'C');
		// Line break
		$this->Ln(10);
	}

	function Footer(){
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Times','I',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
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
        
        function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
                // Calculate MultiCell with automatic or explicit line breaks height
                // $border is un-used, but I kept it in the parameters to keep the call
                //   to this function consistent with MultiCell()

                $cw = &$this->CurrentFont['cw'];
                
                if($w==0) $w = $this->w-$this->rMargin-$this->x;
                
                $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
                $s = str_replace("\r",'',$txt);
                $nb = strlen($s);
                
                if($nb>0 && $s[$nb-1]=="\n") $nb--;
                
                $sep = -1;
                $i = 0;
                $j = 0;
                $l = 0;
                $ns = 0;
                $height = 0;
                while($i<$nb)
                {
                        // Get next character
                        $c = $s[$i];
                        if($c=="\n")
                        {
                                // Explicit line break
                                if($this->ws>0)
                                {
                                        $this->ws = 0;
                                        $this->_out('0 Tw');
                                }
                                //Increase Height
                                $height = $height + $h;
                                $i++;
                                $sep = -1;
                                $j = $i;
                                $l = 0;
                                $ns = 0;
                                continue;
                        }
                        if($c==' ')
                        {
                                $sep = $i;
                                $ls = $l;
                                $ns++;
                        }
                        $l += $cw[$c];
                        if($l>$wmax)
                        {
                                // Automatic line break
                                if($sep==-1)
                                {
                                        if($i==$j)
                                                $i++;
                                        if($this->ws>0)
                                        {
                                                $this->ws = 0;
                                                $this->_out('0 Tw');
                                        }
                                        //Increase Height
                                        $height = $height + $h;
                                }
                                else
                                {
                                        if($align=='J')
                                        {
                                                $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                                                $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                                        }
                                        //Increase Height
                                        $height = $height + $h;
                                        $i = $sep+1;
                                }
                                $sep = -1;
                                $j = $i;
                                $l = 0;
                                $ns = 0;
                        }
                        else
                                $i++;
                }
                // Last chunk
                if($this->ws>0)
                {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                }
                //Increase Height
                $height = $height + $h;

                return $height;
        }        
        
        
        function table1Line2Columns ($widthFirstColumn, $widthSecondColumn, $h, $label, $value, $align = 'L'){
                                
                $heightFirstColumn = $this->GetMultiCellHeight($widthFirstColumn, $h, $label, null, $align);
                                                
                if ($widthSecondColumn == 0) $widthSecondColumn  = $this->w-$this->rMargin-$this->x-$widthFirstColumn;
                $heightSecondColumn = $this->GetMultiCellHeight($widthSecondColumn, $h, $value, null, $align);                

                $current_y = $this->GetY();
                if ( ($current_y + $heightFirstColumn) > 272 || ($current_y + $heightSecondColumn) > 272) {
                    $this->addPage();
                    $current_y = $this->GetY();
                }
                $current_x = $this->GetX();
                $this->MultiCell($widthFirstColumn,$h,$label, 0, $align);
                $this->SetXY($current_x + $widthFirstColumn, $current_y);
                $this->MultiCell(0,$h,$value, 0, $align);
                if ($heightSecondColumn > $heightFirstColumn) {
                    $this->SetY($current_y + $heightSecondColumn);
                    $this->ln();
                } elseif ($heightSecondColumn < $heightFirstColumn) {
                    $this->SetY($current_y + $heightFirstColumn);
                    $this->ln(30);
                }
        }

        function table1Line3Columns ($widthFirstColumn, $widthSecondColumn, $widthThirdColumn, $h, $label1, $label2, $value, $align = 'L'){
                
                
                $heightFirstColumn = $this->GetMultiCellHeight($widthFirstColumn, $h, $label1, null, $align);
                
                $heightSecondColumn = $this->GetMultiCellHeight($widthSecondColumn, $h, $label2, null, $align);
                
                if ($widthThirdColumn == 0) $widthThirdColumn  = $this->w-$this->rMargin-$this->x-$widthFirstColumn-$widthSecondColumn;
                $heightThirdColumn = $this->GetMultiCellHeight($widthThirdColumn, $h, $value, null, $align);
                
                
                $current_y = $this->GetY();
                if ( ($current_y + $heightFirstColumn) > 272 || ($current_y + $heightSecondColumn) > 272 || ($current_y + $heightThirdColumn) > 272) {
                    $this->addPage();
                    $current_y = $this->GetY();
                }
                $current_x = $this->GetX();
                
                $this->MultiCell($widthFirstColumn,$h,$label1, 0, $align);
                $this->SetXY($current_x + $widthFirstColumn, $current_y);
                $current_x = $this->GetX();
                $this->MultiCell($widthSecondColumn,$h,$label2, 0, $align);
                $this->SetXY($current_x + $widthFirstColumn, $current_y);
                $current_x = $this->GetX();
                $this->MultiCell(0,$h,$value, 0, $align);
        }
}

?>
