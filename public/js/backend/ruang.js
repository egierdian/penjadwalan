let table;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name=csrf-token]").val()
        }
    });
    table = $('#table-ruang').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/ruang",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'kode', name: 'kode' },
            { data: 'nama', name: 'nama' },
            { data: 'keterangan', name: 'keterangan' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
    $("#content-ruang").hide();
});

function save() {
    let kode = $('#Kode').val();
    let nama = $('#Nama').val();
    let keterangan = $('#Keterangan').val();
    let RuangID = $('[name=RuangID]').val();
    $("#btnSave").text('Menyimpan..');
    $("#btnSave").attr('disabled', true);
    if (RuangID) {
        id = RuangID;
        url = "/ruang/post/" + id;
    } else {
        id = '';
        url = "/ruang/post";
    }
    data_post = {
        _token: $("#csrf").val(),
        type: 1,
        id: id,
        kode: kode,
        nama:nama,
        keterangan: keterangan
    };
    if (nama != '' && kode != '' && keterangan != '') {
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
                $('#form-ruang')[0].reset();
                $('[name=RuangID]').val('');
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
    $('#content-ruang').show(300);
    $('#form-ruang')[0].reset();
    $('[name=RuangID]').val('');
}
function close_form() {
    $('#content-ruang').hide(300);
}
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function edit(id) {
    $.ajax({
        url: "/ruang/edit/" + id,
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
                $('#content-mapel').show(300);
                $('#Nama').val(dataResult.data.nama);
                $('#Keterangan').val(dataResult.data.keterangan);
                $('#Kode').val(dataResult.data.kode);
                $('[name=RuangID]').val(dataResult.data.id);
            }
        }
    });
}
function delete_data(id){
    $.ajax({
        url: "/ruang/delete/" + id,
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