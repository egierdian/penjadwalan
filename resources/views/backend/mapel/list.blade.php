@extends('backend.index')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mapel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Mapel</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="content-mapel" style="display: none;">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Baru Mapel</h3>
                        </div>
                        <form role="form" id="form-mapel" action="" method="POST">
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                            <input type="hidden" name="MapelID">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="Kode">Kode</label>
                                    <input type="text" class="form-control" id="Kode">
                                </div>
                                <div class="form-group">
                                    <label for="Nama">Nama</label>
                                    <input type="text" class="form-control" id="Nama">
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea class="form-control" id="Keterangan"></textarea>
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
                            <table id="table-mapel" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="30px;">No.</th>
                                        <th>Kode</th>
                                        <th>Nama Mapel</th>
                                        <th>Keterangan</th>
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