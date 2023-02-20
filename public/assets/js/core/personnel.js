var fillterst;
var fillterdp;
var num;
var dbclick = [
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
];
// Ajax csrf_token
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
//==========================Personnel===================================
// DELETE Personnel
function onDelete(id) {
    //sweetalert
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Bạn muốn xóa ?",
            text: "Sau khi xóa không thể khôi phục !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Xóa",
            cancelButtonText: "Không",
            reverseButtons: true,
        })

        .then((result) => {
            if (result.isConfirmed) {
                //logic
                $.ajax({
                    url: "/personnel",
                    method: "DELETE",
                    data: {
                        count_type: id,
                    },
                    success: function (result) {
                        if (result.status == "error") {
                            onAlertError(result.message);
                        } else {
                            onAlertSuccess("Xoá Thành Công !");
                            $("#body_query").html(result.body);
                        }
                    },
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    "Đã Hủy !",
                    "Tác vụ xóa đã được hủy.",
                    "error"
                );
            }
        });
}

//Phân Trang
$(document).ready(function () {
    $(document).on("click", ".pagination a", function (e) {
        e.preventDefault();
        var page = $(this).attr("href");
        console.log(page);
        getMoresUser(page);
    });
});

// INSERT Personnel
$("#btn_insert_personnel").on("click", function (e) {
    e.preventDefault();
    var address = $("#address").val();
    var fullname = $("#fullname").val();
    var phone = $("#phone").val();
    var email = $("#email").val();
    var password = $("#password").val();
    if (
        (address == "") |
        (fullname == "") |
        (phone == "") |
        (email == "") |
        (password == "")
    ) {
        onAlertError("Vui lòng không để trống !");
    } else {
        $.ajax({
            url: "/personnel/add",
            method: "POST",
            data: {
                address: address,
                fullname: fullname,
                phone: phone,
                email: email,
                password: password,
            },
            success: function (result) {
                onAlertSuccess("Nhân sự mới của bạn đã thêm thành công !");
                $("#body_query").html(result.body);
                ClearFromA();
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    }
});

//GET Personnel where id
function getdetail(id) {
    $.ajax({
        url: "/personnel/edit",
        method: "GET",
        data: {
            id: id,
        },
        success: function (result) {
            var nhansu = result.data;
            if (nhansu.img_url == null) {
                nhansu.img_url = "avatar2.png";
            }
            $("#img_url").attr("src", "./img/" + nhansu.img_url);
            $("#id_user").val(nhansu.id);
            $("#about").val(nhansu.about);
            $("#gender").val(nhansu.gender);
            $("#title").val(nhansu.title);
            $("#personnel_codeu").val(nhansu.personnel_code);
            $("#fullnameu").val(nhansu.fullname);
            $("#phoneu").val(nhansu.phone);
            $("#emailu").val(nhansu.email);
            $("#passwordu").val(nhansu.password);
            $("#department_idu").val(nhansu.department_id);
            $("#date_of_birthu").val(nhansu.date_of_birth);
            $("#position_idu").val(nhansu.position_id);
            $("#recruitment_dateu").val(nhansu.recruitment_date);
            if ((nhansu.status == 3) | (nhansu.status == 4)) {
                $("#about-text").html("Lý Do:");
            } else {
                $("#about-text").html("Giới thiệu về bản thân :");
            }
            $("#statusu").val(nhansu.status);
            $("#addressup").val(nhansu.address);
        },
        error: function (error) {
            onAlertError("Vui lòng kiểm tra và thử lại !");
        },
    });
}
//GET Personnel View
function getdetailview(id) {
    $.ajax({
        url: "/personnel/edit",
        method: "GET",
        data: {
            id: id,
        },
        success: function (result) {
            var nhansu = result.data;
            if (nhansu.img_url == null) {
                nhansu.img_url = "avatar2.png";
            }
            $("#img_url")
                .attr("src", "./img/" + nhansu.img_url)
                .prop("disabled", true);
            $("#id_user").val(nhansu.id).attr("disabled", true);
            $("#about").val(nhansu.about).attr("disabled", true);
            $("#gender").val(nhansu.gender).attr("disabled", true);
            $("#title").val(nhansu.title).attr("disabled", true);
            $("#personnel_codeu").val(nhansu.personnel_code);
            $("#fullnameu").val(nhansu.fullname).attr("disabled", true);
            $("#phoneu").val(nhansu.phone).attr("disabled", true);
            $("#emailu").val(nhansu.email).attr("disabled", true);
            $("#passwordu").val(nhansu.password).attr("disabled", true);
            $("#department_idu")
                .val(nhansu.department_id)
                .attr("disabled", true);
            $("#date_of_birthu")
                .val(nhansu.date_of_birth)
                .attr("disabled", true);

            $("#position_idu").val(nhansu.position_id).attr("disabled", true);
            $("#recruitment_dateu")
                .val(nhansu.recruitment_date)
                .prop("disabled", true);
            if ((nhansu.status == 3) | (nhansu.status == 4)) {
                $("#about-text").html("Lý Do:");
            } else {
                $("#about-text").html("Giới thiệu về bản thân :");
            }
            $("#statusu").val(nhansu.status).prop("disabled", true);
            $("#addressup").val(nhansu.address).prop("disabled", true);
        },
        error: function (error) {
            onAlertError("Vui lòng kiểm tra và thử lại !");
        },
    });
}
//UPDATE
$(document).ready(function () {
    $("#form_update").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type: "POST",
            url: "/personnel",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.status == "error") {
                    onAlertError(response.message);
                } else {
                    onAlertSuccess("Thông tin của bạn đã được sửa đổi !");
                    $("#body_query").html(response.body);
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});

//Search HRM
$(document).ready(function () {
    $("#search").keyup(function () {
        var search = $("#search").val();
        $.ajax({
            url: "/personnel/search",
            method: "GET",
            data: {
                search: search,
            },
            success: function (result) {
                $("#body_query").html(result.body);
            },
        });
    });
});
//check status nghỉ
$(document).ready(function () {
    $("#statusu").on("change", function () {
        var stt = $("#statusu").val();
        if ((stt == 3) | (stt == 4)) {
            $("#about-text").html("Lý Do:");
            $("#about").val("");
        } else {
            $("#about-text").html("Giới thiệu về bản thân :");
            $("#about").val("");
        }
    });
});
//Fillter status
$(document).ready(function () {
    $("#status_select").on("change", function () {
        fillterst = $(this).val();
        if (isNaN(fillterst)) {
            fillterst = "";
        }
        console.log("Status" + fillterst);
        console.log("Phòng ban" + fillterdp);
        $.ajax({
            url: "/personnel/fillter",
            method: "GET",
            data: {
                status_filter: fillterst,
                department_filter: fillterdp,
            },
            success: function (result) {
                $("#body_query").html(result.body);
            },
        });
    });
});

//Fillter department
$(document).ready(function () {
    $("#department_select").on("change", function () {
        fillterdp = $(this).val();
        if (isNaN(fillterdp)) {
            fillterdp = "";
        }
        console.log("Status" + fillterst);
        console.log("Phòng ban" + fillterdp);
        $.ajax({
            url: "/personnel/fillter",
            method: "GET",
            data: {
                status_filter: fillterst,
                department_filter: fillterdp,
            },
            success: function (result) {
                $("#body_query").html(result.body);
            },
        });
    });
});

//edit level
$(document).on("change", ".read-checkbox-level", function () {
    var id = $(this).attr("level");
    var st = $(this).is(":checked");
    console.log(id);
    console.log(st);
    var level;
    if (st == true) {
        level = 1;
    } else {
        level = 0;
    }
    $.ajax({
        type: "POST",
        url: "/personnel/level",
        data: {
            id: id,
            level: level,
        },
        success: (response) => {
            if (response.status == "error") {
                onAlertError(response.message);
            } else {
                onAlertSuccess(response.message);
                $("#body_query").html(response.body);
            }
        },
        error: function (error) {
            onAlertError(error.responseJSON.message);
        },
    });
});
//==========================profile===================================
//UPDATE profile
$(document).ready(function () {
    $("#form_update_profile").on("submit", function (e) {
        e.preventDefault();
        var fullname = $("#fullname_profile").val();
        var email = $("#email_profile").val();
        var phone = $("#phone_profile").val();
        var date_of_birth = $("#date_of_birth_profile").val();
        var gender = $("#gender_profile").val();
        var address = $("#address_profile").val();
        var position_id = $("#position_id_profile").val();
        var department_id = $("#department_id_profile").val();
        var about = $("#about_profile").val();
        $.ajax({
            type: "POST",
            url: "/personnel/profile",
            data: {
                fullname: fullname,
                email: email,
                phone: phone,
                date_of_birth: date_of_birth,
                gender: gender,
                address: address,
                position_id: position_id,
                department_id: department_id,
                about: about,
            },
            success: (response) => {
                if (response.status == "error") {
                    onAlertError(response.message);
                } else {
                    onAlertSuccess("Thông tin của bạn đã được sửa đổi !");
                    $("#body_query").html(response.body);
                    unActiveform();
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});

//==========================CV===================================
// getAllCV
$(document).ready(function () {
    $("#profile-tab").on("click", function () {
        $.ajax({
            url: "/personnel/cv",
            method: "GET",
            success: function (result) {
                $("#cvut_query").html(result.cvbody);
            },
        });
    });
});
function name(params) {}
// INSERT CV
$(document).ready(function () {
    $("#form_insert_cv").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "/personnel/cv",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.status == "error") {
                    onAlertError(response.message);
                } else {
                    onAlertSuccess("Thông tin của bạn đã được sửa đổi !");
                    $("#cvut_query").html(response.cvbody);
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});

//==========================module===================================
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#img_url").attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

//Active form
$(document).on("dblclick", ".dbcl_ctl", function () {
    var id_clicked = "#" + $(this).attr("id");
    if (id_clicked == "#fullname_profile") {
        num = 0;
    } else if (id_clicked == "#department_id_profile") {
        num = 1;
    } else if (id_clicked == "#email_profile") {
        num = 2;
    } else if (id_clicked == "#phone_profile") {
        num = 3;
    } else if (id_clicked == "#date_of_birth_profile") {
        num = 4;
    } else if (id_clicked == "#gender_profile") {
        num = 5;
    } else if (id_clicked == "#address_profile") {
        num = 6;
    } else if (id_clicked == "#position_id_profile") {
        num = 7;
    } else if (id_clicked == "#about_profile") {
        num = 8;
    }
    if (dbclick[num] == true) {
        $(id_clicked).prop("disabled", true);
        dbclick[num] = false;
    } else {
        $(id_clicked).prop("disabled", false);
        dbclick[num] = true;
    }
});

function getMoresUser(page) {
    $.ajax({
        type: "GET",
        url: page,
        success: function (result) {
            $("#body_query").html(result.body);
        },
    });
}
function onAlertSuccess(text) {
    Swal.fire("Thành Công !", text, "success");
}
function ClearFromA() {
    $("#personnel_code").val("");
    $("#fullname").val("");
    $("#phone").val("");
    $("#email").val("");
    $("#password").val("");
}
function onAlertError(text) {
    Swal.fire("Thất Bại !", text, "error");
}
function unActiveform() {
    $(fullname_profile).prop("disabled", true);
    $(department_id_profile).prop("disabled", true);
    $(email_profile).prop("disabled", true);
    $(phone_profile).prop("disabled", true);
    $(date_of_birth_profile).prop("disabled", true);
    $(gender_profile).prop("disabled", true);
    $(address_profile).prop("disabled", true);
    $(position_id_profile).prop("disabled", true);
    $(about_profile).prop("disabled", true);
}

//get nominees personnel
$(document).ready(function () {
    $("#position_idu").on("change", function () {
        var stt = $("#position_idu").val();
        // alert(stt);
        $.ajax({
            type: "GET",
            url: "/personnel/nominees",
            data: {
                id: stt,
            },
            success: function (result) {
                // console.log(result);
                $("#nominee_bild").html(result.body);
            },
        });
    });
});
//get nominees cv
$(document).ready(function () {
    $("#position_cv").on("change", function () {
        var stt = $("#position_cv").val();
        // alert(stt);
        $.ajax({
            type: "GET",
            url: "/personnel/nominees",
            data: {
                id: stt,
            },
            success: function (result) {
                // console.log(result);
                $("#nominees_cv").html(result.body);
            },
        });
    });
});
