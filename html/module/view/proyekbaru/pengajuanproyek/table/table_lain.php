<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <td>
        <div class="btn-group" style="margin-bottom:5px;">
            <button type="button" class="btn btn-primary btn-rounded mb5 dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <?php
                if ($row["STATUS"] == 0) {
                    ?>
                    <li><a href="proses_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:green;"><i class="fa fa-share fa-lg"></i> Proses</a></li>
                    <li><a href="tambah_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Edit</a></li>
                    <li class="divider"></li>
                    <li><a href="hapus_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" onclick="return confirm('Hapus request ini ?')"" style="color:red;"><i class="fa fa-trash fa-lg"></i> Hapus</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="tambah_pengajuanproyek?KODE_PROYEK=<?php echo $row["KODE_PROYEK"]; ?>" style="color:black;"><i class="fa fa-edit fa-lg"></i> Lihat</a></li>
                    <?php
                }
                
                ?>
            </ul>
        </div>
    </td>
    <?php
    if ($row["STATUS_HAPUS"] == 1) {
        ?>
        <td align="center" style="color: red;">Deleted</td>
        <?php
    }
    elseif ($row["STATUS"] == 0) {
        ?>
        <td align="center" style="color: black;">In Progress</td>
        <?php
    }
    elseif ($row["STATUS"] == 1) {
        ?>
        <td align="center" style="color: green;">Complete</td>
        <?php
    }
    ?>
    <td align="center"><?php echo $row["KODE_PROYEK"]; ?></td>
    <td align="center"><?php echo $row["NAMA_PERUSAHAAN"]; ?></td>
    <td align="center"><?php echo $row["LOKASI"]; ?></td>
    <td align="center"><?php echo $row["NAMA_BARANG"]; ?></td>
    <td><?php echo $row["KETERANGAN"]; ?></td>
    <td align="center"><?php echo $row["TGL_MULAI"]; ?></td>
    <td align="center"><?php echo $row["TGL_SELESAI"]; ?></td>
    <td align="center"><?php echo $row["PETUGAS"]; ?></td>
    <td><?php echo $row["HAMBATAN"]; ?></td>
    <td><?php echo $row["KETERANGAN_SELESAI"]; ?></td>
    <?php
    if (row["$STATUS_VER"] == 0) {
        ?>
        <td align="center"><i class="fa fa-clock-o fa-lg fa-2x"></i></a></td>
        <?php
    } elseif (row["$STATUS_VER"] == 1) {
        ?>
        <td align="center"><i class="fa fa-check fa-lg success fa-2x" style="color: green;"></i></a></td>
        <?php
    } else {
        ?>
        <td align="center"><i class="fa fa-times fa-lg danger fa-2x" style="color:red;"></i></td>
        <?php
    }
}
?>