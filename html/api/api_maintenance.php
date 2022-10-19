<?php
require_once ("../module/model/koneksi/koneksi.php");
$KODE_DEPARTEMEN = $_SESSION["LOGINDEP_MT"];
$length = $_REQUEST['length'] ? intval($_REQUEST['length']): 10;
$page = $_REQUEST['start'] ? intval($_REQUEST['start']): 0;
$awal = $_REQUEST['awal'];
$akhir = $_REQUEST['akhir'];
$state = $_REQUEST['state'];
if (!empty($_REQUEST['search']['value']) or ($awal != '' && $akhir != '' ) or ($state != 'all') ){
    
    $search = $_REQUEST['search']['value'];
    $cols = array(
        " p.KODE_PERBAIKAN like ",
        " or h.NAMA_PERUSAHAAN like ",
        " or d.NAMA_DEPARTEMEN like ",
        " or b.NAMA_BARANG like ",
        " or j.NAMA_JENIS like ",
        " or d.KODE_BAGIAN like ",
        " )",
    );
    $search = " and (".join("'%$search%'",$cols);
    if (($awal != '' && $akhir != '' )){
        $search = $search." and date(p.TGL_START) between '$awal' and '$akhir'";
    }

    if ($state != 'all') {
        if ($state == 'new') {
            $search = $search." and (p.PROGRESS = 0 or p.PROGRESS is null) and p.STATUS_READ = 0";
        } elseif ($state == 'confirm') {
            $search = $search." and (p.PROGRESS = 0 or p.PROGRESS is null) and p.STATUS_READ = 2";
        } elseif ($state == 'progress') {
            $search = $search." and (p.PROGRESS = 0 or p.PROGRESS is null) and p.STATUS_READ = 1";
        } elseif ($state == 'pending') {
            $search = $search." and (p.PROGRESS = 0 or p.PROGRESS is null) and p.STATUS_READ = 3";
        }
    }

    $result = GetQuery(
        "Select p.*,
                DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
                DATE_FORMAT(TGL_END, '%d %M %Y') as TGL_END,
                DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
                DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END,
                p.TGL_START as TGL_STARTS,
                p.TGL_END as TGL_ENDS,
                p.PROGRESS,
                tns.NAMA_TEKNISI,
                h.NAMA_PERUSAHAAN,
                d.NAMA_DEPARTEMEN,
                p.KODE_DEPARTEMEN,
                b.NAMA_BARANG,
                i.NAMA_UNIT,
                j.NAMA_JENIS,
                d.KODE_BAGIAN,
                u.NAMA_USER
           FROM t_perbaikan p
           JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
           LEFT JOIN m_unit i ON p.KODE_UNIT = i.KODE_UNIT
           JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
           JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
           JOIN m_user u ON p.USER_REQ = u.KODE_USER
           JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
           left outer join (
            select dp.KODE_PERBAIKAN,group_concat(mt.NAMA_TEKNISI) as NAMA_TEKNISI
                from d_perbaikan dp  
            left join m_teknisi mt on mt.KODE_TEKNISI  = dp.KODE_TEKNISI
            where dp.STS_HAPUS = 0
            group by dp.KODE_PERBAIKAN
            ) tns on tns.KODE_PERBAIKAN = p.KODE_PERBAIKAN 
          WHERE p.HASIL IS NULL and 
                p.STATUS_HAPUS = 0 and b.KODE_JENIS = 2
                $search
       order by p.TGL_START desc, p.KODE_PERBAIKAN desc limit $length offset $page");

    //    $result2 = GetQuery(
    //     "Select 
    //         count(p.KODE_PERBAIKAN) jml
    //        FROM t_perbaikan p
    //        JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
    //        LEFT JOIN m_unit i ON p.KODE_UNIT = i.KODE_UNIT
    //        JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
    //        JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
    //        JOIN m_user u ON p.USER_REQ = u.KODE_USER
    //        JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
    //        left outer join (
    //         select dp.KODE_PERBAIKAN,group_concat(mt.NAMA_TEKNISI) as NAMA_TEKNISI
    //             from d_perbaikan dp  
    //         left join m_teknisi mt on mt.KODE_TEKNISI  = dp.KODE_TEKNISI
    //         where dp.STS_HAPUS = 0
    //         group by dp.KODE_PERBAIKAN
    //         ) tns on tns.KODE_PERBAIKAN = p.KODE_PERBAIKAN 
    //       WHERE p.HASIL IS NULL and 
    //             p.STATUS_HAPUS = 0 and 
    //             b.KODE_JENIS = 2
    //             $search
    //    order by p.KODE_PERBAIKAN desc, p.TGL_START desc limit 100");
    //    $row = $result2->fetch(PDO::FETCH_ASSOC);
    //    $jml = $row['jml'];
    $jml = 100;
} else {

    $result = 
    GetQuery("Select p.*,
        DATE_FORMAT(TGL_START, '%d %M %Y') as TGL_START,
        DATE_FORMAT(TGL_END, '%d %M %Y') as TGL_END,
        DATE_FORMAT(TGL_START, '%H:%i:%s') as JAM_START,
        DATE_FORMAT(TGL_END, '%H:%i:%s') as JAM_END,
        p.TGL_START as TGL_STARTS,
        p.TGL_END as TGL_ENDS,
        p.PROGRESS,
        tns.NAMA_TEKNISI,
        h.NAMA_PERUSAHAAN,
        d.NAMA_DEPARTEMEN,
        p.KODE_DEPARTEMEN,
        b.NAMA_BARANG,
        i.NAMA_UNIT,
        j.NAMA_JENIS,
        d.KODE_BAGIAN,
        u.NAMA_USER
    FROM t_perbaikan p
    JOIN m_barang b ON p.KODE_BARANG = b.KODE_BARANG
    LEFT JOIN m_unit i ON p.KODE_UNIT = i.KODE_UNIT
    JOIN m_perusahaan h ON p.KODE_PERUSAHAAN = h.KODE_PERUSAHAAN
    JOIN m_departemen d ON p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN
    JOIN m_user u ON p.USER_REQ = u.KODE_USER
    JOIN m_jenisbrg j ON b.KODE_JENIS = j.KODE_JENIS
    left outer join (
    select dp.KODE_PERBAIKAN,group_concat(mt.NAMA_TEKNISI) as NAMA_TEKNISI
        from d_perbaikan dp  
    left join m_teknisi mt on mt.KODE_TEKNISI  = dp.KODE_TEKNISI
    where dp.STS_HAPUS = 0
    group by dp.KODE_PERBAIKAN
    ) tns on tns.KODE_PERBAIKAN = p.KODE_PERBAIKAN 
    WHERE p.HASIL IS NULL and 
        p.STATUS_HAPUS = 0 and 
        b.KODE_JENIS = 2
    order by p.TGL_START desc,p.KODE_PERBAIKAN desc limit $length offset $page");

   $jml = 100;
}

   function getState($progress, $readed, $hasil, $row, $DEP){
        if ($progress == 0){
            if ($readed == 0){
                return '<span class="state state3">New</span>';
            } else if($readed == 2){
                return '<span class="state state1">Confirm</span>';
            } else if($readed == 3){
                return '<span class="state state2"><a data-toggle="modal" data-id='.$row["KODE_PERBAIKAN"].' data-ket2='.str_replace(" ","&nbsp;",$row['KETERANGAN2']).' data-est='.str_replace(" ","&nbsp;",$row['ESTIMASI']).' data-style="color:brown;" data-toggle="modal" title="Add this item" class="open-AddBookDialog2" href="#addBookDialog2"><i class="fa fa-hourglass-half fa-lg"></i> Pending</a></span>';
            }
             else {
                return '<span class="state state1">InProgress</span>';
            }
        }
        else if ($DEP == $row['KODE_DEPARTEMEN'] && !isset($hasil)) {
            return '<a href="tambah_hasil_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&HASIL=1"><img src="images/emptystar.png"></a><a href="tambah_hasil_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&HASIL=2"><img src="images/emptystar.png"></a><a href="tambah_hasil_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&HASIL=3"><img src="images/emptystar.png"></a><a href="tambah_hasil_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&HASIL=4"><img src="images/emptystar.png"></a><a href="tambah_hasil_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&HASIL=5"><img src="images/emptystar.png"></a>';
        }
         else if($hasil == 1){
            return '<img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">';
        } else if($hasil == 2){
            return '<img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">';
        } else if($hasil == 3){
            return '<img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">';
        } else if($hasil == 4){
            return '<img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/emptystar.png">';
        } else if($hasil == 5){
            return '<img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png"><img src="images/fullstar.png">';
        } else {
            return '<img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png"><img src="images/emptystar.png">';
        }
   }

   $data = array();
   while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $state = getState($row['PROGRESS'], $row['STATUS_READ'], $row['HASIL'],$row, $KODE_DEPARTEMEN);
        array_push($data,array(
            "action" => '<div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="proses_pengajuan_mekanik?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                <li><a href="tambah_pengajuanmt_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'&amp;edit=1" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                <li><a data-toggle="modal" data-id='.$row["KODE_PERBAIKAN"].' data-ket2='.str_replace(" ","&nbsp;",$row['KETERANGAN2']).' data-est='.str_replace(" ","&nbsp;",$row['ESTIMASI']).' data-style="color:brown;" data-toggle="modal" title="Add this item" class="open-AddBookDialog2" href="#addBookDialog2"><i class="fa fa-hourglass-half fa-lg"></i> Pending</a></li>
                <li class="divider"></li>
                <li><a data-toggle="modal" data-id="'.$row["KODE_PERBAIKAN"].'" data-toggle="modal" title="Add this item" class="open-AddBookDialog" href="#addBookDialog"><i class="fa fa-times fa-lg"></i> Tolak</a></li>
                <li><a href="hapus_pengajuanmt_new?KODE_PERBAIKAN='.$row["KODE_PERBAIKAN"].'" onclick="return confirm(Hapus request ini ?)" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                <li class="divider"></li>
                <li><a onclick="refresh();" href="print_spk?id='.$row["KODE_PERBAIKAN"].'&amp;printed=1&amp;state='.$row['STATUS_READ'].'" target="_blank" style="color:brown;"><i class="fa fa-print fa-lg"></i> Cetak SPK</a></li>
                </ul>
            </div>',
            "state" => $state,
            "teknisi" => $row['NAMA_TEKNISI'],
            "code" => $row["KODE_PERBAIKAN"],
            "company" => $row["NAMA_PERUSAHAAN"],
            "department" => $row["NAMA_DEPARTEMEN"],
            "start" => $row["TGL_START"],
            "end" => $row["TGL_SELESAI"],
            "end2" => $row["TGL_END"],
            "item" => $row["NAMA_BARANG"],
            "lokasi" => $row["LOKASI"],
            "jenis" => $row["NAMA_JENIS"],

        ));
   }


$json_data = array(
    "draw" => isset($_POST['draw'])?intval($_POST['draw']):0,
    "recordsTotal" => $jml,
    "recordsFiltered" => $jml,
    "data" => $data
);

echo json_encode($json_data);
?>