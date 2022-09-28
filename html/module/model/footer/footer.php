<!-- START container-fluid -->
<script type="text/javascript">
    // jQuery plugin to prevent double submission of forms
    jQuery.fn.preventDoubleSubmission = function() {
      $(this).on('submit',function(e){
        var $form = $(this);

        if ($form.data('submitted') === true) {
          // Previously submitted - don't submit again
          e.preventDefault();
        } else {
          // Mark it so that the next submit can be ignored
          $form.data('submitted', true);
        }
      });

      // Keep chainability
      return this;
    };
</script>
<br><br><br>
<footer id="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <!-- copyright -->
                <p class="nm" style="font-weight: bold;">&copy; Copyright 2021. PT. Mega Marine Pride.</p>
                <!--/ copyright -->
            </div>
        </div>
    </div>
</footer>
<!--/ END container-fluid -->