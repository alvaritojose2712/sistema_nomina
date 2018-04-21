<?php 
	require '../clases/phpexcel/vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
 	use PhpOffice\PhpSpreadsheet\Style\Alignment;
 	use PhpOffice\PhpSpreadsheet\Style\Fill;
 	use PhpOffice\PhpSpreadsheet\Style\Font;
 	use PhpOffice\PhpSpreadsheet\Style\Color;
 	use PhpOffice\PhpSpreadsheet\Style\Border;

	define('FORMAT_CURRENCY_PLN_1', '_-* #,##0.00\ [$Bs-415]_-');
	$spreadsheet = new Spreadsheet();
	$spreadsheet->setActiveSheetIndex(0);
	$get = $spreadsheet->getActiveSheet();

	$get->getColumnDimension('A')->setAutoSize(true);
	$get->getColumnDimension('B')->setAutoSize(true);
	$get->getColumnDimension('C')->setAutoSize(true);
	$get->getStyle('C')->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_PLN_1);

	$get->setCellValue('A2', "Código presupuestario");
	$get->setCellValue('A3', "Denominación del IEU");
	$get->setCellValue('A4', "Órgano de adscripción");
	$get->setCellValue('A5', "Mes requerido");

	$get->getStyle('A2')->getFont()->setBold(true);
	$get->getStyle('A3')->getFont()->setBold(true);
	$get->getStyle('A4')->getFont()->setBold(true);
	$get->getStyle('A5')->getFont()->setBold(true);

	$get->setCellValue('B2', $_POST['cod_presu']);
	$get->setCellValue('B3', $_POST['denomi_ieu']);
	$get->setCellValue('B4', $_POST['organo_abs']);
	$get->setCellValue('B5', $_POST['mes_req']);
	$get->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	$get->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	$get->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	$get->setCellValue('A8', "CÓDIGO");
	$get->setCellValue('B8', "DENOMINACIÓN");
	$get->setCellValue('C8', "TOTAL REQUERIMIENTO");
	

	 $styleArray = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THICK,
                'color' => array('argb' => '#1F1F1F'),
            ),
        ),
    );

    $get->getStyle('A2:B5')->applyFromArray($styleArray);
	$get->getStyle('A2:B5')->getFont()->setSize(15);


	$get->getStyle('A8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('32FC5D');
	$get->getStyle('B8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('32FC5D');
	$get->getStyle('C8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('32FC5D');

	$get->getStyle('A8')->getFont()->setSize(15);
	$get->getStyle('B8')->getFont()->setSize(15);
	$get->getStyle('C8')->getFont()->setSize(15);

    
	$data = json_decode($_POST['data_partidas_to_excel_or_pdf'],true);
	$num = 8;
	foreach ($data as $num_global => $arr_global) {
		$num++;
		$get->setCellValue('A'.$num, $num_global.".00".".00".".00".".00");
		$get->setCellValue('B'.$num, $arr_global['nombre']);
		$get->setCellValue('c'.$num, $arr_global['monto']);
		if (isset($arr_global['hijos'])) {
			foreach ($arr_global['hijos'] as $num_partida => $arr_partida) {
				$num++;
				$get->setCellValue('A'.$num, $num_global.".".$num_partida.".00".".00".".00");
				$get->setCellValue('B'.$num, $arr_partida['nombre']);
				$get->setCellValue('c'.$num, $arr_partida['monto']);
				$get->getStyle('A'.$num)->getFont()->setBold(true);
				$get->getStyle('B'.$num)->getFont()->setBold(true);
				$get->getStyle('C'.$num)->getFont()->setBold(true);
				if (isset($arr_partida['hijos'])) {
					foreach ($arr_partida['hijos'] as $num_generico => $arr_generico) {
						$num++;
						$get->setCellValue('A'.$num, $num_global.".".$num_partida.".".$num_generico.".00".".00");
						$get->setCellValue('B'.$num, $arr_generico['nombre']);
						$get->setCellValue('c'.$num, $arr_generico['monto']);
						$get->getStyle('A'.$num)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
						$get->getStyle('B'.$num)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
						$get->getStyle('C'.$num)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
						if (isset($arr_generico['hijos'])) {
							foreach ($arr_generico['hijos'] as $num_especifico => $arr_especifico) {
								$num++;
								$get->setCellValue('A'.$num, $num_global.".".$num_partida.".".$num_generico.".".$num_especifico.".00");
								$get->setCellValue('B'.$num, $arr_especifico['nombre']);
								$get->setCellValue('c'.$num, $arr_especifico['monto']);
								if (isset($arr_especifico['hijos'])) {
									foreach ($arr_especifico['hijos'] as $num_sub_especifico => $arr_sub_especifico) {
										$num++;
										$get->setCellValue('A'.$num, $num_global.".".$num_partida.".".$num_generico.".".$num_especifico.".".$num_sub_especifico);
										$get->setCellValue('B'.$num, $arr_sub_especifico['nombre']);
										$get->setCellValue('c'.$num, $arr_sub_especifico['monto']);
									}
								}
							}
						}
					}
				}
			}	
		}
	}



	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Patidas_presupuestarias.xlsx"');
	header('Cache-Control: max-age=0');

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');


?>
