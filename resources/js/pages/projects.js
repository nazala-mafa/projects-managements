const role = document.querySelector('meta[name="role"]').content;

$(document).ready(function () {
  const table = $("#example").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/projects",
    buttons: ["reload"],
    columns: [
      {
        data: "id",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      { data: "name" },
      { data: "status" },
      {
        data: "image",
        render: function (data, _, row) {
          return `<img src="${data}" alt="${row.name} image" height="50" />`;
        },
      },
      {
        data: "id",
        render: function (_, __, row) {
          const rowData = JSON.stringify(row);
          const adminBtn =
            role === "admin"
              ? `
                <button data-row='${rowData}' class="btn btn-sm btn-primary btn-edit">edit</button>
                <button data-row='${rowData}' class="btn btn-sm btn-danger btn-delete">delete</button>
              `
              : "";

          return `
            <div class="d-flex justify-content-center gap-2">
              <a href="/projects/${row.id}/tasks" class="btn btn-sm btn-info">tasks</a>
              ${adminBtn}
            </div>
          `;
        },
      },
    ],
    drawCallback() {
      $(".btn-edit").click(edit);
      $(".btn-delete").click(deleteAttempt);
    },
  });

  // Modal
  let modalType = "create";
  let modal = new bootstrap.Modal(document.getElementById("modal"), {
    keyboard: false,
  });
  let modelTitle = document.querySelector(".modal-title");
  let inputId = document.querySelector("input#id");
  let inputName = document.querySelector("input#name");
  let inputStatus = document.querySelector("select#status");
  let inputImage = document.querySelector("input#image");
  let labelImage = document.querySelector("input#image").previousElementSibling;
  function clearForm() {
    inputId.value = null;
    inputName.value = null;
    inputStatus.value = null;
    inputImage.value = null;
  }

  // Toash
  var toast = new bootstrap.Toast(document.getElementById("toast"));

  // Actions handler
  $(".btn-add").click(function () {
    labelImage.innerHTML = "Image";
    modelTitle.innerHTML = "Add New Projects";
    modalType = "create";
    clearForm();
    modal.show();
  });

  $(".btn-submit").click(async function () {
    let formData = new FormData();
    formData.append("name", inputName.value);
    formData.append("status", inputStatus.value);
    inputImage.files[0] && formData.append("image", inputImage.files[0]);

    if (modalType === "create") {
      let res = await fetch("/projects", {
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
    } else if (modalType === "edit") {
      formData.append("_method", "put");

      let res = await fetch("/projects/" + inputId.value, {
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
    }

    table.ajax.reload();
    toast.show();
    clearForm();
    modal.hide();
  });

  function edit() {
    labelImage.innerHTML = "Image (fill to change image)";
    const rowData = $(this).data("row");

    modelTitle.innerHTML = `${rowData.name} Projects Edit`;
    modalType = "edit";
    inputId.value = rowData.id;
    inputName.value = rowData.name;
    inputStatus.value = rowData.status;

    modal.show();
  }

  async function deleteAttempt() {
    const rowData = $(this).data("row");
    if (!confirm(`Are yout sure to delete ${rowData.name} project?`)) {
      return;
    }

    let res = await fetch("/projects/" + rowData.id, {
      method: "delete",
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
  }
});
