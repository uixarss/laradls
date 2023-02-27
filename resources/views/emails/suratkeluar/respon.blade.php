@component('mail::message')
# Surat Keluar {{$nomor_surat}}

Progres surat keluar {{$status}}. Anda mendapat pesan dari Bapak/Ibu {{$nama_pengirim}} dengan catatan {{$isi_catatan}}.

@component('mail::button', ['url' => $url])
Lihat Surat Keluar
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
