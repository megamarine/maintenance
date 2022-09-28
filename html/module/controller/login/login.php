<?php
$DINO = date('Y-m-d H:i:s');
if(isset($_POST["login"]))
    {
        $KODE_USER = $_POST["username"];
        $PASSWORD  = $_POST['password'];
        $result    = GetData1("*","m_user","KODE_USER = '$KODE_USER'");
        if($row = $result->fetch(PDO::FETCH_ASSOC))   //fetch -> ambil 1 baris query, jika ga ada : FALSE
        {
            $PASS       = $row['PASSWORD'];
            $STATUS     = $row["STATUS"];
            $STS_LGN    = $row["STS_LGN"];
            $IP_ADDRESS = getIp();
            $PC_NAME    = gethostbyaddr($IP_ADDRESS);

            if ($STATUS == "Aktif" and password_verify($PASSWORD, $PASS)) 
            { 
                $result2 = GetData1(
                   "u.*,
                    p.NAMA_PERUSAHAAN,
                    b.NAMA_BAGIAN,
                    d.NAMA_DEPARTEMEN",
                   "m_user u, 
                    m_perusahaan p, 
                    m_bagian b, 
                    m_departemen d",
                   "u.KODE_PERUSAHAAN = p.KODE_PERUSAHAAN and 
                    u.KODE_BAGIAN = b.KODE_BAGIAN and 
                    u.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN and 
                    u.KODE_USER = '$KODE_USER'");

                while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) 
                {
                    $NAMA_PERUSAHAAN = $row2["NAMA_PERUSAHAAN"];
                    $NAMA_BAGIAN     = $row2["NAMA_BAGIAN"];
                    $NAMA_DEPARTEMEN = $row2["NAMA_DEPARTEMEN"];
                }

                $_SESSION["PC_NAME_MT"]     = $PC_NAME;
                $_SESSION["IP_ADDRESS_MT"]  = getIp();
                $_SESSION["LOGINIDUS_MT"]   = $row["KODE_USER"];
                $_SESSION["LOGINNAMAUS_MT"] = $row["NAMA_USER"];
                $_SESSION["LOGINDEP_MT"]    = $row["KODE_DEPARTEMEN"];
                $_SESSION["LOGINAKS_MT"]    = $row["AKSES"];
                $_SESSION["LOGINBAG_MT"]    = $row["KODE_BAGIAN"];
                $_SESSION["LOGINPER_MT"]    = $row["KODE_PERUSAHAAN"];
                $_SESSION["LOGINGRP_MT"]    = $row["GROUP_MANAGEMENT"];
                $_SESSION["LOGINMAIL_MT"]   = $row["EMAIL"];
                $_SESSION["LOGINNMBAG_MT"]  = $NAMA_BAGIAN;

                InsertData(
                    "t_userlog",
                    "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS","'" . $row["KODE_USER"] . "','$IP_ADDRESS','$PC_NAME','$DINO','Login','Masuk','Akses " . $row["AKSES"] . "'");

                UpdateData(
                    "m_user",
                    "STS_LGN = '1'",
                    "KODE_USER = '" . $row["KODE_USER"] . "'");

                ?><script>document.location.href='menuutama';</script><?php
                die(0);

            }
            else 
            { 
                InsertData(
                    "t_userlog",
                    "KODE_USER,IP_ADDRESS,PC_NAME,TANGGAL,MODUL,JENIS_LOG,AKTIVITAS","'" . $row["KODE_USER"] . "','$IP_ADDRESS','$PC_NAME','$DINO','Login','Masuk','Gagal - Akses " . $row["AKSES"] . "'");

                ?><script>alert('Nomor Pegawai atau password salah');</script><?php
                ?><script>document.location.href='index';</script><?php
                die(0);

            } 
        }
    }
    ?>