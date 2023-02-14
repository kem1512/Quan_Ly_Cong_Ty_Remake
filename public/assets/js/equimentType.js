import Pagination from "./Paginate.js";

var pagintion = new Pagination();

var createCheck = true;
var id_equimenttype = 0;
var keyword = "";
var orderby = 'asc';

$(document).ready(function () {
    $('#btnHuy').css('display', 'none');
    GetAll();
    Previous();
    Next();
    RedirectPage()
    Submit();
    Delete();
    GetEquiment();
    Search();
    ChangeStatus();
    $('#btnHuy').on('click', function () {
        $('#btnHuy').css('display', 'none');
        createCheck = true;
        $('input[name = "name"]').val("");
    })
});

function GetAll() {
    $.ajax({
        type: "get",
        url: "/equimenttype/get/" + pagintion.perPage + "/" + orderby + "/" + keyword + "?page=" + pagintion.currentPage,
        dataType: "json",
        success: function (response) {
            let tbody = '';
            $.each(response.data, function (index, equimenttype) {
                tbody += '<tr>';
                tbody += '<td class="align-middle text-center">' + (index + 1) + '</td>';
                tbody += '<td class="align-middle text-center">' + equimenttype.name + '</td>';

                tbody += '<td class="align-middle text-center">' + equimenttype.created_at +
                    '</td>';
                tbody +=
                    '<td class="align-middle text-center"> <span class="' +
                    (equimenttype.status == 1 ?
                        'badge bg-gradient-success' :
                        'badge bg-gradient-warning'
                    ) + '">' + (equimenttype.status == 1 ? 'Sử dụng' : 'Không còn sử dụng') +
                    '</span></td>';
                tbody +=
                    '<td class="align-middle text-center"><button class="btn btn-primary btn-sm ms-auto" name="' + equimenttype.id + '" id="btnSua"><i class="fa-sharp fa-solid fa-pencil"></i></button></td>';
                tbody +=
                    '<td class="align-middle text-center"><button class="btn btn-primary btn-sm ms-auto" name="' + equimenttype.id + '" id="btnXoa"><i class="fa-sharp fa-solid fa-trash-can"></i></button></td>';
                tbody += '</tr>';
            });
            $('#list-equiment-type').html(tbody);
            pagintion.lastPage = response.last_page;
            pagintion.ViewPageLink(pagintion.lastPage, pagintion.currentPage, 'pageLink');
        }
    });
}

function Previous() {
    $('#btnPrevious').on('click', function () {
        pagintion.Previous(GetAll);
    })
}

function Next() {
    $('#btnNext').on('click', function () {
        pagintion.Next(GetAll);
    })
}

function RedirectPage() {
    $(document).on('click', '#btnRedirect', function (e) {
        let index = e.target.innerHTML;
        pagintion.Redirect(index, GetAll);
    })
}

function Submit() {
    $(document).on('submit', '#form-equiment-type', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        if (createCheck) {
            $.ajax({
                type: "post",
                url: "/equimenttype/post",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function () {
                    orderby = 'desc';
                    $('input[name = "name"]').val("");
                    Swal.fire(
                        'Good job',
                        'Thêm mới thành công',
                        'success'
                    );
                    GetAll();
                },
                error: function (err) {
                    $('#error-name').text(err.responseJSON.message);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "/equimenttype/update/" + id_equimenttype,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function () {
                    $('input[name = "name"]').val("");
                    Swal.fire(
                        'Good job',
                        'Sửa thành công',
                        'success'
                    );
                    GetAll();
                    createCheck = true;
                    $('#btnHuy').css('display', 'none');
                },
                error: function (err) {
                    $('#error-name').text(err.responseJSON.message);
                }
            });
        }
    });
}

function Delete() {
    $(document).on('click', '#btnXoa', function (e) {
        let id = e.target.name;
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
                    url: "/equimenttype/delete/" + id,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire(
                            'Good job',
                            'Xóa thành công',
                            'success'
                        );
                        GetAll();
                    }
                });
            }
        })
    })
}

function GetEquiment() {
    $(document).on('click', '#btnSua', function (e) {
        let id = e.target.name;
        $.ajax({
            type: "get",
            url: "/equimenttype/getbyid/" + id,
            dataType: "json",
            success: function (response) {
                $('input[name = "name"]').val(response[0].name);
                response[0].status == 1 ? $('#flexSwitchCheckDefault').attr('checked', true) : $('#flexSwitchCheckDefault').attr('checked', false);
                id = response[0].id;
                id_equimenttype = id;
                createCheck = false;
                $('#btnHuy').css('display', 'block');
            }
        });
    })
}

function Search() {
    $(document).on('change', '#txtTimKiem', function () {
        keyword = $('#txtTimKiem').val();
        GetAll();
    })
}

function ChangeStatus() {
    $(document).on('change', '#list_status', function () {
        keyword = $('#list_status').val();
        GetAll();
    })
}


