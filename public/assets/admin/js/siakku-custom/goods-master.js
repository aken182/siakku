'use-strict';

$(document).ready(function () {
  var h = $("#harga_jual");
  var hc = $("#harga_jual_common");
  var ch = $("#cek_harga_jual");
  var cs = $("#cek_status");
  var sk = $("#status_konversi");

  if (sk.val() == "S") {
    cs.prop("disabled", true)
  }
  else {
    cs.prop("disabled", false)

  }

  cs.on("change", function () {
    let cek_ya = this.checked;
    if (cek_ya) {
      sk.val("Y");
    } else {
      sk.val("T");
    }
  });

  if (h.val() <= 0 || h.val() == "Rp 0") {
    hc.hide();
  }

  ch.on("change", function () {
    let cek_ya = this.checked;
    if (cek_ya) {
      hc.fadeIn();
    } else {
      hc.fadeOut();
    }
  });

});