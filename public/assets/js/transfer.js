var id_users = 0;


$(document).ready(function () {
    changtype();
    ChonBenChuyen();
    ChonBenNhan();
    Chon();
});

function changtype() {
    $('#changtype').on('change', function () {
        $('#changtype').val() == "hand-over" ? $('#divchuyen').css('display', 'block') : $('#divchuyen').css('display', 'none');
    });
}

function ChonBenChuyen() {
    $('#btnBenChuyen').on('click', function () {
        $('#exampleModal').modal('show');
        $('#exampleModalLabel').text('Chọn bên chuyển');

        let url = id_users == 0 ? '/transfer/getnhansu' : '/transfer/getnhansu' + id_users;

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response);
                let html = '';
                $.each(response.users, function (index, value) {
                    html += '<tr>\
                                <td>'+ value.img_url + '</td>\
                                <td>'+ value.fullname + '</td>\
                                <td><button id="btnChon" name="'+ value.id + '" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>\
                            </tr>';
                });
                $('#chooseuser').html(html);
            }
        });
    })
}

function ChonBenNhan() {
    $('#btnBenNhan').on('click', function () {
        $('#exampleModal').modal('show');
        $('#exampleModalLabel').text('Chọn bên nhận');

        $('#btnBenChuyen').on('click', function () {
            $('#exampleModal').modal('show');
            $('#exampleModalLabel').text('Chọn bên chuyển');

            let url = id_users == 0 ? '/transfer/getnhansu' : '/transfer/getnhansu' + id_users;

            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    let html = '';
                    $.each(response.users, function (index, value) {
                        html += '<tr>\
                                    <td>'+ value.img_url + '</td>\
                                    <td>'+ value.fullname + '</td>\
                                    <td><button id="btnChon" name="'+ value.id + '" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>\
                                </tr>';
                    });
                    $('#chooseuser').html(html);
                }
            });
        })
    })
}
