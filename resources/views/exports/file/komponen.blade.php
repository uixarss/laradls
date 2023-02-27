<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_komponen as $komponen)
        <tr>
            <td>{{$komponen->kode_komponen}}</td>
            <td>{{$komponen->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>