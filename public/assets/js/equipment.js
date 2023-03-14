$(document).on("click", ".equipment-table-row", function () {
    // e.preventDefault();
    $(".bgr-selected").removeClass("bgr-selected");
    var id = $(this).attr("data-get");
    var id_element = $(this).attr("id");
    $.ajax({
        url: "/equipment_detail",
        type: "GET",
        data: {
            id: id,
        },
        success: (response) => {
            if (response.status == "success") {
                $("#table_equipment_detail").html(response.body);
                $("#" + id_element).addClass("bgr-selected");
            }
        },
        error: (error) => {},
    });
});
function readURL_img_equipment(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#img_img_equipment_show").attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
//get equipment_type build on insert equipment3
$(document).ready(() => {
    $("#btn-add-equipment").on("click", () => {
        builalltypes();
    });
});
function builalltypes() {
    $.ajax({
        url: "equipment_type",
        type: "GET",
        success: (response) => {
            var data = response.equipment_types;
            let html = "";
            $.each(data, (index, value) => {
                html += `<option value="${value.id}">${value.name}</option>`;
            });
            $("#equipment_type").html(html);
            get_all_supplier();
        },
    });
}
$(document).ready(() => {
    $("#btn-equipmnet-manager").on("click", () => {
        getAlldataEquipmentTypes();
    });
});
function getAlldataEquipmentTypes() {
    $.ajax({
        type: "GET",
        url: "equipment_type",
        success: (response) => {
            console.log(response);
            var data = response.equipment_types;
            let html = "";
            $.each(data, (index, value) => {
                html += `
                    <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                        <a class="justify-content-start col-8 ">
                            <i class="ni ni-fat-delete"></i>${value.name}
                        </a>
                        <div class="col-4 d-flex justify-content-end">
                            <a onclick="get_equipment_type_by_id(${value.id})" class="text-sm font-weight-bold mb-0 " id="btn_autho_update" style="cursor: pointer">Sửa</a> |
                            <a class="text-sm font-weight-bold mb-0 " onclick="deleteEquipmentByID(${value.id})" id="btn_autho_delete" style="cursor: pointer">Xóa</a>
                        </div>
                    </div>`;
            });
            $("#list_equipment_type_build").html(html);
        },
    });
    builalltypes();
}
function get_equipment_type_by_id(id) {
    $.ajax({
        url: "/equipment_type/s",
        type: "GET",
        data: {
            id: id,
        },
        success: (response) => {
            $("#insert_emquipment_types").html("Lưu");
            $("#equipment_type_code_insert").val(response.equipment_type.code);
            $("#equipment_type_insert").val(response.equipment_type.name);
            $("#equipment_type_id").val(response.equipment_type.id);
            response.equipment_type.accessory == 0
                ? $("#ischild").prop("checked", false)
                : $("#ischild").prop("checked", true);
        },
    });
}
function get_all_supplier() {
    $.ajax({
        url: "equipment_supplier",
        type: "GET",
        success: (response) => {
            var data = response.suppliers;
            let html = "";
            $.each(data, (index, value) => {
                html += `<option value="${value.id}">${value.name}</option>`;
            });
            $("#equipment_supplier").html(html);
        },
    });
}
//insert equipment
$(document).ready(function () {
    $("#submit_insert_equipment").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type: "POST",
            url: "/equipment",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.status == "error") {
                    onAlertError(response.message);
                } else {
                    onAlertSuccess(response.message);
                    $("#img_equipment").val("");
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});

function getEquipmentDetail(id) {
    $.ajax({
        url: "/equipment_detail",
        type: "GET",
        data: {
            id: id,
        },
        success: (response) => {
            if (response.status == "success") {
                $("#table_equipment_detail").html(
                    response.build_equipment_detail
                );
            }
        },
    });
}
function getAllEquipment() {
    $.ajax({
        url: "/equipment",
        type: "GET",
        success: (response) => {
            if (response.status == "success") {
                $("#table_equipment_detail").html(
                    response.build_equipment_detail
                );
            }
        },
    });
}
function getAllEquipmentTypes() {
    $.ajax({
        url: "/",
        type: "GET",
        success: (response) => {
            if (response.status == "success") {
                $("#table_equipment_detail").html(
                    response.build_equipment_detail
                );
            }
        },
    });
}
function deleteEquipmentByID(id) {
    $.ajax({
        url: "equipment_type",
        type: "DELETE",
        data: { id: id },
        success: (response) => {
            onAlertSuccess(response.message);
            getAlldataEquipmentTypes();
        },
    });
}
$(document).ready(function () {
    $("#insert_emquipment_types").on("click", (e) => {
        e.preventDefault();
        var equipment_type_code_insert = $("#equipment_type_code_insert").val();
        var equipment_type = $("#equipment_type_insert").val();
        var equipment_type_id = $("#equipment_type_id").val();
        var isCheched = $("#ischild").is(":checked");
        $.ajax({
            url: "/equipment_type",
            type: "POST",
            data: {
                equipment_type_code_insert: equipment_type_code_insert,
                id: equipment_type_id,
                equipment_type: equipment_type,
                accessory: isCheched,
            },
            success: (response) => {
                if (response.status == "success") {
                    onAlertSuccess("Thêm thể loại thành công !");
                    getAlldataEquipmentTypes();
                    $("#equipment_type_code_insert").val("");
                    $("#insert_emquipment_types").html("Thêm");
                    $("#equipment_type_insert").val("");
                    $("#equipment_type_id").val("");
                } else {
                    onAlertError(response.message);
                }
            },
            error: (error) => {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});
