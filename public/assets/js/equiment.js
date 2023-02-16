import Pagination from './Paginate.js';

var paginate = new Pagination();
var orderby = 'asc';
var keyword = "";
var title = "Thêm mới thiết bị";
var create = true;
var id_warehouse = 0;

$(document).ready(function () {
    Get();
    Redirect();
    Next();
    Previous();
    ShowModalThem();
    ShowModalExcel();
    submit();
    ImportExcel();
});

function Get() {
    paginate.perPage = 2;
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
                                <td class="align-middle text-center" style="border-right-width: 1px;"><button class="btn btn-primary">Sửa</button></td>\
                                <td class="align-middle text-center" style="border-right-width: 1px;"><button class="btn btn-primary">Xóa</button></td>\
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
    })
}

function ShowModalExcel() {
    $(document).on('click', '#btnThemExcel', function () {
        $('#modalExcel').modal('show');
    })
}

function submit() {
    $(document).on('submit', '#form-equiment', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: "post",
            url: "/equiment/post",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
            },
            error: function (err) {

            }
        });
    });
}

function ImportExcel() {
    $(document).on('submit', '#form-excel', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            type: "post",
            url: "/equiment/importexcel",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
            },
            error: function (err) {

            }
        });
    })
}



