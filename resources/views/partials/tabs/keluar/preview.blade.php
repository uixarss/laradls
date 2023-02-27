<div class="card mb-5 mb-lg-10">
    <form action="{{ route('suratkeluar.preview', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <div class="card-title">
                <h3>Preview</h3>
            </div>
            <div class="card-toolbar">

            </div>
        </div>
        <div class="card-body">
            <label for="" class="form-label required ">Pilih Template</label>
            <small>(wajib dipilih)</small>
            <select name="id_template" id="" class="form-control" data-control="select2" required>
                <option value="" aria-readonly="true">-- Pilih Template Surat --</option>
                @foreach ($data_template as $template)
                <option value="{{ $template->id }}">
                {{ $template->kode }} - {{ $template->name }}
                </option>
                @endforeach

            </select>
            <label class="form-label required">Nama File</label>
            <small>(format file dalam bentuk doc)</small>
            <input type="text" class="form-control" name="name" value="Surat Keluar Nomor {{$suratKeluar->nomor_surat}} " required>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Preview</button>
            </div>
        </div>
    </form>
</div>