import Pagination from "./Paginate.js";

var paginate = new Pagination();
var orderby = "asc";
var keyword = "";
var title = "Thêm mới kho";
var create = true;
var id_warehouse = 0;

$(document).ready(function () {
    $("#title").text(title);
    Get();
    Redirect();
    Next();
    Previous();
    Delete();
    Update();
    Submit();
    ChangeImage();
    ShowModal();
    CancelUpdate();
    Search();
    cancelValidate();
    ShowModalNhapKHo();
    createequipment();
});

function Get() {
    paginate.perPage = 6;
    $.ajax({
        type: "get",
        url:
            "/warehouse/get/" +
            paginate.perPage +
            "/" +
            orderby +
            "/" +
            keyword +
            "?page=" +
            paginate.currentPage,
        dataType: "json",
        success: function (response) {
            let html = "";
            $.each(response.warehouses.data, function (index, value) {
                html += '<div class="col-sm-3 card px-0 m-5 border">'
                html += '<div class="card-header"><h5 id="tenkho" class="text-primary">Kho : ' + value.name + "</h5></div>"
                html += '<div class="card-body">'
                html += '<img class="img-fluid border border-primary" style="width: 200px;height: 200px;" src="' + value.image + '"/>'
                html += '</div>'
                html += '<div class="card-footer">'
                html += '<div class="justify-content-center">'
                html += '<button class="btn bg-gradient-primary btn-sm mx-2" id="btnSua" name="' + value.id + '"><i class="fa-solid fa-pen"></i></button>'
                html += `<a class="btn btn-primary btn-sm" href="/warehouse/viewstorehousedetail/${value.id}/${value.name}"><i class="fa-sharp fa-solid fa-eye"></i></a>`
                html += '<button class="btn bg-gradient-danger btn-sm mx-2" id="btnXoa" name="' + value.id + '"><i class="fa-solid fa-trash-can"></i></button>'
                html += '</div>'
                html += '</div>'
                html += '</div>'
            });
            $("#table-warehouse").html(html);
            paginate.lastPage = response.warehouses.last_page;
            paginate.ViewPageLink(
                paginate.lastPage,
                paginate.currentPage,
                "pageLink"
            );
        },
    });
}

function Next() {
    $(document).on("click", "#btnNext", function () {
        paginate.Next(Get);
    });
}

function Previous() {
    $(document).on("click", "#btnPrevious", function () {
        paginate.Previous(Get);
    });
}

function Redirect() {
    $(document).on("click", "#btnRedirect", function (e) {
        let index = e.target.innerHTML;
        paginate.Redirect(index, Get);
    });
}

function Delete() {
    $(document).on("click", "#btnXoa", function (e) {
        let id = $(this).attr("name");
        Swal.fire({
            title: "Bạn có chắc muốn xóa?",
            text: "",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Không",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "/warehouse/delete/" + id,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire("Good job", response.message, "success");
                        Get();
                    },
                });
            }
        });
    });
}

function Update() {
    $(document).on("click", "#btnSua", function () {
        let id = $(this).attr("name");
        $.ajax({
            type: "get",
            url: "/warehouse/getbyid/" + id,
            dataType: "json",
            success: function (response) {
                $("#exampleModalSignUp").modal("show");
                $('input[name = "name"]').val(response.warehouse.name);
                $('input[name = "address"]').val(response.warehouse.address);
                $("#image-kho").attr("src", response.warehouse.image);
                $("#image-kho").css('display', 'block');
                $("#flexSwitchCheckDefault").val(
                    response.warehouse.status == 1 ? "on" : null
                );
                id_warehouse = response.warehouse.id;
                create = false;
                title = "Sửa Kho";
                $("#title").text(title);
            },
        });
    });
}

function Submit() {
    $(document).on("submit", "#formKho", function (e) {
        e.preventDefault();
        var data = new FormData(this);
        if (create) {
            $.ajax({
                type: "post",
                url: "/warehouse/post",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function () {
                    orderby = "desc";
                    $("#formKho")[0].reset();
                    $("#exampleModalSignUp").modal("hide");
                    $("#image-kho").attr("src", "");
                    Swal.fire("Good job", "Thêm mới thành công", "success");
                    Get();
                },
                error: function (err) {
                    for (const key in err.responseJSON.errors) {
                        $('#error-' + key).text(err.responseJSON.errors[key]);
                    }
                },
            });
        } else {
            $.ajax({
                type: "post",
                url: "/warehouse/update/" + id_warehouse,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);
                    $("#formKho")[0].reset();
                    $("#exampleModalSignUp").modal("hide");
                    $("#image-kho").attr("src", "");
                    Swal.fire("Good job", "Sửa thành công", "success");
                    Get();
                    create = true;
                    var title = "Thêm mới kho";
                    $("#title").text(title);
                },
                error: function (err) {
                    for (const key in err.responseJSON.errors) {
                        $('#error-' + key).text(err.responseJSON.errors[key]);
                    }
                },
            });
        }
    });
}

function ChangeImage() {
    $(document).on("change", "#image", function (e) {
        var file = e.target.files[0];
        var Reader = new FileReader();
        Reader.readAsDataURL(file);
        Reader.onload = function () {
            var url = Reader.result;
            $("#image-kho").attr("src", url);
            $("#image-kho").css("display", "block");
        };
    });
}

function ShowModal() {
    $(document).on("click", "#btnThem", function () {
        $("#exampleModalSignUp").modal("show");
        $("#image-kho").css("display", "none");
        var title = "Thêm mới kho";
        $("#title").text(title);
    });
}

function CancelUpdate() {
    $(document).on("click", "#btnHuy", function () {
        $("#formKho")[0].reset();
        $("#exampleModalSignUp").modal("hide");
        $("#image-kho").attr("src", "");
        create = true;
    });
}

function Search() {
    $(document).on("change", "#txtSearch", function () {
        keyword = $(this).val();
        Get();
    });
}

function cancelValidate() {
    $('#formKho').each(function () {
        let elements = $(this).find(':input');
        for (const element of elements) {
            let name = element['name'];
            $('input[name="' + name + '"]').on('input', function () {
                if ($('input[name="' + name + '"]').val().trim().length != 0) {
                    $('#error-' + name).text("");
                }
            })
        }
    })
}

function ShowModalNhapKHo() {
    $('#btnNhapKho').on('click', function () {
        $('#exampleModalNhaKho').modal('show');
    })
}

function createequipment() {
    $(document).on('submit', '#form-equiment', function (e) {
        e.preventDefault();
        let data = new FormData(this);
        $.ajax({
            type: "post",
            url: "/warehouse/createequipment",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                let id_storehouse = data.get('storehouse_id');
                let equipment_id = response.equipment.id;
                let amount = data.get('amount');
                createstorehousedetail(id_storehouse, equipment_id, amount);
            },
            error: function (err) {
                for (const key in err.responseJSON.errors) {
                    $(`#${key}-error`).text(err.responseJSON.errors[key]);
                }
            }
        });
    })
}

function createstorehousedetail(storehouse_id, equipment_id, amount) {
    $.ajax({
        type: "post",
        url: "/warehouse/createstorehousedetail",
        data: {
            storehouse_id: storehouse_id,
            equipment_id: equipment_id,
            amount: amount,
        },
        dataType: "json",
        success: function (response) {
            $("#form-equiment")[0].reset();
            $("#exampleModalNhaKho").modal("hide");
            Swal.fire("Good job", "Thêm mới thành công", "success");
        }
    });
}

