// function to retrieve services based on city name (two cases : sityName=Paris or not)
const getServicesByCityName = (sitePhysique, entiteeFonctionnelle) => {
  // create ajax request to get the data from ServiceAjaxController on ready
  $.ajax({
    url: "/services/getServicesByCity",
    type: "POST",
    contentType: "application/json", // Set Content-Type header
    data: JSON.stringify({
      sitePhysique: sitePhysique,
      entiteeFonctionnelle: entiteeFonctionnelle,
    }),
    success: function (data) {
      let options = "";
      data.map((service) => {
        options += `<option value="${service.id}">${service.nom}</option>`;
      });
      $("#services").html(options);
      let serviceId = $("#services").val();
      getFunctionsByServiceId(serviceId);
    },
    error: function (error) {
      console.log(error);
    },
  });
};

const siteIdSelectedHandler = () => {
  let sitePhysique = $("#site_physique").val();
  let entiteeFonctionnelle = $("#site_physique").val();
  let centre = $("#site_physique").find("option:selected").data("centre");
  if (centre === "Externe") {
    $("#entitee_fonctionnelle").prop("disabled", true);
    $("#entitee_fonctionnelle").removeAttr("required");
  } else {
    $("#entitee_fonctionnelle").prop("disabled", false);
    $("#entitee_fonctionnelle").attr("required", "required");
  }
  $("#site_physique").on("change", function () {
    sitePhysique = $(this).val();
    centre = $(this).find("option:selected").data("centre");
    getServicesByCityName(sitePhysique, entiteeFonctionnelle);
    serviceId = $("#services").val();
    getFunctionsByServiceId(serviceId);
    if (centre === "Externe") {
      $("#entitee_fonctionnelle").prop("disabled", true);
      $("#entitee_fonctionnelle").removeAttr("required");
    } else {
      $("#entitee_fonctionnelle").prop("disabled", false);
      $("#entitee_fonctionnelle").attr("required", "required");
    }
  });
  $("#entitee_fonctionnelle").on("change", function () {
    entiteeFonctionnelle = $(this).val();
    getServicesByCityName(sitePhysique, entiteeFonctionnelle);
    serviceId = $("#services").val();
    getFunctionsByServiceId(serviceId);
  });
};

const getFunctionsByServiceId = (serviceId) => {
  $.ajax({
    url: "/functions/getFunctionsByServiceId",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      serviceId: serviceId,
    }),
    success: function (data) {
      let options = "";
      data.map((fonction) => {
        options += `<option value="${fonction.id}">${fonction.nom}</option>`;
      });
      $("#fonctions").html(options);
      let fonctionId = $("#fonctions").val();
      getApplicationsByFunctionId(fonctionId);
    },
    error: function (error) {
      console.log(error);
    },
  });
};

const serviceIdSelectedHandler = () => {
  let serviceId = $("#services").val();
  $("#services").on("change", function () {
    serviceId = $(this).val();
    getFunctionsByServiceId(serviceId);
  });
};

const logoutHandler = () => {
  let logout = document.querySelector(".log_out");
  if (logout) {
    logout.addEventListener("click", () => {
      // delete  a cookie named PHPSESSID
      document.cookie =
        "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      window.location.href = "/";
    });
  }
};

const messageInfoHandler = () => {
  const message_info = $(".message-info").attr("data-message");
  if (message_info && message_info !== "") {
    $(".message-info-toast .toast-body").text(message_info);
    $(".message-info-toast.toast").show();
    setTimeout(() => {
      $(".message-info-toast.toast").hide();
    }, 3000);
  }
  $(".message-info-toast .btn-close").on("click", function () {
    $(".message-info-toast.toast").hide();
  });
};

const downloadFile = () => {
  $(".download-file").on("click", function () {
    const filePath = $(this).data("file-path");
    const fileName = $(this).data("file-name");
    $.ajax({
      url: "/downloadFile",
      type: "POST",
      data: { filePath: filePath },
      xhrFields: {
        responseType: "blob",
      },
      success: function (response) {
        const blob = new Blob([response], { type: "application/pdf" });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        // add link to the body and click it to download the file
        $("body").append(link);
        link.href = url;
        link.download = fileName;
        link.target = "_blank";
        link.click();
        setTimeout(function () {
          URL.revokeObjectURL(url);
        }, 1000);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert("Error downloading file!");
      },
    });
  });
};

$(document).ready(function () {
  logoutHandler();
  messageInfoHandler();
  siteIdSelectedHandler();
  serviceIdSelectedHandler();
});
