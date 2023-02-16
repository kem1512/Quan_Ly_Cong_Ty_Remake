import Pagination from './Paginate.js';

var paginate = new Pagination();
var orderby = 'asc';
var keyword = "";
var title = "Thêm mới thiết bị";
var create = true;
var id_equipments = 0;

$(document).ready(function () {
    Get();
    Redirect();
    Next();
    Previous();
    ShowModalThem();
    submit();
    cancelValidate();
    GetStatus();
    CancelModalThem();
    GetById();
    Delete();
});

function Get() {
    $.ajax({
        type: "get",
        url: "/equiment/get/" + paginate.perPage + "/" + paginate.currentPage + "/" + keyword,
        dataType: "json",
        success: function (response) {
            let html = '';
            for (const key in response) {
                html += '<tr>\
                            <td rowspan="'+ (response[key].data.length + 1) + '">' + key + '</td>\
                        </tr>';
                $.each(response[key].data, function (index, value) {
                    html += '<tr>\
                                <td class="align-middle text-center w-25"><img class="w-25" src="/uploads/'+ value.image + '"/></td>\
                                <td class="align-middle text-center" style="border-left-width: 1px;border-right-width: 1px;">'+ value.name + '</td>\
                                <td class="align-middle text-center" style="border-right-width: 1px;"><span class="badge bg-gradient-success">'+ (value.status == 'active' ? 'Hoạt động' : value.status == 'inactive' ? 'Không hoạt động' : 'Đang hỏng') + '</span></td>\
                                <td class="align-middle text-center" style="border-right-width: 1px;"><button id="btnSua" name="'+ value.id + '" class="btn btn-primary">Sửa</button></td>\
                                <td class="align-middle text-center" style="border-right-width: 1px;"><button id="btnXoa" name="'+ value.id + '" class="btn btn-primary">Xóa</button></td>\
                            </tr>';
                });
            }
            $('#list-equiment').html(html)
            paginate.lastPage = response.last_page;
            paginate.ViewPageLink(paginate.lastPage, paginate.currentPage, 'pageLink');
        }
    });
}

function Previous() {
    $(document).on('click', '#btnPrevious', function () {
        paginate.Previous(Get);
    });
}

function Next() {
    $(document).on('click', '#btnNext', function () {
        paginate.Next(Get);
    });
}

function Redirect() {
    $(document).on('click', '#btnRedirect', function (e) {
        let index = e.target.innerHTML;
        paginate.Redirect(index, Get);
    })
}

function ShowModalThem() {
    $(document).on('click', '#btnThem', function () {
        $('#modalThem').modal('show');
        $('#exampleModalLabel').text(title)
    })
}

function submit() {
    $(document).on('submit', '#form-equiment', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        if (create) {
            $.ajax({
                type: "post",
                url: "/equiment/post",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (res) {
                    // Swal.fire(
                    //     'Good job',
                    //     'Thêm thành công',
                    //     'success'
                    // );
                    // Get();
                    // $("#form-equiment")[0].reset();
                    // $("#modalThem").modal("hide");
                },
                error: function (err) {
                    for (const key in err.responseJSON.errors) {
                        $('#' + key + '-error').text(err.responseJSON.errors[key]);
                    }
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "/equiment/update/" + id_equipments,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function () {
                    Swal.fire(
                        'Good job',
                        'Sửa thành công',
                        'success'
                    );
                    Get();
                    $("#form-equiment")[0].reset();
                    $("#modalThem").modal("hide");
                    create = true;
                },
                error: function (err) {
                    for (const key in err.responseJSON.errors) {
                        $('#' + key + '-error').text(err.responseJSON.errors[key]);
                    }
                }
            });
        }
    });
}

function cancelValidate() {
    $('#form-equiment').each(function () {
        let elements = $(this).find(':input');
        for (const element of elements) {
            let name = element['name'];
            $('input[name="' + name + '"]').on('input', function () {
                if ($('input[name="' + name + '"]').val().trim().length != 0) {
                    $('#' + name + "-error").text("");
                }
            })
        }
    })
}

function GetStatus() {
    $('#selectstatus').on('change', function () {
        keyword = $('#selectstatus').val();
        Get();
    })
}

function CancelModalThem() {
    $('#btnHuy').on('click', function () {
        $("#form-equiment")[0].reset();
        $("#modalThem").modal("hide");
        create = true;
    })
}

function GetById() {
    $(document).on('click', '#btnSua', function () {
        let id = $(this).attr('name');

        $.ajax({
            type: "get",
            url: "/equiment/getbyid/" + id,
            dataType: "json",
            success: function (response) {
                $('#form-equiment').each(function () {
                    let elements = $(this).find(':input');
                    for (const element of elements) {
                        let name = element['name'];
                        $('input[name="' + name + '"]').val(response.equipment['' + name + '']);
                    }
                })
                $('#specifications').val(response.equipment['specifications']);
                $('#modalThem').modal('show');
                create = false;
                id_equipments = response.equipment['id'];
                title = "Sửa thiết bị"
                $('#exampleModalLabel').text(title)
            }
        });
    })
}

function Delete() {
    $(document).on('click', '#btnXoa', function () {
        let id = $(this).attr('name');
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            text: "",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "/equiment/delete/" + id,
                    dataType: "json",
                    success: function () {
                        Swal.fire(
                            'Good job',
                            'Xóa thành công',
                            'success'
                        );
                        Get();
                    }
                });
            }
        })
    })
}



