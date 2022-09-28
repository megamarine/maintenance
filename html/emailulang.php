<?php
// START EMAIL
/**
 * This example shows sending a message using a local sendmail binary.
 */
//Import the PHPMailer class into the global namespace
// use phpmailer;
require_once("module/model/koneksi/koneksi.php");
require 'phpmailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance

$KODE_PERBAIKAN = "MT-201803-0055"; // Ubah Kode Perbaikan

$result = GetData1(
   "p.*,
    h.NAMA_PERUSAHAAN,
    d.NAMA_DEPARTEMEN,
    b.NAMA_BARANG,
    j.NAMA_JENIS,
    d.KODE_BAGIAN,
    g.NAMA_BAGIAN,
    DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
    DATE_FORMAT(TGL_END, '%d %M %Y') as TGL_END,
    DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
    DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END",
   "t_perbaikan p, 
    m_barang b, 
    m_perusahaan h, 
    m_departemen d, 
    m_jenisbrg j, 
    m_bagian g",
   "p.KODE_BARANG = b.KODE_BARANG and 
    p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN and 
    p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
    d.KODE_BAGIAN = g.KODE_BAGIAN and 
    b.KODE_JENIS = j.KODE_JENIS and 
    KODE_PERBAIKAN = '$KODE_PERBAIKAN'");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
    $KODE_PERUSAHAAN = $row["KODE_PERUSAHAAN"];
    $NAMA_PERUSAHAAN = $row["NAMA_PERUSAHAAN"];
    $KODE_BAGIAN     = $row["KODE_BAGIAN"];
    $NAMA_BAGIAN     = $row["NAMA_BAGIAN"];
    $KODE_DEPARTEMEN = $row["KODE_DEPARTEMEN"];
    $NAMA_DEPARTEMEN = $row["NAMA_DEPARTEMEN"];
    $KODE_BARANG     = $row["KODE_BARANG"];
    $NAMA_BARANG     = $row["NAMA_BARANG"];
    $KERUSAKAN       = $row["KERUSAKAN"];
    $KETERANGAN      = $row["KETERANGAN"];
    $SOLUSI          = $row["SOLUSI"];
    $TGL_START       = $row["TGL_START"];
    $JAM_START       = $row["JAM_START"];
    $IP_ADD          = $row["IP_ADD"];
    $PEMILIK         = $row["PEMILIK"];
}

$resultjns = GetData1("KODE_JENIS","m_barang","KODE_BARANG = '$KODE_BARANG'");
while ($rowJns = $resultjns->fetch(PDO::FETCH_ASSOC)) {
    $KODE_JENIS = $rowJns["KODE_JENIS"];
}
if ($KODE_JENIS == 1) {
    $EMAIL = "it@megamarinepride.com";
}
elseif ($KODE_JENIS == 2) {
    $EMAIL = "mechanic@megamarinepride.com";
}
else{
    $EMAIL = "ga@megamarinepride.com";   
}

if ($KODE_BAGIAN == "DIV-0030") {
    $EMAILMAN = "quality@megamarinepride.com";
}
else{
    $resultem2 = GetData1("EMAIL","m_user","KODE_BAGIAN = '$KODE_BAGIAN' and AKSES = 'Manajer'");
    while ($rowem2 = $resultem2->fetch(PDO::FETCH_ASSOC)) {
        $EMAILMAN = $rowem2["EMAIL"];
    }
}

$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('no-reply@megamarinepride.com','no-reply');
//Set an alternative reply-to address
// $mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($EMAIL);
// $mail->addCC('recruitment@megamarinepride.com','recruitment');
$mail->addCC($EMAILMAN);
$mail->addCC('no-reply@megamarinepride.com','no-reply');
//Set the subject line
$mail->Subject = "Permintaan Pemeliharaan Barang " . $KODE_PERBAIKAN;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("<br><br>======================================================================================<br>Perusahaan : " . $NAMA_PERUSAHAAN . " <br>Divisi : " . $NAMA_BAGIAN . " <br>Departemen : " . $NAMA_DEPARTEMEN . " <br>Tanggal Pengajuan: " . $TGL_START . " " . $JAM_START . " <br>Barang : " . $NAMA_BARANG . " <br>IP Address : " . $IP_ADD . " <br>Pemilik : " . $PEMILIK . " <br>Kerusakan : " . $KERUSAKAN . " <br>Keterangan : " . $KETERANGAN . "<br><br>Status : In Progress<br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/maintenance'>maintenance.megamarinepride</a><br><br><br>Regards,<br>Mega Marine Pride");
//Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->send();
// END EMAIL
?>