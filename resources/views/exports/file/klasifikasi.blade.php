<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_klasifikasi as $klasifikasi)
        <tr>
            <td>{{$klasifikasi->kode_klasifikasi}}</td>
            <td>{{$klasifikasi->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>