$("#modal .modal-header .close").removeAttr("data-dismiss");

var unsaved = false;
$("#modal").on("shown.bs.modal", function (e) {
  $(".modal form :input, .modal form select").change(function () {
    unsaved = true;
  });
});

$("#modal").on("hidden.bs.modal", function (e) {
  unsaved = false;
  $("#modalContent").html("");
});

$("#modal .modal-header .close").click(function () {
  if (unsaved) {
    Swal.fire({
      title: "Warning!",
      text: "Do you want to leave without saving?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "YES",
    }).then((result) => {
      if (result.isConfirmed) {
        $("#modal").modal("hide");
      }
    });
  } else {
    $("#modal").modal("hide");
  }
});

$(document).ready(function () {
  $("#modal").data("bs.modal", null);
  $("#modal").modal({
    show: false,
    backdrop: "static",
    keyboard: true,
  });
});
$(document).ready(function () {
  $("#modalDrawerRight").data("bs.modal", null);
  $("#modalDrawerRight").modal({
    show: false,
    backdrop: "static",
    keyboard: true,
  });
});
