<?php 
if (isset($_POST["cari"])) 
{
    $PERIODE    = $_POST["PERIODE"];
    $PERIODE2   = $_POST["PERIODE2"];
    $SPAREPART  = $_POST["SPAREPART"];

    if (isset($SPAREPART)) 
    {
        $result = GetQuery(
           "select p.KODE_PERBAIKAN,
            a.NAMA_PERUSAHAAN,
            d.NAMA_DEPARTEMEN,
            DATE_FORMAT(p.TGL_START, '%d %M %Y') as TGL_START,
            DATE_FORMAT(p.TGL_START, '%H:%i:%s') as JAM_START,
            b.NAMA_BARANG,
            p.LAYANAN,
            p.KERUSAKAN,
            p.KETERANGAN,
            p.SOLUSI 
           FROM t_perbaikan p, 
            d_maintenance m, 
            m_perusahaan a, 
            m_departemen d, 
            m_barang b, 
            m_sparepart s 
           WHERE p.KODE_PERBAIKAN = m.KODE_PERBAIKAN AND 
            p.KODE_PERUSAHAAN = a.KODE_PERUSAHAAN AND 
            p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN AND 
            p.KODE_BARANG = b.KODE_BARANG AND 
            m.KODE_PART = s.KODE_PART AND 
            p.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2' AND 
            p.STATUS_HAPUS = 0 and 
            m.KODE_PART = '$SPAREPART' 
           GROUP BY p.KODE_PERBAIKAN 
           ORDER BY p.TGL_START desc");
    }
    else
    {
        $result = GetQuery(
           "select p.KODE_PERBAIKAN,
            a.NAMA_PERUSAHAAN,
            d.NAMA_DEPARTEMEN,
            DATE_FORMAT(p.TGL_START, '%d %M %Y') as TGL_START,
            DATE_FORMAT(p.TGL_START, '%H:%i:%s') as JAM_START,
            b.NAMA_BARANG,
            p.LAYANAN,
            p.KERUSAKAN,
            p.KETERANGAN,
            p.SOLUSI 
           FROM t_perbaikan p, 
            d_maintenance m, 
            m_perusahaan a, 
            m_departemen d, 
            m_barang b, 
            m_sparepart s 
           WHERE p.KODE_PERBAIKAN = m.KODE_PERBAIKAN AND 
            p.KODE_PERUSAHAAN = a.KODE_PERUSAHAAN AND 
            p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN AND 
            p.KODE_BARANG = b.KODE_BARANG AND 
            m.KODE_PART = s.KODE_PART AND 
            p.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2' AND 
            p.STATUS_HAPUS = 0 
           GROUP BY p.KODE_PERBAIKAN 
           ORDER BY p.TGL_START desc");
    }
}
else
{
    $result = GetQuery(
       "select p.KODE_PERBAIKAN,
        a.NAMA_PERUSAHAAN,
        d.NAMA_DEPARTEMEN,
        DATE_FORMAT(p.TGL_START, '%d %M %Y') as TGL_START,
        DATE_FORMAT(p.TGL_START, '%H:%i:%s') as JAM_START,
        b.NAMA_BARANG,
        p.LAYANAN,
        p.KERUSAKAN,
        p.KETERANGAN,
        p.SOLUSI 
       FROM t_perbaikan p, 
        d_maintenance m, 
        m_perusahaan a, 
        m_departemen d, 
        m_barang b, 
        m_sparepart s 
       WHERE p.KODE_PERBAIKAN = m.KODE_PERBAIKAN AND 
        p.KODE_PERUSAHAAN = a.KODE_PERUSAHAAN AND 
        p.KODE_DEPARTEMEN = d.KODE_DEPARTEMEN AND 
        p.KODE_BARANG = b.KODE_BARANG AND 
        m.KODE_PART = s.KODE_PART AND 
        p.TGL_START BETWEEN '$PERIODE' AND '$PERIODE2' AND 
        p.STATUS_HAPUS = 0 
       GROUP BY p.KODE_PERBAIKAN 
       ORDER BY p.TGL_START desc");
}
?>