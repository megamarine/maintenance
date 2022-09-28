<?php
    require_once("module/model/koneksi/koneksi.php");
    
	if(!empty($_POST["STATUS_DOWNTIME"])) 
    {
		$STATUS_DOWNTIME = $_POST["STATUS_DOWNTIME"];
        if ($STATUS_DOWNTIME == "1" or $STATUS_DOWNTIME == "checked") 
        {
            ?>
            <div class="col-md-3">
                    <div class="form-group">
                        <label for="DOWNTIME_TIME">Waktu Downtime <span class="text-danger">*</span></label><br/>
                        <input type="datetime-local" class="form-control" required="" name="DOWNTIME_TIME" id="DOWNTIME_TIME" data-parsley-required>
                    </div>                          
            </div>
            <!-- <p id="demo"></p> -->
            <?php
        }
	}
?>

<!-- <script>
function statFunction() {
  var x = document.getElementById("STATUS_DOWNTIME").value;
  document.getElementById("demo").innerHTML = "You selected: "
}

function statFunction2() {
  var x = document.getElementById("STATUS_DOWNTIME2").value;
  document.getElementById("demo").innerHTML = "You selected: " + x;
}
</script> -->