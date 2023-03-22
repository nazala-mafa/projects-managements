$(document).ready(function () {
  // Datatables
  const table = $("#users-table").DataTable({
    processing: true,
    serverSide: true,
    ajax: window.location.pathname,
    buttons: ["reload"],
    columns: [
      {
        data: "id",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      { data: "name" },
      { data: "email" },
    ],
  });

  // Modal
  let modal = new bootstrap.Modal(document.getElementById("modal"), {
    keyboard: false,
  });
  let modelTitle = document.querySelector(".modal-title");

  let inputId = document.querySelector("input#id");
  let inputName = document.querySelector("input#name");
  let inputEmail = document.querySelector("input#email");
  let inputPassword = document.querySelector("input#password");
  function clearForm() {
    inputId.value = null;
    inputName.value = null;
    inputEmail.value = null;
    inputPassword.value = null;
  }

  // Toash
  var toast = new bootstrap.Toast(document.getElementById("toast"));

  // Actions handler
  $(".btn-add").click(function () {
    modelTitle.innerHTML = "Add New User";
    clearForm();
    modal.show();
  });

  $(".btn-submit").click(async function () {
    let formData = new FormData();
    formData.append("name", inputName.value);
    formData.append("email", inputEmail.value);
    formData.append("password", inputPassword.value);

    let res = await fetch(`/users`, {
      method: "post",
      body: formData,
      headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
          .content,
      },
    }).then((res) => res.json());

    $(".toast-body").html(res.message);
    res.success
      ? $("#toast").removeClass("bg-danger").addClass("bg-primary")
      : $("#toast").removeClass("bg-primary").addClass("bg-danger");

    table.ajax.reload();
    toast.show();
    clearForm();
    modal.hide();
  });
});
