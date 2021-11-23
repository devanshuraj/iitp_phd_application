<!DOCTYPE html>
<html>

<body>
<table align="left">
<tr>
<td><table align="left" border = 4><tr><td><a href="csv_to_pdf.php"> HOME </a></td></tr></table>
</table>
<table align="right">
<tr>
</body>
</html>

<?php

 session_start();
  
// if (isset($_POST['submitted'])) {


include('library/tcpdf.php');

class MYPDF extends TCPDF {
    public function Header() {
        if ($this->page > 1){
            return;
        }
        $image_file = 'images/iitp.png';
        $this->Image($image_file, 3, 5, 20, '', 'PNG', '', 'N', false, 300, 'L', false, false, 0, false, false, false);

        $image_file = 'images/iitp_header.png';
        $this->Image($image_file, 30, 5, 100, '', 'PNG', '', 'N', false, 300, 'R', false, false, 0, false, false, false);
    }
}


class GoodZipArchive extends ZipArchive 
{
	//@author Nicolas Heimann
	public function __construct($a=false, $b=false) { $this->create_func($a, $b);  }
	
	public function create_func($input_folder=false, $output_zip_file=false)
	{
		if($input_folder !== false && $output_zip_file !== false)
		{
			$res = $this->open($output_zip_file, ZipArchive::CREATE);
			if($res === TRUE) 	{ $this->addDir($input_folder, basename($input_folder)); $this->close(); }
			else  				{ echo 'Could not create a zip archive. Contact Admin.'; }
		}
	}
	
    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive 
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}

function change_format($s) {
    $year = substr($s, 0, 4);
    $month = substr($s, 5, 2);
    $day = substr($s, 8, 2);
    return $day."-".$month."-".$year;
}

function format_name($s) {
    $arrs = explode(" ", $s);
    $concat_name = "";
    for($i = 0; $i < sizeof($arrs); $i++) {
        $concat_name = $concat_name.$arrs[$i];
    }
    return $concat_name;
}

$uploaddir = 'E:/xaamp/htdocs/Devanshu_btp2/phd_D/phd_admin/csv/';
// $uploadfile = $uploaddir . basename($_FILES['csv']['tmp_name']);
$file_name = $uploaddir."file.csv";
// move_uploaded_file($_FILES['csv']['tmp_name'], $file_name);

$file = fopen($file_name, 'r');
$row = array_fill(0, 124, 0);
$ctr = 0;
$cur_department = $_GET["phd_department"];
while (($line = fgetcsv($file)) !== FALSE) {
    $ctr = $ctr + 1;
    if($cur_department != $line[95]) continue;
    if($ctr == 1) continue;
    $stud_id = $line[0];
    for($i = 0; $i < 123; $i++) {
        $row[$i + 1] = $line[$i];
    }
    $NameOfApplicant = $row[2];
    $guardianOrSpouseName = $row[4];
    $dateOfBirth = $row[6];
    $nationality = $row[9];
    $gender = $row[3];
    $martialStatus = $row[13];
    $birthCategory = $row[5];
    $pwdStatus = $row[14];
    $contactDetails_address = $row[7];
    $contactDetails_state = $row[8];
    $contactDetails_pincode = $row[10];
    $contactDetails_email = $row[12];
    $contactDetails_mobileNo = $row[11];
    $department = $row[96];
    $applicationCategory = $row[95];
    $amount = $row[117];
    $paymentMethod = $row[115];
    $paymentReferenceNumber = $row[116];
    $first_pref = $row[98];
    $second_pref = $row[99];
    $third_pref = $row[100];
    $fourth_pref = $row[101];
    $net_roll_number = $row[121];
    $net_subject = $row[122];
    $net_marks_obtained = $row[123];
    $phd_application_category = $row[95];
    $phd_department = $row[96];
    $work1_current_job = $row[78];
    $work2_current_job = $row[86];
    $work3_current_job = $row[94];
    $jrf_qualified_status = $row[109];

    $work1_experience_duration = $row[76];
    $work2_experience_duration = $row[84];
    $work3_experience_duration = $row[92];
    
    
    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('IITP');
    $pdf->SetTitle('PhD APPLICATION FORM');
    $pdf->SetSubject('PhD APPLICATION FORM');
    $pdf->SetKeywords('PhD, PDF, APPLICATION, FORM');
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->setPrintFooter(false);
    
    //default marggins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $margin_left = 20;
    $margin_right = 6;
    $margin_top = 6;
    $margin_bottom = 5;
    $pdf->SetMargins($margin_left, $margin_top, $margin_right);
    $pdf->SetHeaderMargin($margin_top);
    $pdf->SetAutoPageBreak(TRUE, $margin_bottom);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->SetFont('times', '', 11);
    
    // Page 1
    $pdf->AddPage();
    // $pdf->setCellPaddings(1.5, 1, 0.5, 1);
    $pdf->setCellPaddings(1.5, 0.7, 0.8, 0.5);
    $pdf->Ln(25);
    // $pdf->SetFont('times', 'B');
    $available_width = ($pdf->getPageWidth()-26);
    $html = '<b>For Office Use: Sl. No.: </b>IITP/ACAD/PhD/2021/1___';
    $pdf -> MultiCell(0.5 * $available_width, 7,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>For Dept. Use: App. No.: </b>'.$stud_id;
    $pdf -> MultiCell(0.5 * $available_width, 7,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>(Fill the details of the application fee in favour of IIT Patna)</b>';
    $pdf -> MultiCell($available_width, 0,   $html,   1,   'C',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Amount : </b> Rs. '.$amount;
    $pdf -> MultiCell($available_width/7, 14,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Ref./Journal No. </b>';
    $pdf -> MultiCell($available_width/4, 14,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Payment : </b>'.$paymentMethod.' ('.$paymentReferenceNumber.')';
    $pdf -> MultiCell($available_width/3, 14,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Dated: </b>';
    $pdf -> MultiCell(23 * $available_width/84, 14,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    
    $start_position_for_photograph = $pdf->GetY();
    $html = '<b>1.  Full Name of the Applicant : </b>'. $NameOfApplicant;
    $pdf -> MultiCell(0.85 * $available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>2.  Father’s/Guardian’s/Spouse’s Name : </b>'.$guardianOrSpouseName;
    $pdf -> MultiCell(0.85 * $available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>3.  DOB (dd-mm-yyyy) : </b>'.change_format($dateOfBirth);
    $pdf -> MultiCell(0.4 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>4.  Nationality : </b>'.$nationality;
    $pdf -> MultiCell(0.3 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>5.  PIN : </b>'.$contactDetails_pincode;
    $pdf -> MultiCell(0.3 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf->SetFont('times', '', 10);
    $html = '<b>6.  Gender : </b>'.$gender;
    $pdf -> MultiCell(0.22 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $birthCategory = substr($birthCategory, 0, 7);
    $html = '<b>7.  Category : </b>'.$birthCategory;
    $pdf -> MultiCell(0.25 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);

    $html = '<b>8. PwD : </b>'.$pwdStatus;
    $pdf -> MultiCell(0.18 * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    

    $html = '<b>9.  Marital Status : </b>'.$martialStatus;
    $pdf -> MultiCell((1.0-0.25-0.22) * 0.85 * $available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $end_position_for_photograph = $pdf->GetY();
    $pdf->SetFont('times', '', 11);
    $pdf->setJPEGQuality(75);
    if(strlen($gender) == 4) $image_dir = 'images/male.jpg';
    else $image_dir = 'images/female.jpg';
    if(file_exists("PhD-2021/".$phd_department."/".$phd_application_category."/".format_name($NameOfApplicant)."_".$stud_id."/".$stud_id."_photo.jpg"))
        $image_dir = "PhD-2021/".$phd_department."/".$phd_application_category."/".format_name($NameOfApplicant)."_".$stud_id."/".$stud_id."_photo.jpg";
    $info = getimagesize($image_dir);
    if($info[2] != IMAGETYPE_JPEG){
        if(strlen($gender) == 4) $image_dir = 'images/male.jpg';
        else $image_dir = 'images/female.jpg';
    }
    $pdf->Image($image_dir, 0.85*$available_width + $margin_left, $start_position_for_photograph, 0.15*$available_width, ($end_position_for_photograph-$start_position_for_photograph), 'JPG', '', '', false, 300, '', false, false, 1, false, false, false);
    
    $pdf->SetFont('times', '', 10);
    $html = '<b>10(a).  Contact Address : </b>'.$contactDetails_address;
    $pdf -> MultiCell($available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $pdf->SetFont('times', '', 11);

    $html = '<b>10(b). Mob No : </b>'.$contactDetails_mobileNo;
    $pdf -> MultiCell($available_width * 0.33, 0,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>10(c). Email : </b>'.$contactDetails_email;
    $pdf -> MultiCell($available_width * 0.67, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>11.  School/Department at which the candidate seeks Ph.D admission is : </b>'.$department;
    $pdf -> MultiCell($available_width , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>12.  Seeking Ph.D admission under the category : </b>'.$applicationCategory;
    $pdf -> MultiCell($available_width , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>13. Choices for PhD specialisation';//(See:Detailed Advertisement available on the website),in order of preference</b>';
    $pdf -> MultiCell($available_width  , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    

    $html = '<b>1st Pref : </b>'.$first_pref;
    $pdf -> MultiCell($available_width  , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>2nd Pref : </b>'.$second_pref;
    $pdf -> MultiCell($available_width , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>3rd Pref : </b>'.$third_pref;
    $pdf -> MultiCell($available_width  , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>4th Pref : </b>'.$fourth_pref;
    $pdf -> MultiCell($available_width  , 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $tenth_equi_exam_passed = $row[15];
    $tenth_equi_school_name = $row[16];
    $tenth_equi_board_name = $row[17];
    $tenth_equi_passing_year = $row[18];
    $tenth_equi_percentage = $row[19];
    $tenth_equi_out_of = $row[20];
    $tenth_equi_complete_status = $row[21];

    $inter_equi_exam_passed = $row[23];
    $inter_equi_school_name = $row[24];
    $inter_equi_board_name = $row[25];
    $inter_equi_passing_year = $row[26];
    $inter_equi_percentage = $row[27];
    $inter_equi_out_of = $row[28];
    $inter_equi_complete_status = $row[29];

    $ug_degree_name = $row[32];
    $ug_discipline = $row[33];
    $ug_college_name = $row[34];
    $ug_univeristy_name = $row[35];
    $ug_passing_year = $row[36];
    $ug_percentage = $row[37];
    $ug_out_of = $row[38];
    $ug_complete_status = $row[39];

    $pg_1_pg_degree_name = $row[42];
    $pg_1_discipline = $row[43];
    $pg_1_college_name = $row[44];
    $pg_1_univeristy_name = $row[45];
    $pg_1_passing_year = $row[46];
    $pg_1_percentage = $row[47];
    $pg_1_out_of = $row[48];
    $pg_1_complete_status = $row[49];

    $pg_2_pg_degree_name = $row[52];
    $pg_2_discipline = $row[53];
    $pg_2_college_name = $row[54];
    $pg_2_univeristy_name = $row[55];
    $pg_2_passing_year = $row[56];
    $pg_2_percentage = $row[57];
    $pg_2_out_of = $row[58];
    $pg_2_complete_status = $row[59];
    
    $other_pg_degree_name = $row[62];
    $other_discipline = $row[63];
    $other_college_name = $row[64];
    $other_univeristy_name = $row[65];
    $other_passing_year = $row[66];
    $other_percentage = $row[67];
    $other_out_of = $row[68];
    $other_complete_status = $row[69];
    
    $gate_paper_code = $row[103];
    $gate_registration_no = $row[102];
    $gate_rank = $row[105];
    $gate_valid_from = $row[106];
    $phd_department = $row[96];
    $gate_score_out_of_1000 = $row[104];

    $work_1_experience_type = $row[71];
    $work_1_organization_name = $row[72];
    $work_1_position = $row[73];
    $work_1_from_date = $row[74];
    $work_1_to_date = $row[75];
    $work_1_experience_duration = $row[76];
    $work_1_nature_of_work = $row[77];
    $work_1_current_job = $row[78];

    $work_2_experience_type = $row[79];
    $work_2_organization_name = $row[80];
    $work_2_position = $row[81];
    $work_2_from_date = $row[82];
    $work_2_to_date = $row[83];
    $work_2_experience_duration = $row[84];
    $work_2_nature_of_work = $row[85];
    $work_2_current_job = $row[86];

    $work_3_experience_type = $row[87];
    $work_3_organization_name = $row[88];
    $work_3_position = $row[89];
    $work_3_from_date = $row[90];
    $work_3_to_date = $row[91];
    $work_3_experience_duration = $row[92];
    $work_3_nature_of_work = $row[93];
    $work_3_current_job = $row[94];

    $height = 17;
    
    $html = '<b>14.  Details of GATE Examination Passed</b>';
    $pdf -> MultiCell($available_width  , $height / 2.4,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>GATE Paper Code</b>';
    $pdf -> MultiCell($available_width * 0.2 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>GATE Registration Number</b>';
    $pdf -> MultiCell($available_width * 0.13 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Exam Discipline</b>';
    $pdf -> MultiCell($available_width * 0.22 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Exam Rank</b>';
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Exam Score</b>';
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Exam Passing Year</b>';
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $gate_paper_code;
    $pdf -> MultiCell($available_width * 0.2 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $gate_registration_no;
    $pdf -> MultiCell($available_width * 0.13 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $phd_department;
    $pdf -> MultiCell($available_width * 0.22 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $gate_rank;
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $gate_score_out_of_1000;
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = $gate_valid_from;
    $pdf -> MultiCell($available_width * 0.15 , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    

    $height = 6;
    $html = '<b>15. NET Exam Details</b>'.".        ".'<b>Roll No :</b>'.$net_roll_number;
    $pdf -> MultiCell($available_width  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>JRF Qualified : </b>'.$jrf_qualified_status;
    $pdf -> MultiCell($available_width * 0.5 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $html = '<b>Marks : </b>'.$net_marks_obtained;
    $pdf -> MultiCell($available_width * 0.5 , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf->SetFont('times', '', 10);
    $html = '<b>Subject : </b>'.$net_subject;
    $pdf -> MultiCell($available_width , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $pdf->SetFont('times', '', 11);
    $html = '<b>16. Details of Academic Record</b>';
    $pdf -> MultiCell($available_width  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '';
    $pdf -> MultiCell($available_width*0.1  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Degree</b>';
    $pdf -> MultiCell($available_width*0.4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Percentage or CGPA</b>';
    $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Year of Passing</b>';
    $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);

    $pdf->SetFont('times', '', 10);
    if(strlen($tenth_equi_exam_passed) > 0) {
        $html = '<b>Degree1</b>';
        $pdf -> MultiCell($available_width*0.10  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $tenth_equi_exam_passed;
        $pdf -> MultiCell($available_width*0.40  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $tenth_equi_percentage."/".$tenth_equi_out_of;
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $tenth_equi_passing_year." (".$tenth_equi_complete_status.")";
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    }
    if(strlen($inter_equi_exam_passed) > 0) {
        $html = '<b>Degree2</b>';
        $pdf -> MultiCell($available_width*0.1  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $inter_equi_exam_passed;
        $pdf -> MultiCell($available_width*0.4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $inter_equi_percentage."/".$inter_equi_out_of;
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $inter_equi_passing_year." (".$inter_equi_complete_status.")";
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);    
    }

    if(strlen($ug_degree_name) > 0) {
        $html = '<b>Degree3</b>';
        $pdf -> MultiCell($available_width*0.1  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $ug_degree_name." in ".$ug_discipline;
        $html = substr($html, 0, 35);
        $pdf -> MultiCell($available_width*0.4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $ug_percentage."/".$ug_out_of;
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $ug_passing_year." (".$ug_complete_status.")";
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    }
    if(strlen($pg_1_pg_degree_name) > 0) {
        $html = '<b>Degree4</b>';
        $pdf -> MultiCell($available_width*0.1  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_1_pg_degree_name." in ".$pg_1_discipline;
        $html = substr($html, 0, 35);
        $pdf -> MultiCell($available_width*0.4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_1_percentage."/".$pg_1_out_of;
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_1_passing_year." (".$pg_1_complete_status.")";
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    }
    if(strlen($pg_2_pg_degree_name) > 0) {
        $html = '<b>Degree5</b>';
        $pdf -> MultiCell($available_width*0.1  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_2_pg_degree_name." in ".$pg_2_discipline;
        $html = substr($html, 0, 35);
        $pdf -> MultiCell($available_width*0.4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_2_percentage."/".$pg_2_out_of;
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $html = $pg_2_passing_year." (".$pg_2_complete_status.")";
        $pdf -> MultiCell($available_width/4  , $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    }
    $pdf->SetFont('times', '', 11);
    $html = '<b>17. Professional Experience</b>';
    $pdf -> MultiCell($available_width, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Name of Organization</b>';
    $pdf -> MultiCell($available_width*0.6, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Period (From - To)</b>';
    $pdf -> MultiCell($available_width*0.4, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf->SetFont('times', '', 9);
    $experience = "";
    if($work_1_from_date != "0000-01-01" && strlen($work_1_from_date) > 0) {
        $experience = "(".$work_1_from_date." - ".$work_1_to_date.") ".'<b>Current job : </b>'.$work_1_current_job;
    }
    if(strlen($work_1_organization_name) >= 0) {
        $pdf->SetFont('times', '', 9);
        $html = substr($work_1_organization_name, 0, 55);
        $pdf -> MultiCell($available_width*0.6, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $pdf->SetFont('times', '', 10);
        $html = $experience;
        $pdf -> MultiCell($available_width*0.4, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        
    }
    $experience = "";
    if($work_2_from_date != "0000-01-01" && strlen($work_2_from_date) > 0) {
        $experience = "(".$work_2_from_date." - ".$work_2_to_date.") ".'<b>Current job : </b>'.$work_2_current_job;
    }
    if(strlen($work_2_organization_name) > 0) {
        $pdf->SetFont('times', '', 9);
        $html = substr($work_2_organization_name, 0, 55);
        $pdf -> MultiCell($available_width*0.6, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $pdf->SetFont('times', '', 10);
        $html = $experience;
        $pdf -> MultiCell($available_width*0.4, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        
    }
    $experience = "";
    if($work_3_from_date != "0000-01-01" && strlen($work_3_from_date) > 0) {
        $experience = "(".$work_3_from_date." - ".$work_3_to_date.") ".'<b>Current job : </b>'.$work_3_current_job;
    }
    if(strlen($work_3_organization_name) > 0) {
        $pdf->SetFont('times', '', 9);
        $html = substr($work_3_organization_name, 0, 55);
        $pdf -> MultiCell($available_width*0.6, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        $pdf->SetFont('times', '', 10);
        $html = $experience;
        $pdf -> MultiCell($available_width*0.4, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
        
    }
    $pdf->SetFont('times', '', 11);
    $pdf -> AddPage();
    $pdf->SetMargins($margin_left, $margin_top*2, $margin_right);
    $height = 17;
    $html = '<b>18. Details of Academic Record (Attach attested copies of certificates, mark sheets, etc)</b>';
    $pdf -> MultiCell($available_width  , $height / 2.4,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '';
    $pdf -> MultiCell($available_width * 0.1 ,$height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Degree</b>';
    $pdf -> MultiCell($available_width * 0.14, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>School or College</b>';
    $pdf -> MultiCell($available_width * 0.2 , $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Board or University</b>';
    $pdf -> MultiCell($available_width * 0.2, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Year of Passing</b>';
    $pdf -> MultiCell($available_width * 0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Percentage or CGPA</b>';
    $pdf -> MultiCell($available_width * 0.08, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Out Of</b>';
    $pdf -> MultiCell($available_width * 0.06, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Status</b>';
    $pdf -> MultiCell($available_width * 0.12, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    
    $pdf->SetFont('times', '', 9);
    $html = '<b>Degree1</b>';
    $pdf -> MultiCell($available_width*0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $pdf -> MultiCell($available_width*0.14, $height, substr(($tenth_equi_exam_passed), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($tenth_equi_school_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($tenth_equi_board_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.1 , $height, ($tenth_equi_passing_year), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.08 , $height, ($tenth_equi_percentage), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.06 , $height, ($tenth_equi_out_of), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.12 , $height, ($tenth_equi_complete_status), 1, 'L', 0, 1, '', '', true);
    
    $html = '<b>Degree2</b>';
    $pdf -> MultiCell($available_width*0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $pdf -> MultiCell($available_width*0.14, $height, substr(($inter_equi_exam_passed), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($inter_equi_school_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($inter_equi_board_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.1 , $height, ($inter_equi_passing_year), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.08 , $height, ($inter_equi_percentage), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.06 , $height, ($inter_equi_out_of), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.12 , $height, ($inter_equi_complete_status), 1, 'L', 0, 1, '', '', true);
    
    $html = '<b>Degree3</b>';
    $pdf -> MultiCell($available_width*0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    if(strlen($ug_degree_name) > 0)$html = $ug_degree_name." in ".$ug_discipline;
    else $html = "";
    $html = substr($html, 0, 35);

    $pdf -> MultiCell($available_width*0.14 , $height, $html, 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($ug_college_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($ug_univeristy_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.1 , $height, ($ug_passing_year), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.08 , $height, ($ug_percentage), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.06 , $height, ($ug_out_of), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.12 , $height, ($ug_complete_status), 1, 'L', 0, 1, '', '', true);
    
    $html = '<b>Degree4</b>';
    $pdf -> MultiCell($available_width*0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    if(strlen($pg_1_pg_degree_name) > 0)$html = $pg_1_pg_degree_name." in ".$pg_1_discipline;
    else $html = "";
    $html = substr($html, 0, 35);
    $pdf -> MultiCell($available_width*0.14 , $height, $html, 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($pg_1_college_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($pg_1_univeristy_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.1 , $height, ($pg_1_passing_year), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.08 , $height, ($pg_1_percentage), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.06 , $height, ($pg_1_out_of), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.12 , $height, ($pg_1_complete_status), 1, 'L', 0, 1, '', '', true);
    
    $html = '<b>Degree5</b>';
    $pdf -> MultiCell($available_width*0.1, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    if(strlen($pg_2_pg_degree_name) > 0)$html = $pg_2_pg_degree_name." in ".$pg_2_discipline;
    else $html = "";
    $html = substr($html, 0, 35);
    $pdf -> MultiCell($available_width*0.14 , $height, $html, 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($pg_2_college_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.2 , $height, substr(($pg_2_univeristy_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.1 , $height, ($pg_2_passing_year), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.08 , $height, ($pg_2_percentage), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.06 , $height, ($pg_2_out_of), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width*0.12 , $height, ($pg_2_complete_status), 1, 'L', 0, 1, '', '', true);
    
    $pdf->SetFont('times', '', 11);
    $height = 6;
    $html = '<b>19. Professional Experiemce, if any. (Attach attested copy of the proof).</b>';
    $pdf -> MultiCell($available_width, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Name of Organization</b>';
    $pdf -> MultiCell($available_width/4, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Position held</b>';
    $pdf -> MultiCell($available_width/4, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Nature/Type of Work</b>';
    $pdf -> MultiCell($available_width/4, $height,   $html,   1,   'L',   false,   0,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    $html = '<b>Period (From - To)</b>';
    $pdf -> MultiCell($available_width/4, $height,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    
    $height = 19;
    $pdf->SetFont('times', '', 9);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_1_organization_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_1_position), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_1_nature_of_work), 0, 40), 1, 'L', 0, 0, '', '', true);
    $experience = "";
    if($work_1_from_date != "0000-01-01" && strlen($work_1_from_date) > 0) {
        $experience = "(".$work_1_from_date." - ".$work_1_to_date.")".'<br/><b>Current job : </b>'.$work_1_current_job.'<br/><b>Duration : </b>'.$work_1_experience_duration;
    }
    $pdf -> MultiCell($available_width/4  , $height , $experience,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_2_organization_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_2_position), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_2_nature_of_work), 0, 40), 1, 'L', 0, 0, '', '', true);
    $experience = "";
    if($work_2_from_date != "0000-01-01"  && strlen($work_2_from_date) > 0) {
        $experience = "(".$work_2_from_date." - ".$work_2_to_date.")".'<br/><b>Current job : </b>'.$work_2_current_job.'<br/><b>Duration : </b>'.$work_2_experience_duration;
    }
    $pdf -> MultiCell($available_width/4  , $height , $experience,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_3_organization_name), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_3_position), 0, 40), 1, 'L', 0, 0, '', '', true);
    $pdf -> MultiCell($available_width/4 , $height, substr(($work_3_nature_of_work), 0, 40), 1, 'L', 0, 0, '', '', true);
    $experience = "";
    if($work_3_from_date != "0000-01-01"  && strlen($work_3_from_date) > 0) {
        $experience = "(".$work_3_from_date." - ".$work_3_to_date.")".'<br/><b>Current job : </b>'.$work_3_current_job.'<br/><b>Duration : </b>'.$work_3_experience_duration;
    }
    $pdf -> MultiCell($available_width/4  , $height , $experience,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf->SetFont('times', '', 11);
    
    $html = '<b>20.  List of Publications/ Projects, if any.</b> (Attach a separate sheet with details, if necessary.) ';
    $pdf -> MultiCell($available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf -> MultiCell($available_width , 0, "     No. of Papers published in Refereed Journals:\n     No. of Papers presented in Refereed Conferences:", 1, 'L', 0, 1, '', '', true);
    
    $html = '<b>21. List of Enclosures</b> (Please Tick).';
    $pdf -> MultiCell($available_width, 0,   $html,   1,   'L',   false,   1,    '',    '',  true,  0,   true,  true,   0,   'T', false);
    
    $pdf -> MultiCell($available_width , 0, "    A. Reference/ Journal No. details.", 1, 'L', 0, 1, '', '', true);
    $pdf -> MultiCell($available_width , 0, "    B. Self attested copies of", 1, 'L', 0, 1, '', '', true);
    $pdf -> MultiCell($available_width , 0, "       (a) Mark Sheet & certificates (from class X to Highest degree obtained/appeared), (both sides)", 1, 'L', 0, 1, '', '', true);
    $pdf -> MultiCell($available_width , 0, "       (b) Caste certificate (if applicable), (both sides)", 1, 'L', 0, 1, '', '', true);
    $pdf -> MultiCell($available_width , 0, "       (c) GATE certificate (both sides)", 1, 'L', 0, 1, '', '', true);
    $pdf -> MultiCell($available_width , 0, "       (d) Experience certificate (if any) (both sides)", 1, 'L', 0, 1, '', '', true);
    $pdf->SetFont('times', '', 12);
    



    $folder = "E:/xaamp/htdocs/Devanshu_btp2/phd_D/try/".$phd_department;
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
    $arrs = explode(" ", $NameOfApplicant);
    $names = "";
    for($i = 0; $i < sizeof($arrs); $i++) {
        if($i != 0)
            $names = $names."_".$arrs[$i];
        else
        $names = $names.$arrs[$i];
    }
    $phd1 = "";
    $arrs = explode(" ", $phd_application_category);
    for($i = 0; $i < sizeof($arrs); $i++) {
        if($arrs[$i] == "-") 
            continue;
        if($i != 0)
            $phd1 = $phd1."_".$arrs[$i];
        else
            $phd1 = $phd1.$arrs[$i];
    }

    $phd2 = "";
    $arrs = explode(" ", $phd_department);
    for($i = 0; $i < sizeof($arrs); $i++) {
        if($arrs[$i] == "-") 
            continue;
        if($i != 0)
            $phd2 = $phd2."_".$arrs[$i];
        else
            $phd2 = $phd2.$arrs[$i];
    }
    $filename = $names."_".$gender."_".$birthCategory."_".$contactDetails_mobileNo."_"."PwD-".$pwdStatus.'_Ph.D-2021-'.$phd1.'-'.$phd2.'-'.$stud_id;
    $fileNL = $folder."/".$filename;
    $pdf->Output($fileNL.'.pdf', 'F');
}

fclose($file);

    $out = "E:/xaamp/htdocs/Devanshu_btp2/phd_D/phd_admin/".$phd_department.".zip";
    new GoodZipArchive($folder, $out) ;
    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename=".$phd_department.".zip");
    header('Content-Length: ' . filesize($zipname));
    header("Location: ".$phd_department.".zip");

// }
?>
