<?php
include 'includes/shared/header.php';
?>

<?php 
function getEmailTemplate($body, $to)
{
return '
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800|Roboto:100,200,300,400,500,700,800,900|Raleway:100"
        rel="stylesheet">
    <title>Society Management System</title>
</head>

<body yahoo style="font-family:" Roboto", Sans-Serif; margin: 0; padding: 0; min-width: 100% !important;
    -webkit-font-smoothing: antialiased; letter-spacing: 0.33px">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 32px 0;">
        <tr>
            <td>
                <table align="center" cellpadding="0" cellspacing="0" border="0"
                    style="width: 100%; max-width: 733px; background-color: #f1f1f1; border: 1px solid #dcdcdc;">
                    <tr height="32px"></tr>
                    <tr>
                        <td>
                            <table align="center"
                                style="width: 100%; max-width: 670px; border-top: 5px solid #b7202e; background-color: white; box-shadow: 0 6px 17px 0 rgba(0,0,0,0.04);">
                                <tr>
                                    <td style="padding: 22px;">
                                        <h4>To ' . $to . '</h4>
                                        <p>' . $body . '</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr height="32px"></tr>
                    <tr>
                        <td>
                            <table align="center"
                                style="width: 100%; max-width: 680px; border-top: 1.3px solid #dddddd; padding-bottom: 16px;">
                                <tr align="center">
                                    <td
                                        style="color: #adadad; font-size: 13px; text-decoration: none; font-weight: 500; line-height: 18px; padding-top: 12px;">
                                        Sent by <span style="color: #4e4e4e; font-weight: 600;">Society Management System</span>
                                    </td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>';

}

?>

<?php 
include './includes/shared/scripts.php';
?>