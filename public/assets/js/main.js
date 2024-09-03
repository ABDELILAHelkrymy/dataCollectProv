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

const getApplicationsByFunctionId = (fonctionId) => {
  $.ajax({
    url: "/appilcations/getApplicationsByFunctionId",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      fonctionId: fonctionId,
    }),
    success: function (data) {
      let options = "";
      data.map((application) => {
        options += `<option selected="selected" value="${application.id}">${application.nom}</option>`;
      });
      $("#applications").html(options);
    },
    error: function (error) {
      console.log(error);
    },
  });
};

const functionIdSelectedHandler = () => {
  let fonctionId = $("#fonctions").val();
  getApplicationsByFunctionId(fonctionId);
  $("#fonctions").on("change", function () {
    fonctionId = $(this).val();
    getApplicationsByFunctionId(fonctionId);
  });
};

const getCompteById = (compteId) => {
  $.ajax({
    url: "/comptes/getCompteById",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      id: compteId,
    }),
    success: function (data) {
      $("#nom").val(data.nom);
      $("#prenom").val(data.prenom);
      $("#centre").val(data.site_physique);
    },
    error: function (error) {
      console.log(error);
    },
  });
};

const compteIdSelectHandler = () => {
  let compteId = $("#compte_email").val();
  getCompteById(compteId);
  $("#compte_email").on("change", function () {
    compteId = $(this).val();
    getCompteById(compteId);
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

// const titleHandler = () => {
//   const selected = $("#select-title").val();

//   selected === "Mme" ? $(".nom_naissance").removeAttr("disabled") : null;

//   $("#select-title").on("change", () => {
//     const selected = $("#select-title").val();
//     console.log("change");
//     selected === "Mme"
//       ? $(".nom_naissance").removeAttr("disabled")
//       : $(".nom_naissance").attr("disabled", "disabled");
//     addRedPointToRequiredInputs();
//   });

//   addRedPointToRequiredInputs();
// };

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
  // const message_email = $(".email-message").attr("data-email-message");
  // if (message_email && message_email !== "") {
  //   $(".email-message-toast .toast-body").text(message_email);
  //   $(".email-message-toast.toast").show();
  // }
  // $(".email-message-toast .btn-close").on("click", function () {
  //   $(".email-message-toast.toast").hide();
  // });
};

const profileClickHandler = () => {
  $(".showProfileDropdown").on("click", function () {
    $(".profileDropdown").toggle();
  });

  // click anywhere to close the dropdown
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".showProfileDropdown").length) {
      $(".profileDropdown").hide();
    }
  });
};

const applicationsMultiSelectHandler = () => {
  $(".cls_select").select2({
    // maximumSelectionLength: 6,
    placeholder: "Trouver les applications",
    // message alert when the maximum number of selected items is reached
    language: {
      // maximumSelected: function (e) {
      //   return (
      //     "vous ne pouvez pas sélectionner plus de " + e.maximum + " éléments"
      //   );
      // },
      // message alert when no results found
      noResults: function () {
        return "Aucun résultat trouvé";
      },
    },
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

const addRedPointToRequiredInputs = () => {
  $(".form-group").each(function () {
    if (
      ($(this).find("input").prop("required") ||
        $(this).find("select").prop("required")) &&
      !$(this).find(".form-control-label").has(".text-danger").length
    ) {
      $(this)
        .find(".form-control-label")
        .append('<span class="text-danger">*</span>');
    }
  });
};

var jsonData; // Declare a variable to hold JSON data

const readCsvOrExcelFile = () => {
  $("#file-csv-materiel").on("change", function (e) {
    const file = e.target.files[0];
    if (!file) return;

    var reader = new FileReader();
    reader.onload = function (e) {
      var contents = e.target.result;

      // Check file extension to determine file type
      var extension = file.name.split(".").pop().toLowerCase();
      if (extension === "csv") {
        // Handle CSV file
        var rows = contents.split("\n"); // Split by newline character to get rows
        var result = [];
        rows.forEach(function (row) {
          var cells = row.split(","); // Split each row by comma to get cells
          result.push(cells);
        });

        // Convert array to JSON string
        jsonData = JSON.stringify(result);
        // add class is-valid to the input
        $(".input-csv").addClass("has-success");
        $("#file-csv-materiel").addClass("is-valid");
      } else if (extension === "xlsx") {
        // Handle Excel file using SheetJS
        var workbook = XLSX.read(contents, { type: "binary" });
        var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        // Add custom options to parse dates correctly
        var result = XLSX.utils.sheet_to_json(firstSheet, {
          header: 1,
          rawDates: true,
        });
        jsonData = JSON.stringify(result);
        // add class is-valid to the input
        $(".input-csv").addClass("has-success");
        $("#file-csv-materiel").addClass("is-valid");
      } else {
        console.log("Unsupported file format");
      }
    };
    reader.readAsBinaryString(file);
  });
};

const handleUplaodMaterielCsvFile = () => {
  $("#uploadForm").on("submit", function (event) {
    event.preventDefault();
    $.ajax({
      url: "/uploadMaterielCsvFile",
      type: "POST",
      contentType: "application/json",
      data: jsonData,
      success: function (response) {
        window.location.href = "/materiels";
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
};

const handledisbalingExportMateriel = () => {
  if ($('input[name="materials_Ids[]"]:checked').length > 0) {
    $(".export-materiel").removeClass("disabled");
  } else {
    $(".export-materiel").addClass("disabled");
  }
};

const handleExportMaterielDisabling = () => {
  $(".export-materiel").addClass("disabled");
  $('input[name="materials_Ids[]"]').on("change", function () {
    handledisbalingExportMateriel();
  });
};

const handleSelectAll = () => {
  $('input[name="select_all"]').on("change", function () {
    $('input[name="materials_Ids[]"]').each(function () {
      $(this).prop("checked", $('input[name="select_all"]').prop("checked"));
      handledisbalingExportMateriel();
    });
  });
};

const handleExportMaterielCsvFile = () => {
  $(".export-materiel").on("click", function () {
    let materielsIds = [];
    $('input[name="materials_Ids[]"]:checked').each(function () {
      materielsIds.push($(this).val());
    });

    $.ajax({
      url: "/exportMaterialCsvFile",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({ materielsIds: materielsIds }),
      xhrFields: {
        responseType: "blob", // Important for handling binary response
      },
      success: function (response, status, xhr) {
        const disposition = xhr.getResponseHeader("Content-Disposition");
        let filename = "materiels.xlsx";
        if (disposition && disposition.indexOf("attachment") !== -1) {
          const matches = /"([^"]*)"/.exec(disposition);
          if (matches != null && matches[1]) {
            filename = matches[1];
          }
        }
        const blob = new Blob([response], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        setTimeout(function () {
          URL.revokeObjectURL(url);
        }, 1000);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
};

const handleExportCompteCsvFile = () => {
  $(".export-compte-btn").on("click", function () {
    let type = $(".export-compte:checked").val();
    let startDate = $(".date-start").val();
    let endDate = $(".date-end").val();

    $.ajax({
      url: "/exportCompteCsvFile",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({
        type: type,
        startDate: startDate,
        endDate: endDate,
      }),
      xhrFields: {
        responseType: "blob", // Important for handling binary response
      },
      success: function (response, status, xhr) {
        const disposition = xhr.getResponseHeader("Content-Disposition");
        let filename = "comptes.xlsx";
        if (disposition && disposition.indexOf("attachment") !== -1) {
          const matches = /"([^"]*)"/.exec(disposition);
          if (matches != null && matches[1]) {
            filename = matches[1];
          }
        }
        const blob = new Blob([response], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        setTimeout(function () {
          URL.revokeObjectURL(url);
        }, 1000);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
};

function validatePassword(inputSelector, errorSelector) {
  $(inputSelector).on("input", function () {
    // the password must have 8 characters at least
    let password = $(this).val();
    let passwordRegex = /^[A-Za-z0-9]{8,}$/;
    if (!passwordRegex.test(password) && password.length !== 0) {
      $(errorSelector).text(
        "Veuillez saisir un mot de passe valide (8 caractères minimum)."
      );
      $(this).closest(".compte-btn").addClass("disabled");
      return false;
    } else {
      $(errorSelector).text("");
      $(this).closest(".compte-btn").removeClass("disabled");
      return true;
    }
  });
}

function validateInput(inputSelector, errorSelector, digitCount, fieldName) {
  $(inputSelector)
    .on("blur", function () {
      // verify if the input is valid
      let inputVal = $(this).val();
      let inputRegex = new RegExp("^[0-9]{" + digitCount + "}$");
      let errorClass = $(this).parent().parent().find(errorSelector);
      let errorText = `Veuillez saisir un ${fieldName} valide de ${digitCount} chiffres.`;

      if (!inputRegex.test(inputVal) && inputVal.length !== 0) {
        errorClass.text(errorText);
        $(".compte-btn").addClass("disabled");
        $(".site-btn").addClass("disabled");
        return false;
      } else {
        errorClass.text("");
        $(".compte-btn").removeClass("disabled");
        $(".site-btn").removeClass("disabled");
        return true;
      }
    })
    .on("keypress", function (e) {
      // Allow only numbers (key codes 48-57) and backspace (key code 8)
      let key = e.which || e.keyCode;
      if ((key < 48 || key > 57) && key !== 8) {
        e.preventDefault();
      }

      // Block input if size is equal to digitCount
      if ($(this).val().length === digitCount) {
        e.preventDefault();
      }
    });
}

function validateCustomInput(inputSelector, errorSelector, prefix, maxLength) {
  $(inputSelector)
    .on("input", function () {
      let inputValue = $(this).val();
      let inputRegex = new RegExp(`^[${prefix}][A-Z0-9]*$`); // Include numbers in the regular expression
      if (!inputRegex.test(inputValue) && inputValue.length !== 0) {
        $(errorSelector).text(
          `Veuillez saisir un identifiant valide commençant par ${prefix} et contenant uniquement des lettres majuscules et des chiffres.`
        );
        $(".compte-btn").addClass("disabled");
        return false;
      } else {
        $(errorSelector).text("");
        $(".compte-btn").removeClass("disabled");
        return true;
      }
    })
    .on("keypress", function (e) {
      // Allow uppercase letters (key codes 65-90), numbers (key codes 48-57), and backspace (key code 8)
      let key = e.which || e.keyCode;
      if ((key < 65 || key > 90) && (key < 48 || key > 57) && key !== 8) {
        e.preventDefault();
      }

      // Block input if size is equal to maxLength
      if ($(this).val().length === maxLength) {
        e.preventDefault();
      }
    });
}

const handleValideButtonDIsabling = () => {
  // remove disabled attr from .valide-class if all required inputs are filled
  // get required inputs
  let count = 0;
  let isAllFilled = true;
  $("input[required]").each(function () {
    if ($(this).val() === "") {
      count++;
    }
  });
  if (count > 0) {
    isAllFilled = false;
  }
  return isAllFilled;
};

function validateNameInput(inputSelector, errorSelector, regex, errorMessage) {
  $(inputSelector).on("input", function () {
    let inputValue = $(this).val();
    if (!regex.test(inputValue) && inputValue.length !== 0) {
      $(errorSelector).text(errorMessage);
      $(".compte-btn").addClass("disabled");
      return false;
    } else {
      $(errorSelector).text("");
      $(".compte-btn").removeClass("disabled");
      return true;
    }
  });
}

const handleNatureContaratPrestataireSelect = () => {
  $('select[name="nature_contrat"]').on("change", function () {
    let selectedValue = $(this).val();
    if (selectedValue === "Prestataire") {
    }
  });
};

// fill the table with materiels based on type and sortiDuStockMotif
const fillRowsInTable = (data, type) => {
  let table = $(".table-materiel");
  let action = "";
  table.find("thead tr th.action").remove();
  if (type === "disponible") {
    const action = `<th class="action text-secondary opacity-7"></th>`;
    table.find("thead tr").append(action);
  }
  let rows = "";
  data.forEach((materiel) => {
    rows += `<tr>
      <td>
        <p class="text-xs text-secondary mb-0">
          ${materiel.nom}
        </p>
      </td>
      <td>
        <p class="text-xs text-secondary mb-0">
          ${materiel.marque}
        </p>
      </td>
      <td>
        <p class="text-xs text-secondary mb-0">
          ${materiel.serie}
        </p>
      </td>
      ${
        type === "disponible"
          ? `<td class="align-middle">
                <a href="/materiels/modifier/${materiel.id}"
                    class="text-info font-weight-bold text-md mx-2" id="editCompte">
                    <i class='bx bx-cog'></i>
                </a>
            </td>`
          : ""
      }
    </tr>`;
  });
  table.find("tbody").html(rows);
};

const handleSearchMaterielByTypeAndSortiDuStock = () => {
  $(".materiel-state").each(function () {
    $(this).on("click", function () {
      let type = $(".type-materiel").val();
      let sortiDuStockMotif = $(this).data("state");
      $(".type-state").text(sortiDuStockMotif);
      $.ajax({
        url: "/materielByTypeAndSortiDuStock",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          type: type,
          sortiDuStockMotif: sortiDuStockMotif,
        }),
        success: function (response) {
          fillRowsInTable(response, sortiDuStockMotif);
        },
        error: function (error) {
          console.log(error);
        },
      });
    });
  });
};

$(document).ready(function () {
  logoutHandler();
  addRedPointToRequiredInputs();
  messageInfoHandler();
  profileClickHandler();
  applicationsMultiSelectHandler();
  siteIdSelectedHandler();
  serviceIdSelectedHandler();

  handleExportMaterielDisabling();
  handleSelectAll();
  handleExportMaterielCsvFile();
  handleExportCompteCsvFile();

  compteIdSelectHandler();

  validatePassword("#mot_de_passe_portea", ".error-password_portea");
  validatePassword("#mot_de_passe", ".error-password");

  validateInput("input.tel", ".error-phone", 10, "téléphone portable");
  validateInput("input.telInterne", ".error-phone", 8, "téléphone interne");
  validateInput("input.telExterne", ".error-phone", 8, "téléphone externe");
  validateInput("input.ref_gala", ".error-gala", 8, "réference gala");

  validateCustomInput("#id_neptune", ".error-id-neptune", "Y", 8);
  validateCustomInput("#user_protea", ".error-user-protea", "G", 7);

  if ($("#applications").length > 0) functionIdSelectedHandler();
  downloadFile();
  $(".select2custom").select2({
    placeholder: "Trouver un compte",
    language: {
      noResults: function () {
        return "Aucun résultat trouvé";
      },
    },
  });

  // add key press to input search
  $(".search-input").keypress(function (e) {
    if (e.which == 13) {
      e.preventDefault();
      let search = $(this).val();
      window.location.href = `?q=${search}`;
    }
  });

  // verify is password and confirmee password are the same
  $("#user-btn").on("click", (e) => {
    let password = $("#password").val();
    let confirmPassword = $("#confirme_password").val();
    if (password !== confirmPassword) {
      e.preventDefault();
      $(".error-password").text(
        "Veuillez vérifier que le mot de passe et sa confirmation sont cohérents."
      );
      // block the form submission befor send the data to the conroller
      return false;
    } else {
      $(".error-password").text("");
      return true;
    }
  });

  $("#confirme_password_new").on("keyup", function () {
    var password = $("#password_new").val();
    var confirmPassword = $("#confirme_password_new").val();

    if (password !== confirmPassword) {
      $("#passwordMessage").show();
      $("#change-password-btn").addClass("disabled");
    } else {
      $("#passwordMessage").hide();
      $("#change-password-btn").removeClass("disabled");
    }
  });

  // make the input of date_naissance max to before 6 years
  let date = new Date();
  date.setFullYear(date.getFullYear() - 16);
  let year = date.getFullYear();
  let month = date.getMonth() + 1;
  let day = date.getDate();
  let maxDate = `${year}-${month < 10 ? "0" + month : month}-${
    day < 10 ? "0" + day : day
  }`;

  $("#date_naissance").attr("max", maxDate);

  validateNameInput(
    "#nom-compte",
    ".error-name",
    /^[A-Z]*$/,
    "Veuillez saisir un nom en majuscule."
  );

  validateNameInput(
    "#prenom-compte",
    ".error-prenom",
    /^[A-Z][a-z]*$/,
    "Veuillez saisir un prénom valide (la première lettre en majuscule)."
  );

  validateNameInput(
    "#nom-materiel",
    ".error-nom-materiel",
    /^[A-Z0-9]*$/,
    "Veuillez saisir un nom en majuscule."
  );

  validateNameInput(
    "#marque-materiel",
    ".error-marque-materiel",
    /^[A-Z0-9]*$/,
    "Veuillez saisir une marque en majuscule."
  );

  validateNameInput(
    "#serie-materiel",
    ".error-serie-materiel",
    /^[A-Z0-9]*$/,
    "Veuillez saisir un serie en majuscule."
  );

  $("th[data-sort]").on("click", function () {
    var $header = $(this);
    var sortKey = $header.data("sort");
    var $table = $header.closest("table");
    var $tbody = $table.find("tbody");
    var $rows = $tbody.find("tr").toArray();
    var isAscending = $header.hasClass("asc");

    // Remove sort classes from all headers
    $table.find("th").removeClass("asc desc");
    //$table.find(".sort-icon").removeClass("asc desc");

    // Add sort class to current header
    $header.toggleClass("asc", !isAscending).toggleClass("desc", isAscending);
    // $header
    //   .find(".sort-icon")
    //   .toggleClass("asc", !isAscending)
    //   .toggleClass("desc", isAscending);

    // Sort rows
    $rows.sort(function (a, b) {
      var aText = $(a)
        .find('td[data-key="' + sortKey + '"]')
        .text()
        .trim();
      var bText = $(b)
        .find('td[data-key="' + sortKey + '"]')
        .text()
        .trim();
      return isAscending
        ? aText.localeCompare(bText, undefined, { numeric: true })
        : bText.localeCompare(aText, undefined, { numeric: true });
    });

    // Append sorted rows to tbody
    $.each($rows, function (index, row) {
      $tbody.append(row);
    });
  });

  $(".valide-btn").on("click", function () {
    $(".valide-input").val("validée");
    $("#modal-notification").hide();
  });

  $(".changeStatus").each(function () {
    $(this).on("click", function (e) {
      let statut = $(this).data("statut");
      let statut_modal = $(this).data("statut-modal");
      $(".statut").text(statut);
      $(".statut-input").val(statut);
      $(".status-modal").text(statut_modal);
    });
  });

  const isAllFilled = handleValideButtonDIsabling();
  if (isAllFilled) {
    $(".valide-class").removeAttr("disabled");
  } else {
    $(".valide-class").attr("disabled", "disabled");
  }

  $("input[required]").each(function () {
    $(this).on("input", function () {
      const isAllFilled = handleValideButtonDIsabling();
      if (isAllFilled) {
        $(".valide-class").removeAttr("disabled");
      } else {
        $(".valide-class").attr("disabled", "disabled");
      }
    });
  });

  $(".statut-confirme-link").on("click", function () {
    const id = $(".valide-input").val();
    const statut = $(".statut-input").val();
    let formDataInputs = $("#compteForm").serializeArray();
    // Convert the array to an object
    var formDataObject = {};
    $.each(formDataInputs, function (index, field) {
      formDataObject[field.name] = field.value;
    });

    var formData = new FormData();

    // Get all the files from the file input
    var files = $("#file-input")[0].files;

    // Append each file to the FormData object
    for (var i = 0; i < files.length; i++) {
      formData.append("pieces_jointe[]", files[i]);
    }
    // Append the object to the FormData object
    formData.append("compte", JSON.stringify(formDataObject));
    formData.append("id", id);
    formData.append("statut", statut);
    // Show spinner modal
    let spinnerModal = new bootstrap.Modal(
      document.getElementById("modal-spinner"),
      {
        backdrop: "static",
        keyboard: false,
      }
    );
    spinnerModal.show();
    $.ajax({
      url: "/compteUpdateStatus",
      type: "POST",
      contentType: false,
      processData: false,
      // send all data in the form and the files
      data: formData,
      success: function (data) {
        spinnerModal.hide();
        let demandeModal = new bootstrap.Modal(
          document.getElementById("modal-demande"),
          {
            backdrop: "static",
            keyboard: false,
          }
        );
        demandeModal.show();
        setTimeout(() => {
          window.location.href = "/comptes";
        }, 2000);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });

  $(".denamdeChangeStatus").each(function () {
    $(this).on("click", function () {
      let statut = $(this).data("statut");
      if (statut === "modifier") {
        $(".statut-demanded").text("la demande de modification de ");
      } else {
        $(".statut-demanded").text("la demande de désactivation de");
      }
      const id = $(".valide-input").val();
      let spinnerModal = new bootstrap.Modal(
        document.getElementById("modal-spinner"),
        {
          backdrop: "static",
          keyboard: false,
        }
      );
      spinnerModal.show();
      $.ajax({
        url: "/compteUpdateStatus",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
          id: id,
          statut: statut,
        }),
        success: function (data) {
          spinnerModal.hide();
          let demandeModal = new bootstrap.Modal(
            document.getElementById("modal-demande"),
            {
              backdrop: "static",
              keyboard: false,
            }
          );
          demandeModal.show();
          setTimeout(() => {
            window.location.href = "/comptes";
          }, 2000);
        },
        error: function (error) {
          console.log(error);
        },
      });
    });
  });

  // Array to store all selected files
  var fileList = [];

  // Upload files handler
  $("#file-input").on("change", function (e) {
    var files = e.target.files;

    // Add the new files to the fileList array
    $.each(files, function (index, file) {
      fileList.push(file);
    });

    // Clear the input to allow for additional file selection
    e.target.value = "";

    // Display the updated file list
    renderFileList();
  });

  // Function to render the file list
  function renderFileList() {
    var $fileList = $("#file-list");
    $fileList.empty(); // Clear the current list

    $.each(fileList, function (index, file) {
      var $li = $(
        '<li class="list-group-item d-flex justify-content-between align-items-center"></li>'
      );
      $li.text(file.name);

      var $removeButton = $(
        '<a href="javascript:;" class="text-danger font-weight-bold text-sm"><i class="ni ni-basket"></i></a>'
      );
      $removeButton.on("click", function () {
        $li.remove();
        removeFile(file.name);
      });

      $li.append($removeButton);
      $fileList.append($li);
    });
  }

  function removeFile(fileName) {
    var input = document.getElementById("file-input");
    var dataTransfer = new DataTransfer();
    var files = input.files;

    for (var i = 0; i < files.length; i++) {
      if (files[i].name !== fileName) {
        dataTransfer.items.add(files[i]);
      }
    }

    input.files = dataTransfer.files;
  }

  //handle documnt selected
  $(".select-doc").each(function () {
    $(this).on("click", function () {
      let docId = $(this).data("id");
      $(".doc-id-input").val(docId);
    });
  });

  // handle delete document
  $(".delete-doc").on("click", function () {
    let docId = $(".doc-id-input").val();
    $.ajax({
      url: "/attachementDelete",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({
        id: docId,
      }),
      success: function (data) {
        $(".doc-deleted-toast .toast-body").text("Document supprimé");
        $(".doc-deleted-toast.toast").show();
        setTimeout(() => {
          $(".doc-deleted-toast.toast").hide();
        }, 300);

        setTimeout(() => {
          window.location.reload();
        }, 300);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });

  $(".export-compte-btn").prop("disabled", true);
  $(".export-compte").each(function () {
    $(this).on("change", function () {
      if ($(".export-compte:checked").length === 0) {
        $(".export-compte-btn").prop("disabled", true);
      } else {
        $(".export-compte-btn").prop("disabled", false);
      }
      $(".export-compte").not(this).prop("checked", false);
      if ($(".export-by-date").is(":checked")) {
        $(".form-dates").removeClass("d-none");
      } else {
        $(".form-dates").addClass("d-none");
        $(".date-start").val(undefined);
        $(".date-end").val(undefined);
      }
    });
  });

  // disabled all inputs in the form if is disabled all
  if ($(".isAllDisabled").val() === "true") {
    $("input").prop("disabled", true);
    $("select").prop("disabled", true);
    $("textarea").prop("disabled", true);
  }

  if ($(".isAllButtonDisabled").val() === "true") {
    $("input").prop("disabled", true);
    $("select").prop("disabled", true);
    $("textarea").prop("disabled", true);
    $(".changeStatus").each(function () {
      $(this).hide();
    });
    $(".denamdeChangeStatus").each(function () {
      $(this).hide();
    });
  }

  // Trigger the input event on page load
  $("input[required]").trigger("input");

  $(".dropdown-nav").on("click", function () {
    $(this).next().toggle();
    if ($(this).find(".dropdown-icon").hasClass("bxs-chevron-down")) {
      $(this)
        .find(".dropdown-icon")
        .removeClass("bxs-chevron-down")
        .addClass("bxs-chevron-up");
    } else {
      $(this)
        .find(".dropdown-icon")
        .removeClass("bxs-chevron-up")
        .addClass("bxs-chevron-down");
    }
  });

  $(".watch-demandes").each(function () {
    $(this).on("click", function () {
      let statut_demanded = $(this).data("statut-demanded");
      window.location.href = `/comptes?q=${statut_demanded}`;
    });
  });

  handleNatureContaratPrestataireSelect();

  $("#nature_contrat").on("change", function () {
    let selectedValue = $(this).val();
    console.log(selectedValue);
    if (selectedValue === "Prestataire") {
      // select Externe on site_physique select option
      $("#site_physique option[data-centre='Externe']").prop("selected", true);
      $("#entitee_fonctionnelle").prop("disabled", true);
      $("#entitee_fonctionnelle").removeAttr("required");
    } else {
      $("#entitee_fonctionnelle").prop("disabled", false);
      $("#entitee_fonctionnelle").attr("required", "required");
    }
    getServicesByCityName($("#site_physique").val(), $("#site_physique").val());
  });

  $(".select-type-materiel").on("change", function () {
    let selectedValue = $(this).val();
    window.location.href = `/materiels/stock?q=${selectedValue}`;
  });

  handleSearchMaterielByTypeAndSortiDuStock();

  $('.date_collect').on('change', function () {
    date_collect = $(this).val();
    window.location.href = `/dashboard?q=${date_collect}`;
  });

  const nbrDistrict = 8;
  
const colors = ["bg-primary", "bg-secondary", "bg-success", "bg-info", "bg-warning", "bg-danger", "bg-light", "bg-gradient-success"]

  for (let i = 1; i <= nbrDistrict; i++) {
    $('.bg'+i).addClass('bg-'+i);
    $('.bg-dark'+i).addClass('bg-'+i+'-dark');
  }
});