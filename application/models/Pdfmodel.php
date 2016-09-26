<?php
/*
 *   application   : EchoCMS                                          *
 *   author        : Gilbert Kozal                                       *
 *   e-mail        : gilbertkozal@gmail.com                                    *
 *   WYKORZYSTANIE BEZ ZGODY AUTORA ZASTRZEŻONE                            * 
 */
 
class Pdfmodel extends CI_Model {

	
    function __construct()
    {
        parent::__construct();		
    }
	public function printDocs($docsType = array(),$pz,$order,$positions,$customer){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
		if($docsType['order']){
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			if($_SERVER['SERVER_NAME'] == 'localhost'){
				$img_file = "D:/xampp1/htdocs/a/admin_project/www/images/order_bg.jpg";//base_url("images/pz_bg.jpg");
			}
			else{
				$img_file = "/home/infornet/public_html/aplikacje/elizab/images/order_bg.jpg";
			}
			//echo $img_file;
			$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$pdf->MultiCell(40, 0, $order->delivery_date, 0, 'L', 1, 2, 122, 36, true);
			$pdf->SetFontSize(20);
			$pdf->MultiCell(0, 0, $order->consecutive_number, 0, 'L', 1, 2, 150, 68, true);
			$pdf->MultiCell(0, 0, "ZAMÓWIENIE  NR ".$order->number, 0, 'L', 1, 2, 60, 90, true);
			$pdf->SetFontSize(12);
			$pdf->MultiCell(0, 0, $customer->name." / ".$customer->person." / ".$customer->phone, 0, 'L', 1, 2, 15, 116, true);
			$ral = $positions[0]->name;
			if($positions[1]->name){
				$ral .= ", ".$positions[1]->name;
			}
			if($positions[2]->name){
				$ral .= ", ".$positions[2]->name;
			}
			$pdf->MultiCell(0, 0, $ral, 0, 'L', 1, 2, 15, 135, true);
			$pdf->MultiCell(0, 0, $positions[0]->element_name." - ".$positions[0]->name, 0, 'L', 1, 2, 15, 162, true);
			$pdf->MultiCell(0, 0, $positions[1]->element_name." - ".$positions[1]->name, 0, 'L', 1, 2, 15, 174, true);
			$pdf->MultiCell(0, 0, $positions[2]->element_name." - ".$positions[2]->name, 0, 'L', 1, 2, 15, 186, true);
			$pdf->SetFontSize(8);
			$pdf->MultiCell(80, 0, $order->info, 0, 'L', 1, 2, 15, 245, true);
		}
		if($docsType['pz']){
			$pdf->SetFontSize(12);
			$pdf->AddPage();
			// -- set new background ---

			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			//$img_file = "D:/xampp1/htdocs/a/admin_project/www/images/pz_bg.jpg";//base_url("images/pz_bg.jpg");
			//echo $img_file;
			//$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$add_date = explode(" ",$pz->date_add);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->MultiCell(0, 0, $add_date[0], 0, 'L', 1, 2, 135, 17, true);
			$pdf->MultiCell(200, 0, $order->consecutive_number, 0, 'L', 1, 2, 135, 27, true);
			$pdf->MultiCell(0, 0, "Numer zamówienia: ".$order->number, 0, 'L', 1, 2, 42, 33, true);
			$pdf->MultiCell(0, 0, "Numer PZ (system): ".$pz->number, 0, 'L', 1, 2, 42, 40, true);
			$pdf->MultiCell(0, 0, $pz->execution_date, 0, 'L', 1, 2, 125, 84, true);
			$pdf->MultiCell(0, 0, $customer->name, 0, 'L', 1, 2, 15, 84, true);
			$pdf->SetFontSize(10);
			$pdf->MultiCell(90, 0, $positions[0]->element_name." / ".$positions[0]->name, 0, 'L', 1, 2, 30, 114, true);
			$pdf->MultiCell(15, 0, $positions[0]->quantity." ".$positions[0]->unit, 0, 'L', 1, 2, 132, 114, true);
			$pdf->MultiCell(15, 0, $positions[0]->price, 0, 'L', 1, 2, 150, 114, true);
			$pdf->MultiCell(15, 0, number_format(($positions[0]->price*$positions[0]->quantity), 2, '.', ''), 0, 'L', 1, 2, 165, 114, true);
			$pdf->MultiCell(90, 0, $positions[1]->element_name." / ".$positions[1]->name, 0, 'L', 1, 2, 30, 129, true);
			$pdf->MultiCell(15, 0, $positions[1]->quantity." ".$positions[1]->unit, 0, 'L', 1, 2, 132, 129, true);		
			$pdf->MultiCell(15, 0, $positions[1]->price, 0, 'L', 1, 2, 150, 129, true);		
			$pdf->MultiCell(15, 0, number_format(($positions[1]->price*$positions[1]->quantity), 2, '.', ''), 0, 'L', 1, 2, 165, 129, true);
			$pdf->MultiCell(90, 0, $positions[2]->element_name." / ".$positions[2]->name, 0, 'L', 1, 2, 30, 143, true);
			$pdf->MultiCell(15, 0, $positions[2]->quantity." ".$positions[2]->unit, 0, 'L', 1, 2, 132, 143, true);
			$pdf->MultiCell(15, 0, $positions[2]->price, 0, 'L', 1, 2, 150, 143, true);
			$pdf->MultiCell(15, 0, number_format(($positions[2]->price*$positions[2]->quantity), 2, '.', ''), 0, 'L', 1, 2, 165, 143, true);
			$pdf->SetFontSize(8);
			$pdf->MultiCell(0, 0, $pz->info, 0, 'L', 1, 2, 17, 180, true);
			
			// ---------------------------------------------------------
		}
		if($docsType['pz_c']){
			$pdf->SetFontSize(12);
			$pdf->AddPage();


			// -- set new background ---

			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			//$img_file = "D:/xampp1/htdocs/a/admin_project/www/images/pz_c_bg.jpg";//base_url("images/pz_bg.jpg");
			//echo $img_file;
			//$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$add_date = explode(" ",$pz->date_add);
			$pdf->MultiCell(0, 0, $add_date[0], 0, 'L', 1, 2, 135, 17, true);
			$pdf->MultiCell(200, 0, $order->consecutive_number, 0, 'L', 1, 2, 135, 27, true);
			$pdf->MultiCell(0, 0, "Numer zamówienia: ".$order->number, 0, 'L', 1, 2, 42, 33, true);
			$pdf->MultiCell(0, 0, "Numer PZ (system): ".$pz->number, 0, 'L', 1, 2, 42, 40, true);
			$pdf->MultiCell(0, 0, $pz->execution_date, 0, 'L', 1, 2, 125, 84, true);
			$pdf->MultiCell(0, 0, $customer->name, 0, 'L', 1, 2, 15, 84, true);
			$pdf->SetFontSize(8);
			$pdf->MultiCell(0, 0, $pz->info, 0, 'L', 1, 2, 17, 182, true);
			$pdf->SetFontSize(10);
			$pdf->MultiCell(90, 0, $positions[0]->element_name." / ".$positions[0]->name, 0, 'L', 1, 2, 30, 114, true);
			$pdf->MultiCell(15, 0, $positions[0]->quantity." ".$positions[0]->unit, 0, 'L', 1, 2, 136, 114, true);
			$pdf->MultiCell(90, 0, $positions[1]->element_name." / ".$positions[1]->name, 0, 'L', 1, 2, 30, 129, true);
			$pdf->MultiCell(15, 0, $positions[1]->quantity." ".$positions[1]->unit, 0, 'L', 1, 2, 136, 129, true);		
			$pdf->MultiCell(90, 0, $positions[2]->element_name." / ".$positions[2]->name, 0, 'L', 1, 2, 30, 143, true);
			$pdf->MultiCell(15, 0, $positions[2]->quantity." ".$positions[2]->unit, 0, 'L', 1, 2, 136, 143, true);
			
			$pdf->MultiCell(0, 0, $pz->trawienie, 0, 'L', 1, 2, 147, 214, true);
			$pdf->MultiCell(0, 0, $pz->szlifowanie, 0, 'L', 1, 2, 147, 229, true);
			$pdf->MultiCell(0, 0, $pz->przygotowanie, 0, 'L', 1, 2, 147, 243, true);
			$pdf->MultiCell(0, 0, $pz->zapakowanie, 0, 'L', 1, 2, 147, 258, true);
			// ---------------------------------------------------------
		}
		//Close and output PDF document
		$pdf->Output('print.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printPzProduction($data = array()){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Zlecenia - produkcja ('.date("Y-m-d H:i").')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
                        <th>Numer</th> 
						<th>Numer nadania</th>
						<th>Termin realizacji</th>
						<th>Godz. odbioru</th>		
						<th>Data utworzenia</th>
						<th>Klient</th>
						<th>Priorytet</th>	
						<th>Farby</th>						
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data as $v){
				$html .= '<tr>                        
                        <td>'.$v->number.'</td> 
						<td>'.$v->consecutive_number.'</td>
						<td>'.$v->execution_date.'</td>
						<td>'.$v->hour_reception.'</td>		
						<td>'.$v->date_add.'</td>
						<td>'.$v->name.'</td>
						<td>'.$v->priority.'</td>	
						<td>'.$v->paint1.'<br/>'.$v->paint2.'<br/>'.$v->paint3.'</td>						
                      </tr>';
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('zlecenia.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printPaintsDelivery($data = array()){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Dostawa - farby ('.date("Y-m-d H:i").')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Farba</th>
						<th>Ilość</th>
						<th>Jednostka</th>		
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data as $v){
				$html .= '<tr>    
						<td>'.$v->name.'</td>
						<td>'.$v->quantity.'</td>
                        <td>'.$v->unit.'</td> 
                      </tr>';
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('dostawa.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printRaport($id_report = 0, $data = array(), $range_from, $range_to){
		switch ($id_report) {
				case 1:
					$this->printRaport1($data, $range_from, $range_to);
					break;
				case 2:
					$this->printRaport2($data, $range_from, $range_to);
					break;
				case 3:
					$this->printRaport3($data, $range_from, $range_to);
					break;
				case 4:
					$this->printRaport4($data, $range_from, $range_to);
					break;
				case 5:
					$this->printRaport5($data, $range_from, $range_to);
					break;
			}
		
	}
	public function printRaport1($data = array(), $range_from = null, $range_to = null){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Wystawione PZ ('.$range_from.' - '.$range_to.')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Data wystawienia PZ</th> 
						<th>Numer PZ</th>
						<th>Odbiorca</th>
						<th>Wartość PZ</th>	
						<th>Przewidywany termin realizacji</th>	
						<th>Data wykonania</th>
						<th>Numer paragonu lub FV</th>	
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data['data'] as $v){
				$html .= "<tr>    
							<td>{$v->date_add}</td> 
							<td>{$v->number}</td>
							<td>{$v->name}</td>
							<td>".number_format($v->pz_value, 2, '.', '')."</td>	
							<td>{$v->execution_date}</td>	
							<td>{$v->execution_date_complete}</td>
							<td>{$v->bill_number}</td>
                      </tr>";
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('raport.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printRaport2($data = array(), $range_from = null, $range_to = null){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Zrealizowane PZ ('.$range_from.' - '.$range_to.')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Data wystawienia PZ</th> 
						<th>Numer PZ</th>
						<th>Odbiorca</th>
						<th>Wartość PZ</th>	
						<th>Przewidywany termin realizacji</th>	
						<th>Data wykonania</th>
						<th>Numer paragonu lub FV</th>	
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data['data'] as $v){
				$html .= "<tr>    
							<td>{$v->date_add}</td> 
							<td>{$v->number}</td>
							<td>{$v->name}</td>
							<td>".number_format($v->pz_value, 2, '.', '')."</td>	
							<td>{$v->execution_date}</td>	
							<td>{$v->execution_date_complete}</td>
							<td>{$v->bill_number}</td>
                      </tr>";
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('raport.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printRaport3($data = array(), $range_from = null, $range_to = null){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>PZ w trakcie realizacji</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Data wystawienia PZ</th> 
						<th>Numer PZ</th>
						<th>Odbiorca</th>
						<th>Wartość PZ</th>	
						<th>Przewidywany termin realizacji</th>	
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data['data'] as $v){
				$html .= "<tr>    
							<td>{$v->date_add}</td> 
							<td>{$v->number}</td>
							<td>{$v->name}</td>
							<td>".number_format($v->pz_value, 2, '.', '')."</td>	
							<td>{$v->execution_date}</td>
                      </tr>";
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('raport.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printRaport4($data = array(), $range_from = null, $range_to = null){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Wg. kontrahentów ('.$range_from.' - '.$range_to.')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Data wystawienia PZ</th> 
						<th>Numer PZ</th>
						<th>Odbiorca</th>
						<th>Wartość PZ</th>	
						<th>Przewidywany termin realizacji</th>	
						<th>Data wykonania</th>
						<th>Numer paragonu lub FV</th>
						<th>Elementy oraz farby</th>
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data['data'] as $v){
				$html .= "<tr>    
							<td>{$v->date_add}</td> 
							<td>{$v->number}</td>
							<td>{$v->name}</td>
							<td>".number_format($v->pz_value, 2, '.', '')."</td>	
							<td>{$v->execution_date}</td>	
							<td>{$v->execution_date_complete}</td>
							<td>{$v->bill_number}</td>
							<td>".(isset($data['dataElements'][$v->id_order][0]) ? $data['dataElements'][$v->id_order][0] : '')."<br/>"
							.(isset($data['dataElements'][$v->id_order][1]) ? $data['dataElements'][$v->id_order][1] : '')."<br/>"
							.(isset($data['dataElements'][$v->id_order][2]) ? $data['dataElements'][$v->id_order][2] : '')."
							</td>
                      </tr>";
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('raport.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
	public function printRaport5($data = array(), $range_from = null, $range_to = null){
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetFont('dejavusans', '', 20, '', false);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 17, 30);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// add a page ORDER
	
			
			$pdf->AddPage();
			$pdf->SetFontSize(12);
			// -- set new background ---
			
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
		//	$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			$pdf->SetFillColor(255, 255, 255);
			$html = '<h1>Zestawienie farb ('.$range_from.' - '.$range_to.')</h1><table border="1" cellpadding="2" style="text-align:center;font-size:10px"><thead>
                      <tr style="background-color:#dddddd">                        
						<th>Farba</th>
						<th>Ilość</th>
						<th>Jednostka</th>
                      </tr>
                    </thead>
                    <tbody>';
			foreach ($data['data'] as $v){
				$html .= "<tr>    
							<td>".$v->name."</td>
							<td>".$v->quantity."</td>
							<td>".$v->unit."</td>
                      </tr>";
				
			}
            $html .='</tbody></table>';
			$pdf->writeHTML($html, true, false, true, false, '');

		
		//Close and output PDF document
		$pdf->Output('raport.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+
	}
}