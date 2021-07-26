let table;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name=csrf-token]").val()
        }
    });
    table = $('#table-dosen').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/dosen",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama', name: 'nama' },
            { data: 'alamat', name: 'alamat' },
            { data: 'telp', name: 'telp' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
    $("#content-dosen").hide();
});

function save() {
    let nama = $('#Nama').val();
    let alamat = $('#Alamat').val();
    let telp = $('#Telp').val();
    let DosenID = $('[name=DosenID]').val();
    $("#btnSave").text('Menyimpan..');
    $("#btnSave").attr('disabled', true);
    if (DosenID) {
        id = DosenID;
        url = "/dosen/post/" + id;
    } else {
        id = '';
        url = "/dosen/post";
    }
    data_post = {
        _token: $("#csrf").val(),
        type: 1,
        id: id,
        nama:nama,
        alamat: alamat,
        telp: telp
    };
    if (nama != '' && alamat != '' && telp != '') {
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
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                $('#form-dosen')[0].reset();
                $('[name=DosenID]').val('');
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
    $('#content-dosen').show(300);
    $('#form-dosen')[0].reset();
    $('[name=DosenID]').val('');
}
function close_form() {
    $('#content-dosen').hide(300);
}
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function edit(id) {
    $.ajax({
        url: "/dosen/edit/" + id,
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            type: 1,
            id: id,
        },
        success: function (res) {
            console.log(res);
            var dataResult = JSON.parse(res);
            if (dataResult.status) {
                $('#content-dosen').show(300);
                $('#Nama').val(dataResult.data.nama);
                $('#Alamat').val(dataResult.data.alamat);
                $('#Telp').val(dataResult.data.telp);
                $('[name=DosenID]').val(dataResult.data.id);
            }
        }
    });
}
function delete_data(id){
    $.ajax({
        url: "/dosen/delete/" + id,
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
                );
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