import Pagination from "./Paginate.js";

var paginate = new Pagination();

$(document).ready(function () {
    Get();
    Next();
    Previous();
    Redirect();
});

function Get() {
    let id = $('#idkho').attr('name');
    $.ajax({
        type: "get",
        url: `/warehouse/storehousedetail/${paginate.perPage}/${id}`,
        dataType: "json",
        success: function (response) {
            let html = '';
            $.each(response.data, function (index, value) {
                html += `<tr>
                            <td>${(index + 1)}</td>
                            <td><img src="${(index + 1)}"/></td>
                            <td>${value.name}</td>
                            <td>${value.out_of_date}</td>
                            <td>${value.warranty_date}</td>
                            <td>${value.amount}</td>
                            <td>${value.created_at}</td>
                            <td><button class="btn btn-primary">Thanh lí</button></td>
                        </tr>`;
            });
            $('#store-house-detail').html(html);
            paginate.lastPage = response.last_page;
            paginate.ViewPageLink(paginate.lastPage, paginate.currentPage, 'pageLink');
        }
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

