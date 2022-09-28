<?php
/**
 * This example shows sending a message using a local sendmail binary.
 */
//Import the PHPMailer class into the global namespace
// use phpmailer;
require_once("module/model/koneksi/koneksi.php");
require 'phpmailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance

$query6 = 
   "select t.*,
    b.NAMA_BAGIAN,
    b.KODE_BAGIAN,
    b.GROUP_MANAGEMENT,
    d.NAMA_DEPARTEMEN,
    j.NAMA_JABATAN 
   from t_ptk t, 
    m_bagian b, 
    m_departemen d, 
    m_jabatan j 
   where t.KODE_BAGIAN = b.KODE_BAGIAN and 
    t.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
    t.KODE_JABATAN = j.KODE_JABATAN and 
    t.KODE_PTK = 'PTK-201801-0050'";

$result6 = mysql_query($query6, $DB1);
while ($row6 = mysql_fetch_array($result6)) {
    $KODE_PTK         = $row6["KODE_PTK"];
    $NAMA_BAGIAN      = $row6["NAMA_BAGIAN"];
    $NAMA_DEPARTEMEN  = $row6["NAMA_DEPARTEMEN"];
    $NAMA_JABATAN     = $row6["NAMA_JABATAN"];
    $JUMLAH           = $row6["JUMLAH"];
    $STATUS_KERJA     = $row6["STATUS_KERJA"];
    $TGL_BUTUH        = $row6["TGL_BUTUH"];
    $ALASAN           = $row6["ALASAN"];
    $KETERANGAN       = $row6["KETERANGAN"];
    $TUGAS_POKOK      = $row6["TUGAS_POKOK"];
    $GROUP_MANAGEMENT = $row6["GROUP_MANAGEMENT"];
}

$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('no-reply@megamarinepride.com','no-reply');
//Set an alternative reply-to address
// $mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('quality@megamarinepride.com');
$mail->addCC('recruitment@megamarine.com','recruitment');
$mail->addCC('adityahusni90@gmail.com','husniaditya');
// $mail->addCC('sinyoolala93@gmail.com');
//Set the subject line
$mail->Subject = "Permintaan Tenaga Kerja Karyawan " . $KODE_PTK;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("<br><br>======================================================================================<br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Jabatan : " . $NAMA_JABATAN . " <br>Jumlah : " . $JUMLAH . " <br>Status Kerja : " . $STATUS_KERJA . " <br>Tanggal : " . $TGL_BUTUH . " <br>Alasan : " . $ALASAN . " <br>Kriteria : " . $KETERANGAN . " <br>Tugas Pokok : " . $TUGAS_POKOK . " <br><br>Status Persetujuan :<br>Manager : Pending<br>Manager HRD : Pending<br>Direktur : Pending<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/rekrutmen'>recruitment.megamarinepride</a><br><br><br>Regards,<br>Recruitment Team");
//Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('pdf/Laporan PTK-201801-0050.pdf');
$mail->send();
die(0);
?>