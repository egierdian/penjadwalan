let table;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name=csrf-token]").val()
        }
    });
    table = $('#table-user').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/user",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
    $("#content-user").hide();
});

function save() {
    let name = $('#Name').val();
    let email = $('#Email').val();
    let password = $('#Password').val();
    let UserID = $('[name=UserID]').val();
    $("#btnSave").text('Saving..');
    $("#btnSave").attr('disabled', true);
    if (UserID) {
        id = UserID;
        url = "/user/post/" + id;
    } else {
        id = '';
        url = "/user/post";
    }
    data_post = {
        _token: $("#csrf").val(),
        type: 1,
        id: id,
        name: name,
        email:email,
        password: password,
    };
    if (name != '' && email != '' && password != '') {
        $.ajax({
            url: url,
            type: "POST",
            data: data_post,
            cache: false,
            success: function (res) {
                var dataResult = JSON.parse(res);
                console.log(dataResult);
                if (dataResult.status) {
                    Swal.fire(
                        'Success',
                        dataResult.message,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Error',
                        'error'
                    );
                }
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                $('#form-user')[0].reset();
                $('[name=UserID]').val('');
                reload_table();
            }
        });
    }
    else {
        Swal.fire(
            'Info',
            'Please fill all the field !',
            'info'
        );
        $("#btnSave").text('Save');
        $("#btnSave").attr('disabled', false);
    }
};

function add() {
    $('#content-user').show(300);
    $('#form-user')[0].reset();
    $('[name=UserID]').val('');
}
function close_form() {
    $('#content-user').hide(300);
}
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function edit(id) {
    $.ajax({
        url: "/user/edit/" + id,
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            type: 1,
            id: id,
        },
        success: function (res) {
            console.log(res);
            var dataResult = JSON.parse(res);
            console.log(dataResult);
            if (dataResult.status) {
                $('#content-user').show(300);
                $('#Name').val(dataResult.data.name);
                $('#Email').val(dataResult.data.email);
                $('#Password').val(dataResult.data.password);
                $('[name=UserID]').val(dataResult.data.id);
                console.log(dataResult.data.id);
            }
        }
    });
}
function delete_data(id){
    $.ajax({
        url: "/user/delete/" + id,
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            type: 1,
            id: id,
        },
        success: function (res) {
            var dataResult = JSON.parse(res);
            console.log(res);
            if (dataResult.status) {
                Swal.fire(
                    'Success',
                    dataResult.message,
                    'success'
                );;
                reload_table();
            } else {
                Swal.fire(
                    'Error',
                    'Error',
                    'error'
                );
            }
        }
    });
}