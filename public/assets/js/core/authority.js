
$(document).ready(() => {
    $("#btn_save_autho").on("click", (e) => {
        e.preventDefault();
        var name = $("#autho_name").val();
        var id = $("#id_autho").val();
        var personnel = $("#personnel_autho_access").is(":checked");
        var insert_personnel = $("#insert_personnel").is(":checked");
        var update_personnel = $("#update_personnel").is(":checked");
        var delete_personnel = $("#delete_personnel").is(":checked");
        var accept_cv_autho = $("#accept_cv_autho").is(":checked");
        var update_cv_autho = $("#update_cv_autho").is(":checked");
        var inter_cv_autho = $("#inter_cv_autho").is(":checked");
        var eva_cv_autho = $("#eva_cv_autho").is(":checked");
        var offer_cv_autho = $("#offer_cv_autho").is(":checked");
        var authority_role = $("#authority_role").is(":checked");
        var faild_cv_autho = $("#faild_cv_autho").is(":checked");
        $.ajax({
            type: "POST",
            url: "/authorization",
            data: {
                id: id,
                autho_name: name,
                personnel_autho_access: personnel,
                insert_personnel: insert_personnel,
                update_personnel: update_personnel,
                delete_personnel: delete_personnel,
                accept_cv_autho: accept_cv_autho,
                update_cv_autho: update_cv_autho,
                inter_cv_autho: inter_cv_autho,
                eva_cv_autho: eva_cv_autho,
                offer_cv_autho: offer_cv_autho,
                authority: authority_role,
                faild_cv_autho: faild_cv_autho,
            },
            success: (result) => {
                if (result.status == "success") {
                    onAlertSuccess("Thay đổi đã được áp dụng !");
                    $("#btn_save_autho").html("Thêm Mới");
                    reset_id();
                    form_clear();
                    get_all_autho();
                } else {
                    onAlertError(result.message);
                }
            },
            error: (error) => {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});
function get_all_autho() {
    $.ajax({
        type: "GET",
        url: "/authorization",
        success: (result) => {
            if (result.status == "success") {
                let html = "";
                $.each(result.body.data, (index, value) => {
                    html += `<div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                    <a class="justify-content-start col-8 ">
                                        <i class="ni ni-fat-delete"></i>${value.name_autho}</a>
                                    <div class="col-4 d-flex justify-content-end">
                                                <a onclick="get_autho_By_Id(${value.id});"
                                                    class="text-sm font-weight-bold mb-0 " id="btn_autho_update"
                                                    style="cursor: pointer">Sửa
                                                </a>
                                                | <a class="text-sm font-weight-bold mb-0 " onclick="delete_autho_By_Id(${value.id});"
                                                 id="btn_autho_delete"
                                                    style="cursor: pointer">
                                                    Xóa</a>
                                    </div>
                                </div>
                                `;
                });
                $("#list_autho_build").html(html);
            } else {
                onAlertError(result.message);
            }
        },
        error: (error) => {
            onAlertError(error.responseJSON.message);
        },
    });
}
function get_autho_By_Id(id) {
    $("#btn_save_autho").html("Lưu");
    $.ajax({
        url: "/authorization/id",
        method: "GET",
        data: {
            id: id,
        },
        success: (response) => {
            if (response.status == "success") {
                var data = response.body;
                var quyen = data.personnel;
                $("#autho_name").val(data.name_autho);
                $("#id_autho").val(data.id);
                quyen.personnel_autho_access == "true"
                    ? $("#personnel_autho_access").prop("checked", true)
                    : $("#personnel_autho_access").prop("checked", false);
                quyen.insert_personnel == "true"
                    ? $("#insert_personnel").prop("checked", true)
                    : $("#insert_personnel").prop("checked", false);
                quyen.update_personnel == "true"
                    ? $("#update_personnel").prop("checked", true)
                    : $("#update_personnel").prop("checked", false);
                quyen.delete_personnel == "true"
                    ? $("#delete_personnel").prop("checked", true)
                    : $("#delete_personnel").prop("checked", false);
                quyen.accept_cv_autho == "true"
                    ? $("#accept_cv_autho").prop("checked", true)
                    : $("#accept_cv_autho").prop("checked", false);
                quyen.update_cv_autho == "true"
                    ? $("#update_cv_autho").prop("checked", true)
                    : $("#update_cv_autho").prop("checked", false);
                quyen.inter_cv_autho == "true"
                    ? $("#inter_cv_autho").prop("checked", true)
                    : $("#inter_cv_autho").prop("checked", false);
                quyen.offer_cv_autho == "true"
                    ? $("#offer_cv_autho").prop("checked", true)
                    : $("#offer_cv_autho").prop("checked", false);
                quyen.eva_cv_autho == "true"
                    ? $("#eva_cv_autho").prop("checked", true)
                    : $("#eva_cv_autho").prop("checked", false);
                quyen.faild_cv_autho == "true"
                    ? $("#faild_cv_autho").prop("checked", true)
                    : $("#faild_cv_autho").prop("checked", false);
                data.authority == "true"
                    ? $("#authority_role").prop("checked", true)
                    : $("#authority_role").prop("checked", false);
            } else {
                onAlertError("Lỗi server !");
            }
        },
        error: () => {
            onAlertError("Lỗi trong quá trình tìm kiếm nhóm quyền !");
        },
    });
}

function delete_autho_By_Id(id) {
    $.ajax({
        url: "/authorization",
        method: "DELETE",
        data: {
            id: id,
        },
        success: (response) => {
            if (response.status == "success") {
                onAlertSuccess("Xóa Thành Công !");
                reset_id();
                $("#btn_save_autho").html("Thêm Mới");
                get_all_autho();
            } else {
                onAlertError(response.message);
            }
        },
        error: () => {
            onAlertError("Lỗi trong quá trình tìm kiếm nhóm quyền !");
        },
    });
}
function reset_id() {
    $("#id_autho").val("");
}
function form_clear() {
    $("#autho_name").val("");
    $("#id_autho").val("");
    $("#personnel_autho_access").prop("checked", false);
    $("#insert_personnel").prop("checked", false);
    $("#update_personnel").prop("checked", false);
    $("#delete_personnel").prop("checked", false);
    $("#accept_cv_autho").prop("checked", false);
    $("#update_cv_autho").prop("checked", false);
    $("#inter_cv_autho").prop("checked", true);
    $("#inter_cv_autho").prop("checked", false);
    $("#offer_cv_autho").prop("checked", false);
    $("#eva_cv_autho").prop("checked", false);
    $("#authority_role").prop("checked", false);
    $("#faild_cv_autho").prop("checked", false);
}
