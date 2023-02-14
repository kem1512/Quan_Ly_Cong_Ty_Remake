
var fillterst;
var fillterdp;
var dbclick=0;
var emclick=0;
var phoneclick=0;
var abclick=0;
// Ajax csrf_token
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

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
                         if (result.status=="error") {
                            onAlertError(result.message);
                        }else {
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
            $("#img_url").attr("src", "./file/" + nhansu.img_url);
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
            $("#statusu").val(nhansu.status);
            $("#addressup").val(nhansu.address);
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
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "/personnel",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                onAlertSuccess("Thông tin của bạn đã được sửa đổi !");
                $("#body_query").html(response.body);
            },
            error: function (error) {
                onAlertError(error.responseJSON.message);
            },
        });
    });
});

//Search
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_url')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {
    var fullname_dbclick = $("#fullname_profile").first();
    var email_dbclick = $("#email_profile").first();
    var phone_dbclick = $("#phone_profile").first();
    var address_dbclick = $("#address_profile").first();
    var about_dbclick = $("#about_profile").first();
    fullname_dbclick.dblclick(function () {
        if (dbclick==1) { 
            $('#fullname_profile').prop('readonly', true);
            dbclick=0;
        }else if(dbclick==0){
            $('#fullname_profile').prop('readonly', false);
            dbclick=1;
        }
    });
    about_dbclick.dblclick(function () {
        if (abclick==1) { 
            $('#about_profile').prop('readonly', true);
            abclick=0;
        }else if(dbclick==0){
            $('#about_profile').prop('readonly', false);
            abclick=1;
        }
    });

    email_dbclick.dblclick(function () {
        if (emclick==1) { 
            $('#email_profile').prop('readonly', true);
            emclick=0;
        }else if(dbclick==0){
            $('#email_profile').prop('readonly', false);
            emclick=1;
        }
    });

    phone_dbclick.dblclick(function () {
        if (phoneclick==1) { 
            $('#phone_profile').prop('readonly', true);
            phoneclick=0;
        }else if(dbclick==0){
            $('#phone_profile').prop('readonly', false);
            phoneclick=1;
        }
    });

    address_dbclick.dblclick(function () {
        if (phoneclick==1) { 
            $('#address_profile').prop('readonly', true);
            phoneclick=0;
        }else if(dbclick==0){
            $('#address_profile').prop('readonly', false);
            phoneclick=1;
        }
    });
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
