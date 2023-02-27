@component('mail::message')
# Disposisi Surat Masuk

Surat masuk perlu ditindak lanjuti.
Ringkasan: {{$isi_ringkas}}.
Dari: {{$nama_pengirim}}.
Tanggal Surat: {{\Carbon\Carbon::parse($tanggal_surat)->format('d M Y')}}.

@component('mail::button', ['url' => $url])
Lihat Surat Masuk 
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent