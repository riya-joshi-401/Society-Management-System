<?php

include "../../../config.php";

require '../../../PdfUtils/vendor/autoload.php';
use Dompdf\Dompdf;

require_once "../../../MailUtils/vendor/autoload.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['genbill-btn'])) {
    //adding bills queue for all flats to the queue table

    //bill dir"
    $bill_dir = "C:/xampp/htdocs/society-management-system/BillUploads/";
    //calc bill month(prev month)
    $tgl = date("d F Y ");
    $bmonth = date("M Y", mktime(0, 0, 0, date("m", strtotime($tgl)) - 1, 1, date("Y", strtotime($tgl))));

    // calc gen date
    $gen_date = date("Y/m/d");

    //calc due date
    $due_date = date_create(date("Y/m/d"));
    date_add($due_date, date_interval_create_from_date_string("15 days"));
    $due_date = date_format($due_date, "Y/m/d");

    //get all flats
    $getflat_sql = mysqli_query($con, "SELECT * from allotments");

    while ($f_row = mysqli_fetch_assoc($getflat_sql)) {

        $flatid = $f_row['FlatID'];

        $getdets_sql = mysqli_query($con, "SELECT flatarea.Ratepsq, flatarea.FlatArea,
        GROUP_CONCAT(additional_charges.Amount) as Amount, GROUP_CONCAT(additional_charges.Reason) as Reason,
        allotments.OwnerName, allotments.OwnerEmail, allotments.OwnerContactNumber,
        allotments.OwnerAlternateContactNumber, flats.BlockNumber,flats.Floor,flatarea.FlatArea,flats.FlatNumber from flatarea
        inner join flats on flatarea.FlatAreaID=flats.FlatAreaID inner join allotments on
        allotments.FlatID=flats.FlatID left join additional_charges on additional_charges.FlatID = flats.FlatID
        where flats.FlatID='$flatid'; ");

        $getdets_row = mysqli_fetch_assoc($getdets_sql);
        $rate = $getdets_row['Ratepsq'];
        $farea = $getdets_row['FlatArea'];
        $acharges_array = (explode(",", $getdets_row['Amount']));
        $acharges_reasons = (explode(",", $getdets_row['Reason']));
        $oname = $getdets_row['OwnerName'];
        $oemail = $getdets_row['OwnerEmail'];
        echo $oemail;
        $ocontact = $getdets_row['OwnerContactNumber'];
        $oacontact = $getdets_row['OwnerAlternateContactNumber'];
        $blockno = $getdets_row['BlockNumber'];
        $flatno = $getdets_row['FlatNumber'];
        $floor = $getdets_row['Floor'];
        $farea = $getdets_row['FlatArea'];
        //calculating maint charges
        $mcharges = $rate * $farea;

        //adding all additional charges
        $acharges = array_sum($acharges_array);

        //adding maint and additional charges to get total charges
        $tcharges = $mcharges + $acharges;

        $charges_after_due = $tcharges + ($tcharges * 0.21);

        //here we start with creating the bill pdf
        $pdf = new Dompdf();

        //make a BillUploads directory if it does not exist
        if (!is_dir($bill_dir)) {
            mkdir($bill_dir, 0777, true);
        }

        //creating a bill pdf using dompdf and a predefined bill template with parameters
        $file_name = $blockno . '-' . $flatno . '-' . $bmonth . '.pdf';
        //  echo $file_name;
        $filemime = "application/pdf";
        $data = $bill_dir . '' . $blockno . '-' . $flatno . '-' . $bmonth . '.pdf';

        $html_code = bill_template($blockno, $flatno, $farea, $floor, $oname, $oemail, $ocontact, $oacontact, $bmonth, $mcharges, $acharges, $acharges_reasons, $tcharges, $gen_date, $due_date, $charges_after_due);
        echo $html_code;
        $pdf->load_html($html_code);
        $pdf->render();
        $file = $pdf->output();
        file_put_contents($data, $file);

        //inserting the details of bill in the database
        $bill_sql = "INSERT INTO bill_queue (`bill_id`, `FlatID`,`to_email` ,`bill_month`, `maintenance_charges`,
        `additional_charges`, `total_charges`, `bill_gen_date`, `bill_due_date`, `charges_after_due`,
        `filename`, `filemime`, `data`, `is_sent`) VALUES ('','$flatid','$oemail','$bmonth','$mcharges','$acharges','$tcharges',
        '$gen_date','$due_date','$charges_after_due','$file_name','$filemime','$data','0')";
// echo   $bill_sql ;

        mysqli_query($con, $bill_sql);
        // echo $flatid;
    }
    //mailing to each owner and also updating the is_sent status to 1 in the database

    $myMail = new PHPMailerHelper();
    $myMail->sendEmail();

    $_SESSION['success_message'] = "Bills generated and sent successfully";
    header("Location: ../../add_bills.php");
    exit();
}

function bill_template($block, $flat, $farea, $floor, $oname, $oemail, $ocontact, $oacontact, $bmonth, $mcharges, $acharges, $reason, $tcharges, $gen_date, $due_date, $charges_after_due)
{

    return $html_code = '<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
    }

    .name {
        align: center;
        text-align: center;
    }

    .bold-text {
        font-weight: bold;
    }

    .c1 {
        width: 10%;
        text-align: center;
    }

    .c2 {
        width: 70%;
    }

    .c3 {
        width: 20%;
        text-align: end;
    }
    </style>

<div class="wrapper">
    <table style="width:100%">
        <tr>
            <td colspan="4" class="name" style="align: center; text-align: center;">
                <h2>PERJ Co-operative Housing Society </h2><br> Address: Vishnu
                Nagar(W),
                Mumbai - 400600
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bold-text name" style="font-weight: bold;align: center;text-align: center;">
                MAINTENANCE BILL</td>
        </tr>
        <tr>
            <td style="border: none;" colspan="2">Unit No.:' . $block . ' -' . $flat . '</td>
            <td style="border: none;" colspan="1">Name: ' . $oname . '</td>

            <td style="border: none;" colspan="1">Bill No.: 1</td>
        </tr>
        <tr>
        <td style="border: none;" colspan="2">Unit Area:' . $farea . ' Sq Ft</td>

        <td style="border: none;" colspan="1">Floor: ' . $floor . '</td>
        <td style="border: none;" colspan="1">Bill Date:' . $gen_date . ' </td>
        </tr>
        <tr>
        <td style="border: none;" colspan="3">Unit Type: Residential</td>
        <td style="border: none;" colspan="1">Bill For:' . $bmonth . ' </td>
        </tr>
        <tr>
        <td style="border: none;" colspan="3"></td>
        <td style="border: none;" colspan="1">Due Date: ' . $due_date . '</td>
        </tr>
        </td>
        </tr>
        <tr>
            <th class="c1" style="width: 10%;text-align: center;">Sr No.</th>
            <th class="c2" colspan="2">Particulars of Charges</th>
            <th class="c3" style="width: 20%;text-align: end;">Amount (Rs)</th>
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">1</td>
            <td colspan="2">Sinking Fund</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.0444 . '</td>
            <!-- 4.44% of total -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">2</td>
            <td colspan="2">Repair Fund</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.213 . '</td>
            <!-- 21.3% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">3</td>
            <td colspan="2">Electricity Charges</td>
            <td class="c3" style="width: 20%;text-align: end;" >' . $mcharges * 0.1785 . ' </td>
                <!-- 17.85% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">4</td>
            <td colspan="2">Water Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"> ' . $mcharges * 0.0674 . '</td>
            <!-- 6.74% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">5</td>
            <td colspan="2">Salary Charges</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.2261 . '</td>
            <!-- 22.61% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">6</td>
            <td colspan="2">Lift Maintainance Charges</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.0892 . '</td>
            <!-- 8.92% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">7</td>
            <td colspan="2">Insurance Charges</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.0105 . '</td>
            <!-- 1.05% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">8</td>
            <td colspan="2">Cultural Fund</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.0198 . '</td>
            <!-- 1.98% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">9</td>
            <td colspan="2">Service Charges</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $mcharges * 0.1511 . '</td>
            <!-- 15.11% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">9</td>
            <td colspan="2">Additional Charges: ' . implode(", ", $reason) . '</td>
            <td class="c3" style="width: 20%;text-align: end;">' . $acharges . '</td>
            <!-- 15.11% -->
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:bold;">Total Maintenance Charges:</td>
            <td class="c3" style="width: 20%;text-align: end;"> Rs. ' . $mcharges . '</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:bold;">Total Amount Before due date:</td>
            <td class="c3" style="width: 20%;text-align: end;"> Rs. ' . $tcharges . '</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:bold;">Total Amount After due date:</td>
            <td class="c3" style="width: 20%;text-align: end;">
                Rs.' . ($tcharges + $tcharges * 0.21) . '</td>
        </tr>
    </table>
</div>';
}

class PHPMailerHelper
{

    private $servername = "localhost";
    private $password = "";
    private $username = "root";
    private $dbname = "sms";
    private $port = "3306";
    private $base_dir = "C:/xampp/htdocs/society-management-system/BillUploads/";
    private $conn;

    public function __construct()
    {

        $mail = new PHPMailer();
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        try {
            $mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = '@gmail.com';
            $mail->Password = 'password';
// $mail->Port = 465;

        } catch (Exception $e) {
            die("Hey i am in catch");
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        $this->mail = $mail;

    }

    public function sendEmail()
    {
        echo "mail";

        $query = "select * from bill_queue where is_sent=0";
        $result = mysqli_query($this->conn, $query);

        $mail = $this->mail;
        if ($result->num_rows > 0) {
            $base_dir = "C:/xampp/htdocs/society-management-system/BillUploads/";
            while ($row = mysqli_fetch_array($result)) {

                $mail->clearAllRecipients();
                $mail->clearAttachments();

                $mail->setFrom('sms.perj@gmail.com', 'sms');
                $mail->addAddress($row['to_email']);
                $mail->Subject = "Maintenance Bill";
                $mail->Body = 'Dear member, please find the maintenance bill attached. ';
                if ($row['filename'] != '') {
                    $mail->addAttachment($base_dir . $row['filename']);
                    echo $base_dir . $row['filename'];
                }
// die($mail->send());
                if ($mail->send()) {
                    echo "Successfully Sent the email to";
                    $updateQuery = "Update bill_queue set is_sent = 1 where bill_id = {$row['bill_id']}";
                    $updated_at = date("Y-m-d H:i:s");
                    $this->conn->query($updateQuery);
                    $insertbillq = "INSERT into bills_paid (`BillID`, `BillQueueID`, `FlatID`, `BillAmount`, `Status`, `Receipt`, `ReceiptName`, `updated_at`) values
                    ('','{$row['bill_id']}','{$row['FlatID']}','{$row['total_charges']}','0','','','$updated_at') ";
                    $this->conn->query($insertbillq);
                    echo $insertbillq;
                } else {
                    echo "Error";
                }
            }
        }
    }
}