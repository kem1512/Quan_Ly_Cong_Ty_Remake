import Pagination from './Paginate.js';

var paginate = new Pagination();
var keyword = "";

$(document).ready(function () {
    Get();
    Redirect();
    Next();
    Previous();
    ShowModalBanGiao();
    ShowModalKiemKe();
    ShowModalThuHoi();
    filterStatus();
    Search();
});

function Get() {
    $.ajax({
        type: "get",
        url: "/equiment/get/" + paginate.perPage + "/" + paginate.currentPage + "/" + keyword,
        dataType: "json",
        success: function (response) {
            let html = '';
            for (const key in response) {
                let count = response[key].data.length;
                html += '<tr>\
                            <td rowspan="' + (count + 1) + '">' + key + '</td>\
                        </tr > ';
                $.each(response[key].data, function (index, value) {
                    html += '<tr>\
                                <td style="border-left-width: 1px;border-right-width: 1px;">'+ (value.nameusser == null ? "trống" : value.nameusser) + '</td>\
                                <td style="border-left-width: 1px;border-right-width: 1px;">'+ (value.namedepartment == null ? "trống" : value.namedepartment) + '</td>\
                                <td style="border-left-width: 1px;border-right-width: 1px;">'+ value.status + '</td>\
                                <td style="border-left-width: 1px;border-right-width: 1px;">'+ value.amount + '</td>\
                            </tr>';

                    paginate.ViewPageLink(response[key].last_page, paginate.currentPage, 'pageLink');
                });
            }
            $('#list-equiment').html(html)
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

function ShowModalBanGiao() {
    $(document).on('click', '#btnBanGiao', function () {
        $('#ModalBanGiao').modal('show');
    });
}

function ShowModalThuHoi() {
    $(document).on('click', '#btnThuHoi', function () {
        $('#ModalThuHoi').modal('show');
    });
}

function ShowModalKiemKe() {
    $(document).on('click', '#btnKiemKe', function () {
        $('#ModalKiemKe').modal('show');
    });
}

function filterStatus() {
    $('#selectstatus').on('change', function () {
        keyword = $('#selectstatus').val();
        Get();
    })
}

function Search() {
    $('#txtSearch').on('change', function () {
        keyword = $('#txtSearch').val();
        Get();
    })
}




