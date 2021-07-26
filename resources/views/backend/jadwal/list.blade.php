@extends('backend.index')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Jadwal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Jadwal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="content-jadwal" style="display: none;">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Baru Jadwal</h3>
                        </div>
                        <form role="form" id="form-jadwal" action="" method="POST">
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                            <input type="hidden" name="JadwalID">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="MapelID">Mapel</label>
                                    <select id="MapelID" class="form-control">
                                        <option value="none">- Pilih Mapel -</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="DosenID">Dosen</label>
                                    <select id="DosenID" class="form-control">
                                        <option value="none">- Pilih Dosen -</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="RuangID">Ruang</label>
                                    <select id="RuangID" class="form-control">
                                        <option value="none">- Pilih Ruang -</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Hari">Hari</label>
                                    <input type="text" class="form-control" id="Hari" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label for="Mulai">Mulai</label>
                                    <input type="time" class="form-control" id="Mulai" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label for="Selesai">Selesai</label>
                                    <input type="time" class="form-control" id="Selesai" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label for="Status">Status</label>
                                    <input type="text" class="form-control" id="Status" maxlength="100">
                                </div>
                            </div>
                            <div class="card-footer justify-content-end">
                                <button id="btnSave" type="button" class="btn btn-primary" onclick="save()">Simpan</button>
                                <button id="btnClose" type="button" class="btn btn-danger" onclick="close_form()">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <button type="button" class="btn btn-primary" onclick="add()">Tambah Baru</button>

                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table-jadwal" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="30px;">No.</th>
                                        <th>Hari</th>
                                        <th>Mapel</th>
                                        <th>Dosen</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Ruang</th>
                                        <th>Status</th>
                                        <th width="150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection