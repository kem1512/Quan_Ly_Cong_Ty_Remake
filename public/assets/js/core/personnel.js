var fillterst;
var fillterdp;
var num;
var accept = true;
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
                    error: function () {
                        onAlertError("Nhân sự này không thể xóa !");
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

function getMoresUser(page) {
    $.ajax({
        type: "GET",
        url: page,
        success: function (result) {
            if (result.location == "interview") {
                $("#interview_table").html(result.cvbody);
            } else if (result.location == "curriculumvitae") {
                $("#cvut_query").html(result.cvbody);
            }
            $("#body_query").html(result.body);
        },
    });
}

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
                if (result.status == "succes") {
                    onAlertSuccess("Nhân sự mới của bạn đã thêm thành công !");
                    $("#body_query").html(result.body);
                    $("#usercount").html(result.usercount);
                    $("#cvcount").html(result.cvcount);
                    ClearFromA();
                } else {
                    console.log([result.message][0]);
                    onAlertError(result);
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    }
});
function loadchucdanh(id) {
    $.ajax({
        type: "GET",
        url: "/personnel/nominees-first",
        data: {
            id: id, //id của nhân sự
        },
        success: function (result) {
            // console.log(result);
            $("#nominee_bild").html(result.body);
        },
    });
}
//GET Personnel where id
function getdetail(id) {
    loadchucdanh(id);
    $.ajax({
        url: "/personnel/edit",
        method: "GET",
        data: {
            id: id,
        },
        success: function (result) {
            var nhansu = result.data;
            console.log(nhansu);
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

            $("#nominee_bild")
                .find("option")
                .each(function () {
                    if ($(this).val() == nhansu.nominee_id) {
                        $(this).attr("selected", "");
                    } else {
                        $(this).removeAttr("selected");
                    }
                });
            $("#department_idu").val(nhansu.department_id);
            $("#personnel_codeu").val(nhansu.personnel_code);
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
    loadchucdanh(id);
    $.ajax({
        url: "/personnel/edit",
        method: "GET",
        data: {
            id: id,
        },
        success: function (result) {
            var nhansu = result.data;
            console.log(nhansu);
            if (nhansu.img_url == null) {
                nhansu.img_url = "avatar2.png";
            }
            $("#img_url").attr("src", "./img/" + nhansu.img_url);
            $("#id_user").val(nhansu.id).attr("disabled", true);
            $("#about").val(nhansu.about).attr("disabled", true);
            $("#gender").val(nhansu.gender).attr("disabled", true);
            $("#title").val(nhansu.title).attr("disabled", true);
            $("#personnel_codeu")
                .val(nhansu.personnel_code)
                .attr("disabled", true);
            $("#fullnameu").val(nhansu.fullname).attr("disabled", true);
            $("#phoneu").val(nhansu.phone).attr("disabled", true);
            $("#emailu").val(nhansu.email).attr("disabled", true);
            $("#passwordu").val(nhansu.password).attr("disabled", true);

            $("#nominee_bild")
                .find("option")
                .each(function () {
                    if ($(this).val() == nhansu.nominee_id) {
                        $(this).attr("selected", "");
                    } else {
                        $(this).removeAttr("selected");
                    }
                });
            $("#nominee_bild").attr("disabled", true);
            $("#department_idu")
                .val(nhansu.department_id)
                .attr("disabled", true);
            $("#personnel_codeu")
                .val(nhansu.personnel_code)
                .attr("disabled", true);
            $("#date_of_birthu")
                .val(nhansu.date_of_birth)
                .attr("disabled", true);
            $("#position_idu").val(nhansu.position_id).attr("disabled", true);
            $("#recruitment_dateu")
                .val(nhansu.recruitment_date)
                .attr("disabled", true);
            if ((nhansu.status == 3) | (nhansu.status == 4)) {
                $("#about-text").html("Lý Do:");
            } else {
                $("#about-text").html("Giới thiệu về bản thân :");
            }
            $("#statusu").val(nhansu.status).attr("disabled", true);
            $("#addressup").val(nhansu.address).attr("disabled", true);
            $("#img_url_update").attr("disabled", true);
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
        fillterst = $("#status_select").val();
        fillterdp = $("#department_select").val();
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
        fillterst = $("#status_select").val();
        fillterdp = $("#department_select").val();

        $.ajax({
            url: "/personnel/fillter",
            method: "GET",
            data: {
                status_filter: fillterst,
                department_filter: fillterdp,
            },
            success: function (result) {
                console.log(result);
                $("#body_query").html(result.body);
            },
        });
    });
});

//edit level
$(document).on("change", ".read-checkbox-level", function () {
    var id = $(this).attr("user-data-src");
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
function setnull_insert_PV() {
    $("#interview_date").val("");
    $("interviewer1").val("");
    $("interviewer2").val("");
    $("interviewer_date").val("");
    $("interviewer_time").val("");
}
//INSERT PV
$(document).ready(function () {
    $("#submit_insert_interview").on("submit", function (e) {
        let timerInterval;
        Swal.fire({
            title: "Vui lòng đợi trong giây lát !",
            html: "Chúng tôi đang gửi lời mời đến ứng viên !",
            timer: 30000,
            timerProgressBar: false,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector("b");
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log("I was closed by the timer");
            }
        });
        e.preventDefault();
        var interviewer1 = $("#interviewer1").attr("code");
        var interviewer2 = $("#interviewer2").attr("code");
        var interview_date = $("#interview_date").val();
        var interview_time = $("#interview_time").val();
        var cate_inter = $("#cate_inter").val();
        var id_cv = $("#btn-interview-in-table").attr("code");
        var location = $("#interview_location").val();
        $.ajax({
            type: "POST",
            url: "/personnel/interview",
            data: {
                id_cv: id_cv,
                interviewer1: interviewer1,
                interviewer2: interviewer2,
                interview_date: interview_date,
                interview_time: interview_time,
                cate_inter: cate_inter,
                location: location,
            },
            success: (response) => {
                if (response.status == "error") {
                    onAlertError(response.message);
                } else {
                    onAlertSuccess(response.message);
                    setnull_insert_PV();
                    getallCV();
                    $("#body_query").html(response.body);
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});
// auto find interviewer1
$("#interviewer1").autocomplete({
    source: function (request, response) {
        // Fetch data
        $.ajax({
            url: "/personnel/search-interviewer",
            type: "post",
            dataType: "json",
            data: {
                search: request.term,
            },
            success: function (data) {
                response(data);
            },
        });
    },
    select: function (event, ui) {
        // Set selection
        $("#interviewer1").attr("code", ui.item.value); // display the selected text
        $("#interviewer1").val(ui.item.label);
        console.log(ui);
        return false;
    },
});
// auto find interviewer2
$("#interviewer2").autocomplete({
    source: function (request, response) {
        // Fetch data
        $.ajax({
            url: "/personnel/search-interviewer",
            type: "post",
            dataType: "json",
            data: {
                search: request.term,
            },
            success: function (data) {
                response(data);
            },
        });
    },
    select: function (event, ui) {
        // Set selection
        $("#interviewer2").attr("code", ui.item.value); // display the selected text
        $("#interviewer2").val(ui.item.label);
        // console.log(ui);
        return false;
    },
});
//Search CV
$(document).ready(function () {
    $("#customRange3").on("change", function () {
        var point = $(this).val();
        console.log(point);
    });
});
//Search CV
$(document).ready(function () {
    $("#search_cv").keyup(function () {
        var search = $("#search_cv").val();
        $.ajax({
            url: "/personnel/search-cv",
            method: "GET",
            data: {
                search: search,
            },
            success: function (result) {
                $("#cvut_query").html(result.cvbody);
            },
        });
    });
});
//Fillter CV
$(document).ready(function () {
    $("#status_select_cv").on("change", function () {
        var status = $(this).val();
        $.ajax({
            url: "/personnel/fillter-cv",
            method: "GET",
            data: {
                status: status,
            },
            success: function (result) {
                $("#cvut_query").html(result.cvbody);
            },
        });
    });
});
//get all cv
function getallInter() {
    $.ajax({
        url: "/personnel/interview",
        method: "GET",
        success: function (result) {
            $("#interview_table").html(result.cvbody);
        },
    });
}
getallInter();
function getallCV() {
    $.ajax({
        url: "/personnel/cv",
        method: "GET",
        success: function (result) {
            $("#cvut_query").html(result.cvbody);
        },
    });
}
getallCV();
// getAllCV
$(document).ready(function () {
    $("#profile-tab").on("click", function () {
        getallCV();
    });
});
// getAllCV
$(document).ready(function () {
    $("#cate_inter").on("change", function () {
        var value = $(this).val();
        if (value == 1) {
            $("#location-text").html("Địa Chỉ :");
        } else {
            $("#location-text").html("Đường Dẫn :");
        }
    });
});

//UPDATE
$(document).ready(function () {
    $("#form_update_cv").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type: "POST",
            url: "/personnel/cv-u",
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
//duyệt hồ sơ
$(document).ready(function () {
    // openLoading();
    $(".accept_cv").on("click", function () {
        var status = $(this).attr("data");
        var id = $(this).attr("code");
        var note = $("#note").val();
        if (status == 1) {
            let timerInterval;
            Swal.fire({
                title: "Vui lòng đợi trong giây lát !",
                html: "Chúng tôi đang gửi thông báo đến ứng viên !",
                timer: 30000,
                timerProgressBar: false,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector("b");
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        }
        $.ajax({
            url: "/personnel/cv-id",
            method: "POST",
            data: {
                id: id,
                status: status,
                note: note,
            },
            success: function (result) {
                if (result.status == "succes") {
                    // closeLoading();
                    onAlertSuccess(result.message);
                    getallCV();
                } else {
                    // closeLoading();
                    onAlertError(result.message);
                }
            },
            error: function (result) {
                console.log(result);
                // closeLoading();
                onAlertError(result.responseJSON.message);
            },
        });
    });
});

function closeNote() {
    $("#note_cv").removeClass("d-block");
    $("#note_cv").addClass("d-none");
}

function openNote() {
    $("#note_cv").removeClass("d-none");
    $("#note_cv").addClass("d-block");
}
// $(document).ready(function () {
//     $("#note").focusout(function () {
//         setTimeout(function () {
//             closeNote();
//         }, 3000);
//     });
// });
function close2form() {
    closeNote();
}
function loadchucdanhUV(id) {
    $.ajax({
        type: "GET",
        url: "/personnel/nominees-cv",
        data: {
            id: id, //id của CV
        },
        success: function (result) {
            // console.log(result);
            $("#nominees_ut_update").html(result.body);
        },
    });
}

// get cv bi id edit
function get_CV_By_ID_edit(id) {
    loadchucdanhUV(id);
    $.ajax({
        url: "/personnel/cv-u",
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            var cv = response.body;
            $("#name_ut_update").val(cv.name);
            $("#email_ut_update").val(cv.email);
            $("#phone_ut_update").val(cv.phone);
            $("#date_of_birth_ut_update").val(cv.date_of_birth);
            $("#gender_ut_update").val(cv.gender);
            $("#position_ut_update").val(cv.position_id);
            $("#cv_ut_update").val(cv.position);
            $("#nominees_ut_update")
                .find("option")
                .each(function () {
                    if ($(this).val() == cv.nominee) {
                        $(this).attr("selected", "");
                    } else {
                        $(this).removeAttr("selected");
                    }
                });

            $("#address_ut_update").val(cv.address);
            $("#id_ut_update").val(cv.id);
        },
    });
}
// get cv bi id
function get_CV_By_ID_eva(id) {
    close2form();
    $.ajax({
        url: "/personnel/cv-id",
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            var cv = response.body[0];
            $("#name_eva").val(cv.name);
            $("#email_eva").val(cv.email);
            $("#phone_eva").val(cv.phone);
            $("#date_of_birth_eva").val(cv.date_of_birth);
            $("#gender_eva").val(cv.gender);
            $("#position_eva").val(cv.position);
            $("#nominees_eva").val(cv.nominees);
            $("#address_eva").val(cv.address);
            $("#accept_cv").attr("code", cv.id);
            $("#send_cv").attr("code", cv.id);
            $("#cv_url").attr(
                "src",
                "cv/" + cv.url_cv + "#toolbar=0&navpanes=0&scrollbar=0"
            );
        },
    });
}
function setnull_insert_CV() {
    $("#name_ut").val("");
    $("#email_ut").val("");
    $("#phone_ut").val("");
    $("#date_of_birth_ut").val("");
    $("#cv_ut").val("");
    $("#position_cv").val("");
    $("#nominees_cv").val("");
    $("#about_cv").val("");
}
function load() {
    let timerInterval;
    Swal.fire({
        title: "Auto close alert!",
        html: "I will close in <b></b> milliseconds.",
        timer: 5000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector("b");
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        },
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log("I was closed by the timer");
        }
    });
}
// INSERT CV
$(document).ready(function () {
    $("#form_insert_cv").on("submit", function (e) {
        // openLoading();
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/personnel/cv",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.status == "error") {
                    console.log(response);
                    onAlertError(response.message);
                } else {
                    // closeLoading();
                    onAlertSuccess("Hồ sơ đã được thêm mới !");
                    setnull_insert_CV();
                    console.log(response.cvbody);
                    $("#cvut_query").html(response.cvbody);
                }
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});
// update CV
$(document).ready(function () {
    $("#form_update_cvut").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/personnel/cv-update",
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
    $("#position_ut_update").on("change", function () {
        var stt = $("#position_ut_update").val();
        // alert(stt);
        $.ajax({
            type: "GET",
            url: "/personnel/nominees",
            data: {
                id: stt,
            },
            success: function (result) {
                // console.log(result);
                $("#nominees_ut_update").html(result.body);
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

function openLoading() {
    console.log("run");
    $("#loading").removeClass("hide_loading");
    $("#loading").addClass("avtice_loading");
    $("#id_body").addClass("active_body");
}
function closeLoading() {
    $("#loading").removeClass("avtice_loading");
    $("#id_body").removeClass("active_body");
    $("#loading").addClass("hide_loading");
}
