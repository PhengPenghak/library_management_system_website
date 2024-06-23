<div class="modal fade" id="modalCenter" role="dialog" aria-labelledby="modalCenterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header mr-4">
        <h5 id="modalCenterLabel" class="modal-title"> Title </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="fas fa-times fa-1x"></span>
        </button>
      </div>
      <div class="modal-body pb-3" id="modalContent">

      </div>
    </div>
  </div>
</div>


<?php
$script = <<<JS

$(document).ready(function () {
  $("#modalCenter").data("bs.modal", null);
  $("#modalCenter").modal({
    show: false,
    backdrop: "static",
    keyboard: true,
  });
});
  

JS;
$this->registerJs($script);
?>