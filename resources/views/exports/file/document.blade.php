<table>
    <thead>
        <tr>
            <th>
                Nomor Berkas
            </th>
            <th>Kode Klasifikasi</th>
            <th>Uraian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_document as $document)
            <tr>
                <td>
                    {{ $document->nomor_berkas }}
                </td>
                <td>{{ $document->kode_klasifikasi }}</td>
                <td>{{ $document->title }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
