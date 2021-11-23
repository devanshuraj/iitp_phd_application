<?php
include ('session.php');
include_once ('dbconn.php');
require_once('E:\xaamp\htdocs\Classes/PHPExcel.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function dfs($i, $j) {
    $letter = '';
             
    while($j != 0){
       $p = ($j - 1) % 26;
       $j = intval(($j - $p) / 26);
       $letter = chr(65 + $p) . $letter;
    }
    
    return $letter.$i;
}

function change_format($s, $d) {
	if($s == '0000-01-01') {
		return "NA";
	}
	if($d == 0 && $s == '2000-01-01') {
		return "NA";
	}
	if(strlen($s) != 10)
		return $s;
    $year = substr($s, 0, 4);
    $month = substr($s, 5, 2);
    $day = substr($s, 8, 2);
	$monthNum  = (int)$month;
	$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
	$monthName = substr($monthName, 0, 3);
    return $day."-".$monthName."-".$year;
}


function not_null($s) {
	if(strlen($s) == 0 || $s == "0000-01-01" || $s == "NULL") {
		return false;
	}
	return true;
}

$default = "NULL";

if($access==1)
{
 	$cur_department = $_GET["phd_department"];
	//  echo $cur_department;

	$excel = new PHPExcel();
	$excel -> setActiveSheetIndex(0);
	$i = 1;
	$csv = 'E:/xaamp/htdocs/Devanshu_btp2/phd_D/dept/'.$cur_department.'.csv';
	// echo " ".$csv;
	$fh = fopen($csv, 'r');
	$headings = ['App. No.', 'Name / Address', 'Application and Gate info', 'Topics of interest Descending by preference', 'Degree', '% of marks', 'Year Completed', 'UNIVERSITY', 'Experiences (For employed Candidates)'];
	while(list($id_number, $personal_full_name, $personal_gender, $personal_fathers_name, $personal_birth_category, $personal_date_of_birth, $personal_address, $personal_state, $personal_nationality, $personal_pincode, $personal_contact, $personal_email, $personal_marital_status, $personal_disable_status, $tenth_equi_exam_passed, $tenth_equi_school_name, $tenth_equi_board_name, $tenth_equi_passing_year, $tenth_equi_percentage, $tenth_equi_out_of, $tenth_equi_complete_status, $tenth_equi_notes_if_any, $inter_equi_exam_passed, $inter_equi_school_name, $inter_equi_board_name, $inter_equi_passing_year, $inter_equi_percentage, $inter_equi_out_of, $inter_equi_complete_status, $inter_equi_notes_if_any, $ug_exam_passed, $ug_degree_name, $ug_discipline, $ug_college_name, $ug_univeristy_name, $ug_passing_year, $ug_percentage, $ug_out_of, $ug_complete_status, $ug_notes_if_any, $pg_1_exam_passed, $pg_1_pg_degree_name, $pg_1_discipline, $pg_1_college_name, $pg_1_univeristy_name, $pg_1_passing_year, $pg_1_percentage, $pg_1_out_of, $pg_1_complete_status, $pg_1_notes_if_any, $pg_2_exam_passed, $pg_2_pg_degree_name, $pg_2_discipline, $pg_2_college_name, $pg_2_univeristy_name, $pg_2_passing_year, $pg_2_percentage, $pg_2_out_of, $pg_2_complete_status, $pg_2_notes_if_any, $other_exam_passed, $other_pg_degree_name, $other_discipline, $other_college_name, $other_univeristy_name, $other_passing_year, $other_percentage, $other_out_of, $other_complete_status, $other_notes_if_any, $work_1_experience_type, $work_1_organization_name, $work_1_position, $work_1_from_date, $work_1_to_date, $work_1_experience_duration, $work_1_nature_of_work, $work_1_current_job, $work_2_experience_type, $work_2_organization_name, $work_2_position, $work_2_from_date, $work_2_to_date, $work_2_experience_duration, $work_2_nature_of_work, $work_2_current_job, $work_3_experience_type, $work_3_organization_name, $work_3_position, $work_3_from_date, $work_3_to_date, $work_3_experience_duration, $work_3_nature_of_work, $work_3_current_job, $phd_application_category, $phd_department, $phd_is_your_btech_from_iit, $first_preference_area_of_research, $second_preference_area_of_research, $third_preference_area_of_research, $fourth_preference_area_of_research, $gate_registration_no, $gate_paper_code, $gate_score_out_of_1000, $gate_rank, $gate_valid_from, $gate_valid_upto, $gate_notes_if_any, $jrf_qualified_status, $jrf_valid_from, $jrf_valid_upto, $dst_qualified_status, $dst_valid_from, $dst_valid_upto, $payment_method, $payment_reference_number, $payment_amount, $app_id, $filled_status, $added_updated, $net_roll_number, $net_subject, $net_marks_obtained) = 
	fgetcsv($fh, 1000000, ",")) {
		// echo $personal_full_name.'<br/>';
		if($phd_department != $cur_department) {
			continue;
		}
		if(!not_null($filled_status)) {
			continue;
		}
		for($j = 0; $j < count($headings); $j++) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i, $j + 1), $headings[$j]);
			$excel -> getActiveSheet() -> getStyle(dfs($i, $j + 1).":".dfs($i, $j + 1)) -> applyFromArray(
				array(
					'font' => array(
						'bold'=>true
					)
				)
			);
		}
		$j = 1;
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $id_number);

		$j = 2;
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $personal_full_name);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $personal_gender);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $personal_nationality);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), "".$personal_contact);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $personal_email);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), "DOB : ".change_format($personal_date_of_birth, 1));
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), "PWD : ".$personal_disable_status);

		$j = 3;
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), "Birth Category : ".$personal_birth_category);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), "Phd Category : ".$phd_application_category);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), "DEPT : ".$phd_department);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), "Gate Paper Code : ".$gate_paper_code);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), "Gate Score : ".$gate_score_out_of_1000);
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), "Gate Score Validity : ".change_format($gate_valid_upto, 0));
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), "Gate Rank : ".$gate_rank);

		$j = 4;
		if(not_null($first_preference_area_of_research)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $first_preference_area_of_research);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $default);
		}
		if(not_null($second_preference_area_of_research)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $second_preference_area_of_research);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $default);
		}
		if(not_null($third_preference_area_of_research)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $third_preference_area_of_research);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $default);
		}
		if(not_null($fourth_preference_area_of_research)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $fourth_preference_area_of_research);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $default);
		}
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), "BTECH IIT : ".$phd_is_your_btech_from_iit);

		$j = 5;
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), "X");
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), "XII");

		if(not_null($ug_degree_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), "UG1 (".$ug_degree_name.$ug_discipline.")");
		}
		else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), "UG1");
		}
		if(not_null($pg_1_pg_degree_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), "PG1 (".$pg_1_pg_degree_name.$pg_1_discipline.")");
		}
		else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), "PG1");
		}
		if(not_null($pg_2_pg_degree_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), "PG2 (".$pg_1_pg_degree_name.$pg_1_discipline.")");
		}
		else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), "PG2");
		}
		if(not_null($other_pg_degree_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), "OTHER (".$other_pg_degree_name.$other_discipline.")");
		}
		else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), "OTHER");
		}
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), "NET");
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 8, $j), "DST Qualified Status");
		$excel -> getActiveSheet() -> setCellValue( dfs($i + 9, $j), "JRF Qualified Status");

		$j = 6;
		if(not_null($tenth_equi_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $tenth_equi_percentage."/".$tenth_equi_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $default);
		}
		if(not_null($inter_equi_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $inter_equi_percentage."/".$inter_equi_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $default);
		}
		if(not_null($ug_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $ug_percentage."/".$ug_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $default);
		}
		if(not_null($pg_1_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $pg_1_percentage."/".$pg_1_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $default);
		}
		if(not_null($pg_2_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $pg_2_percentage."/".$pg_2_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $default);
		}
		if(not_null($other_percentage)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $other_percentage."/".$other_out_of);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $default);
		}
		if(not_null($net_subject)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), $net_subject);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), $default);
		}
		if(not_null($dst_qualified_status)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 8, $j), $net_subject);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 8, $j), $default);
		}
		if(not_null($jrf_qualified_status)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 9, $j), $net_subject);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 9, $j), $default);
		}

		$j = 7;
		if(not_null($tenth_equi_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $tenth_equi_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $default);
		}
		if(not_null($inter_equi_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $inter_equi_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $default);
		}
		if(not_null($ug_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $ug_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $default);
		}
		if(not_null($pg_1_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $pg_1_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $default);
		}
		if(not_null($pg_2_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $pg_2_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $default);
		}
		if(not_null($other_passing_year)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $other_passing_year);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $default);
		}
		if(not_null($net_marks_obtained)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), $net_marks_obtained);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 7, $j), $default);
		}
		if(not_null($dst_valid_upto)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 8, $j), $dst_valid_upto);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 8, $j), "NA");
		}
		if(not_null($jrf_valid_upto)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 9, $j), $jrf_valid_upto);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 9, $j), "NA");
		}

		$j = 8;
		if(not_null($tenth_equi_school_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $tenth_equi_school_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $default);
		}
		if(not_null($inter_equi_school_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $inter_equi_school_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $default);
		}
		if(not_null($ug_college_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $ug_college_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $default);
		}
		if(not_null($pg_1_college_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $pg_1_college_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 4, $j), $default);
		}
		if(not_null($pg_2_college_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $pg_2_college_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 5, $j), $default);
		}
		if(not_null($other_college_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $other_college_name);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 6, $j), $default);
		}

		$j = 9;
		if(not_null($work_1_organization_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $work_1_organization_name.", Current job : ".$work_1_current_job.", Exp Type : ".$work_1_experience_type.", Duration : ".$work_1_experience_duration);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 1, $j), $default);
		}
		if(not_null($work_2_organization_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $work_2_organization_name.", Current job : ".$work_2_current_job.", Exp Type : ".$work_2_experience_type.", Duration : ".$work_2_experience_duration);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 2, $j), $default);
		}
		if(not_null($work_3_organization_name)) {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $work_3_organization_name.", Current job : ".$work_3_current_job.", Exp Type : ".$work_3_experience_type.", Duration : ".$work_3_experience_duration);
		} else {
			$excel -> getActiveSheet() -> setCellValue( dfs($i + 3, $j), $default);
		}

		for($x = $i; $x <= $i + 9; $x++) {
			for($y = 1; $y <= 9; $y++) {
				$excel -> getActiveSheet() -> getStyle(dfs($x, $y).":".dfs($x, $y)) -> applyFromArray(
					array(
						'borders' => array(
							'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							),
							'vertical' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						)
					)
				);
			}
		}
		
		$i += 12;
	}
	$lastrow = $excel->getActiveSheet()->getHighestRow();
	foreach(range('A','I') as $columnID) {
		$excel -> getActiveSheet() -> getColumnDimension($columnID) -> setAutoSize(true);
		$excel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal('left');
		$excel->getActiveSheet()
		->getStyle($columnID."1:".$columnID.$lastrow)
		->getAlignment()
		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	}
	
    $folder = "E:/xaamp/htdocs/Devanshu_btp2/phd_D/store/".$cur_department."1";
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
	$out = $cur_department.'.xlsx';
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename='.$out);
	header('Cache-Control: max-age=0');
	
	// write the result to a file
	$file = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
	// output to php output instead of filename
	$file->save('php://output');
	// $file->save(str_replace(__FILE__,$folder."/".$out,__FILE__));
}
else
echo "Unauthroized Attempt";
?>
