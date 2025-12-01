<div class="row">
    <div class="col-md-6">
        <label>Nama Responden</label>
        <input type="text" name="nama_responden" class="form-control"
            value="{{ $item->nama_responden ?? old('nama_responden') }}">
    </div>

    <div class="col-md-6">
        <label>Provinsi</label>
        <input type="text" name="provinsi" class="form-control"
            value="{{ $item->provinsi ?? old('provinsi') }}">
    </div>

    <div class="col-md-6">
        <label>Kabupaten</label>
        <input type="text" name="kabupaten" class="form-control"
            value="{{ $item->kabupaten ?? old('kabupaten') }}">
    </div>

    <div class="col-md-6">
        <label>Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control"
            value="{{ $item->kecamatan ?? old('kecamatan') }}">
    </div>

    <div class="col-md-6">
        <label>Desa</label>
        <input type="text" name="desa" class="form-control"
            value="{{ $item->desa ?? old('desa') }}">
    </div>

    <div class="col-md-6">
        <label>Status Responden</label>
        <input type="text" name="status_responden" class="form-control"
            value="{{ $item->status_responden ?? old('status_responden') }}">
    </div>

    <div class="col-md-6">
        <label>Jenis Program</label>
        <input type="text" name="jenis_program" class="form-control"
            value="{{ $item->jenis_program ?? old('jenis_program') }}">
    </div>
</div>