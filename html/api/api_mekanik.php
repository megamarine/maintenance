<?php 
require_once "../module/model/koneksi/koneksi.php";

// user mekanik table
if (isset($_POST['reload_user'])){

    $KODE_PERBAIKAN = $_POST['kode_perbaikan'];
    $result2 = GetQuery("select p.*,
                        t.NAMA_TEKNISI
                    from d_perbaikan p,
                        m_teknisi t
                    where p.KODE_TEKNISI = t.KODE_TEKNISI and
                        p.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and
                        p.STS_HAPUS = 0");

    $data = array();
    while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
        array_push($data,
         array(
            "action" => $row['KODE_TEKNISI'],
            "teknisi" => $row['NAMA_TEKNISI'],
            )
        );
    }

    $json_data = array(
        "draw" => isset($_POST['draw'])?intval($_POST['draw']):0,
        "recordsTotal" => 10,
        "recordsFiltered" => 10,
        "data" => $data
    );

    echo json_encode($json_data);

} else if (isset($_POST['reload_sparepart'])){
    $KODE_PERBAIKAN = $_POST['kode_perbaikan'];
    $result3 = GetQuery("select m.*,
                s.NAMA_PART
            from d_maintenance m,
                m_sparepart s
            where m.KODE_PART = s.KODE_PART and
                m.KODE_PERBAIKAN = '$KODE_PERBAIKAN' and
                m.STS_HAPUS = 0");
    $data = array();
    while ($row = $result3->fetch(PDO::FETCH_ASSOC)) {
        array_push($data,
            array(
            "action" => $row['KODE_PART'],
            "name" => $row['NAMA_PART'],
            "jumlah" => $row['JUMLAH_PART'],
            )
        );
    }
    $json_data = array(
        "draw" => isset($_POST['draw'])?intval($_POST['draw']):0,
        "recordsTotal" => 10,
        "recordsFiltered" => 10,
        "data" => $data
    );
    echo json_encode($json_data);
            
} else if (isset($_POST['save_user'])){
        
        $KODE_PERBAIKAN = $_POST['kode_perbaikan'];
        $KODE_TEKNISI = $_POST["kode_teknisi"];
        if ($KODE_TEKNISI != "") {

            $sth = GetQuery("select count(*) jml from d_perbaikan 
                where KODE_PERBAIKAN='$KODE_PERBAIKAN' and KODE_TEKNISI='$KODE_TEKNISI' ");
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            if (!isset($row['jml'])){
                GetQuery(
                    "insert into d_perbaikan (KODE_PERBAIKAN,KODE_TEKNISI) 
                    values ('$KODE_PERBAIKAN','$KODE_TEKNISI')");
                $data = array('status' => 'success');
            } 
            echo json_encode($data);
        }
} elseif(isset($_POST["deleteUsr"])){

    $DINO           = date('Y-m-d H:i:s');
    $ID_USER1       = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME        = $_SESSION["PC_NAME_MT"];
    $KODE_PERBAIKAN = $_POST["kode_perbaikan"];
    $KODE_TEKNISI = $_POST["kode_teknisi"];

    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Detail Teknisi','Hapus Detail Teknisi','User Menghapus Detail Teknisi dengan Kode $KODE_TEKNISI')");
    $stmt1->execute();

    $stmt2 = $db1->prepare(
        "update d_perbaikan 
        set STS_HAPUS = 1 
        where KODE_PERBAIKAN = '$KODE_PERBAIKAN' and 
        KODE_TEKNISI = '$KODE_TEKNISI'");
    $stmt2->execute();
    $data = array('status' => 'success');
    echo json_encode($data);
} 
    else if(isset($_POST['save_sparepart'])){

    $KODE_PART   = $_POST["KODE_PART"];
    $JUMLAH_PART = $_POST["JUMLAH_PART"];
    $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];

    if ($KODE_PART != "") 
    {
        $stmt = GetQuery(
            "Select HARGA_PART from m_sparepart where KODE_PART = '$KODE_PART'");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            $HARGA_PART = $row["HARGA_PART"];
        }

        GetQuery(
            "insert into d_maintenance (KODE_PERBAIKAN,KODE_PART,JUMLAH_PART,HARGA_PART) 
            values ('$KODE_PERBAIKAN','$KODE_PART','$JUMLAH_PART','$HARGA_PART')");

        $data = array('status' => 'success');
        echo json_encode($data);
    }
} elseif(isset($_POST['delSparepart'])){
    $DINO           = date('Y-m-d H:i:s');
    $ID_USER1       = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS     = $_SESSION["IP_ADDRESS_MT"];
    $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];
    $KODE_PART      = $_POST["KODE_PART"];
    $PC_NAME        = $_SESSION["PC_NAME_MT"];

    $stmt1 = $db1->prepare(
        "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
        values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Detail Spare Part','Hapus Detail Spare Part','User Menghapus Detail Spare Part dengan Kode $KODE_PART')");
    $stmt1->execute();

    $stmt2 = $db1->prepare(
        "update d_maintenance 
        set STS_HAPUS = 1 
        where KODE_PERBAIKAN = '$KODE_PERBAIKAN' and KODE_PART = '$KODE_PART'");
    $stmt2->execute();
    $data = array('status' => 'success');
    echo json_encode($data);

} elseif (isset($_POST['reload_repairing'])){

    $KODE_PERBAIKAN = $_POST['kode_perbaikan'];
    $result4 = GetQuery("select *,
                            DATE_FORMAT(TGL_MULAI, '%d %M %Y') as TGL_PERBAIKAN,
                            DATE_FORMAT(TGL_MULAI, '%H:%i:%s') as JAM_PERBAIKAN
                       from d_progress d
                       left outer join m_teknisi t on t.KODE_TEKNISI = d.KODE_TEKNISI
                      where KODE_PERBAIKAN = '$KODE_PERBAIKAN'
                   order by TGL_MULAI");

    $data = array();
    while ($row = $result4->fetch(PDO::FETCH_ASSOC)) {
        array_push($data,
            array(
                "action" => $row['KODE_DETAIL'],
                "teknisi" => $row['NAMA_TEKNISI'],
                "date_from" => $row['TGL_MULAI'],
                "date_to" => $row['TGL_SELESAI'],
                "durasi" => $row['DURASI'],
                "hasil" => $row['HASIL_PERBAIKAN']
            )
        );
    }

    $json_data = array(
        "draw" => isset($_POST['draw'])?intval($_POST['draw']):0,
        "recordsTotal" => 10,
        "recordsFiltered" => 10,
        "data" => $data
    );

    echo json_encode($json_data);

    
} elseif(isset($_POST['tambahPerbaikan'])){
    $u   = date("Ym");
    $ID_USER1           = $_SESSION["LOGINIDUS_MT"];
    $IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
    $PC_NAME            = $_SESSION["PC_NAME_MT"];
    $KODE_DETAIL = createKode("d_progress","KODE_DETAIL","DET-$u-",4);
    $SOLUSI      = $_POST["SOLUSI"];
    $SARAN       = $_POST["SARAN"];
    $DURASI      = $_POST["DURASI"];
    $BAGIAN      = $_POST["BAGIAN"];
    $TGL_END     = $_POST["TGL_END"];
    $TGL_START   = $_POST["TGL_START"];
    $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];
    $KODE_TEKNISI = $_POST["KODE_TEKNISI"];
    $DINO        = date('Y-m-d H:i:s');

     // Kode Teknisi
     if (isset($KODE_TEKNISI)) {
        $sth = GetQuery("select count(*) jml from d_perbaikan 
            where KODE_PERBAIKAN='$KODE_PERBAIKAN' and KODE_TEKNISI='$KODE_TEKNISI' and STS_HAPUS <> 1 ");
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$row['jml']){
            GetQuery(
                "insert into d_perbaikan (KODE_PERBAIKAN,KODE_TEKNISI) 
                values ('$KODE_PERBAIKAN','$KODE_TEKNISI')");
            $data = array('status' => 'success');
        }
            GetQuery(
                "update t_perbaikan set STATUS_PERBAIKAN = 'Belum', PROGRESS = 0 where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            
            GetQuery(
                "insert into d_progress (KODE_DETAIL,KODE_PERBAIKAN,DURASI,HASIL_PERBAIKAN,TGL_MULAI,TGL_SELESAI,KODE_TEKNISI) 
                values ('$KODE_DETAIL','$KODE_PERBAIKAN','$DURASI','$SOLUSI','$TGL_START','$TGL_END','$KODE_TEKNISI')");
            
            
            InsertData(
                    "t_userlog",
                    "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
                    "'$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Progress Berjalan','Kode $KODE_PERBAIKAN'");
        
            $data = array('status' => 'success');
            echo json_encode($data); 
        }

} elseif (isset($_POST['delRepair'])){
    $KODE_DETAIL = $_POST['KODE_DETAIL'];
    GetQuery("delete from d_progress where KODE_DETAIL = '$KODE_DETAIL'");
    $data = array('status' => 'success');
    echo json_encode($data);

} elseif (isset($_POST["simpan2"])) 
    {
        try 
        {
            $SOLUSI = $_POST["SOLUSI"];
            $SARAN  = $_POST["SARAN"];
            $BAGIAN = isset($_POST["BAGIAN"]) ? $_POST["BAGIAN"] : "";
            $DURASI = $_POST["DURASI"];
            $KODE_PERBAIKAN = $_POST["kode_perbaikan"];
            $TGL_PERBAIKAN    = $_POST["TGL_PERBAIKAN"] . " " . $_POST["JAM_PERBAIKAN"];
            $TGL_SELESAI      = $_POST["TGL_SELESAI"] . " " . $_POST["JAM_SELESAI"];
            $STATUS_PERBAIKAN = $_POST["STATUS_PERBAIKAN"];
            $DATE               = date("Y-m-d H:i:s");
            $ID_USER1           = $_SESSION["LOGINIDUS_MT"];
            $IP_ADDRESS         = $_SESSION["IP_ADDRESS_MT"];
            $PC_NAME            = $_SESSION["PC_NAME_MT"];
            $KODE_TEKNISI = $_POST["KODE_TEKNISI"];

            // Kode Teknisi
            if (isset($KODE_TEKNISI)) {
                $sth = GetQuery("select count(*) jml from d_perbaikan 
                where KODE_PERBAIKAN='$KODE_PERBAIKAN' and KODE_TEKNISI='$KODE_TEKNISI' ");
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$row['jml']){
                GetQuery(
                    "insert into d_perbaikan (KODE_PERBAIKAN,KODE_TEKNISI) 
                    values ('$KODE_PERBAIKAN','$KODE_TEKNISI')");
                $data = array('status' => 'success');
                } 
            }

                
            
            $resultHitung = GetQuery(
                "select sum(DURASI) as DURASI2, 
                        COUNT(DURASI) AS COUNTS 
                    from d_progress 
                    where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            
            while ($rowHitung = $resultHitung->fetch(PDO::FETCH_ASSOC)) 
                {
                    extract($rowHitung);
                }
            if ($COUNTS == 0) 
            {
                UpdateData(
                    "t_perbaikan",
                    "SOLUSI = '$SOLUSI', TGL_END = '$DATE',
                        TGL_PERBAIKAN = '$TGL_PERBAIKAN',
                        TGL_SELESAI = '$TGL_SELESAI',
                        USER_MT = '$ID_USER1',
                        STATUS = 1,
                        SARAN = '$SARAN',
                        DURASI = '$DURASI',
                        BAGIAN = '$BAGIAN',
                        PROGRESS = 100,
                        STATUS_PERBAIKAN = '$STATUS_PERBAIKAN'
                        ",
                        
                    "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            } 
            else 
            {
                UpdateData(
                    "t_perbaikan",
                    "SOLUSI = '$SOLUSI', 
                    TGL_END = '$DATE', 
                    TGL_PERBAIKAN = '$TGL_PERBAIKAN', 
                    TGL_SELESAI = '$TGL_SELESAI', 
                    USER_MT = '$ID_USER1', 
                    STATUS = 1,
                    SARAN = '$SARAN', 
                    DURASI = '$DURASI2',
                    BAGIAN = '$BAGIAN',
                    PROGRESS = 100,
                    STATUS_PERBAIKAN = '$STATUS_PERBAIKAN'
                    ",
                    "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            }

            InsertData(
            "t_userlog",
            "KODE_USER,IP_ADDRESS,PC_NAME,
            TANGGAL,MODUL,JENIS_LOG,AKTIVITAS",
            "'$ID_USER1','$IP_ADDRESS','$PC_NAME',
            '$DATE','Maintenance','Selesai Maintenance',
            'Kode $KODE_PERBAIKAN'");
            

            GetQuery(
            "update t_perbaikan 
                set LAMA_KERJA = (select time_format(TIMEDIFF(TGL_SELESAI,TGL_PERBAIKAN),'%H.%i')), 
                DOWNTIME = (select time_format(TIMEDIFF(TGL_SELESAI,TGL_START),'%H.%i')) 
            where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
                
        } catch(Exception $e){
            echo 'Message: ' .$e->getMessage();
        }
    } elseif(isset($_POST['reject'])){

        $DINO        = date('Y-m-d H:i:s');
        $ID_USER1    = $_SESSION["LOGINIDUS_MT"];
        $IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
        $PC_NAME     = $_SESSION["PC_NAME_MT"];
        $KETERANGAN2    = $_POST["KETERANGAN2"];
        $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];
        $ESTIMASI = $_POST['ESTIMASI'];

        GetQuery(
            "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
            values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tolak Maintenance','User Pending Maintenance dengan Kode $KODE_PERBAIKAN')");

        
        UpdateData(
            "t_perbaikan", 
            "KETERANGAN2 = '$KETERANGAN2', STATUS_READ = 3, ESTIMASI = '$ESTIMASI'",
            "KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
            $data = array('status' => 'success');
            echo json_encode($data);
    } 
    elseif(isset($_POST['tolak'])){
        $DINO        = date('Y-m-d H:i:s');

        $ID_USER1    = $_SESSION["LOGINIDUS_MT"];
        $IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
        $PC_NAME     = $_SESSION["PC_NAME_MT"];
        $KETERANGAN     = $_POST["KETERANGAN"];
        $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];
    
        GetQuery(
            "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
            values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tolak Maintenance','User Menolak Maintenance dengan Kode $KODE_PERBAIKAN')");
    
        GetQuery(
            "update t_perbaikan 
            set STATUS_HAPUS = 1, SOLUSI = 'Alasan Penolakan : $KETERANGAN', PROGRESS = 100 where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
    
        $data = array('status' => 'success');
        echo json_encode($data);

    } else if (isset($_POST['close'])){
        $DINO        = date('Y-m-d H:i:s');
        $ID_USER1    = $_SESSION["LOGINIDUS_MT"];
        $IP_ADDRESS  = $_SESSION["IP_ADDRESS_MT"];
        $PC_NAME     = $_SESSION["PC_NAME_MT"];
        $SHIFT_ID     = $_POST["shiftId"];
        $KODE_PERBAIKAN = $_POST["KODE_PERBAIKAN"];
        
        GetQuery(
            "insert into t_userlog (KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS) 
            values ('$ID_USER1','$IP_ADDRESS','$PC_NAME','$DINO','Maintenance','Tutup Maintenance','User Menutup Maintenance dengan Kode $KODE_PERBAIKAN')");
    
        GetQuery(
            "update t_perbaikan 
                set SHIFT = '$SHIFT_ID', STATUS = '1' 
                where KODE_PERBAIKAN = '$KODE_PERBAIKAN'");
    
        $data = array('status' => 'success');
        echo json_encode($data);

    } elseif(isset($_POST['send_mail'])){

        $kode = $_POST['KODE_PERBAIKAN'];
        $state = $_POST['STATE'];
        $obj = GetQuery("
        select 
            mb.NAMA_BAGIAN bagian,
            mp.NAMA_PERUSAHAAN perusahaan,
            mb2.NAMA_BARANG barang,
            tp.KERUSAKAN rusak,
            md.NAMA_DEPARTEMEN departemen,
            group_concat(mu.EMAIL separator ';') email
        from t_perbaikan tp 
        inner join m_perusahaan mp  on mp.KODE_PERUSAHAAN  = tp.KODE_PERUSAHAAN 
        inner join m_departemen md on md.KODE_DEPARTEMEN = tp.KODE_DEPARTEMEN
        inner join m_barang mb2 on mb2.KODE_BARANG = tp.KODE_BARANG
        left outer join m_bagian mb on mb.KODE_BAGIAN = md.KODE_BAGIAN
        left outer join m_user mu on (mu.KODE_BAGIAN = tp.BAGIAN or tp.KODE_DEPARTEMEN = mu.KODE_DEPARTEMEN or tp.USER_REQ = mu.KODE_USER) 
            where tp.KODE_PERBAIKAN = '$kode' and mu.EMAIL is not null 
        limit 1
        ");

       $row = $obj -> fetch();
       $email = $row['email'];
        
       require '../phpmailer/PHPMailerAutoload.php';
       set_time_limit(120); // set the time limit to 120 seconds
       try {
            $mail = new PHPMailer;
            $mail->isSendmail();
            $mail->setFrom('no-reply@megamarinepride.com','no-reply maintenance');
            $emailArray = explode(";", $email);
            foreach ($emailArray as $email_user)  {
                if ($email_user == ""){
                    $mail->addAddress($email_user);
                }
                
            }
            $mail->addCC('mechanic@megamarinepride.com');
            $mail->Subject = "Permintaan Pemeliharaan Barang " . $kode;
            $mail->msgHTML("<br><br>======================================================================================<br>Perusahaan : " . $row['perusahaan'] . " <br>Divisi : " . $row['bagian'] . " <br>Departemen : " . $row['departemen'] ." <br>Barang : " . $row['barang']. " <br>Kerusakan : " . $row['rusak'] . " <br><br><br>Status : ". $state . " <br><br>======================================================================================<br>please do not reply to this email <br>for more information, kindly visit <a href='192.168.0.167/maintenance'>maintenance.megamarinepride</a><br><br><br>Regards,<br>Mega Marine Pride");
            $mail->Send();
            echo "ok";
        } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
      } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
      }
    }
?>