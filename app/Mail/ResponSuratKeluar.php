<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponSuratKeluar extends Mailable
{
    use Queueable, SerializesModels;

    public $status, $nomor_surat, $nama_pengirim, $isi_catatan, $uuid;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nomor_surat, $status, $nama_pengirim, $isi_catatan, $uuid)
    {
        $this->nomor_surat = $nomor_surat;
        $this->status = $status;
        $this->nama_pengirim = $nama_pengirim;
        $this->isi_catatan = $isi_catatan;
        $this->uuid = $uuid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.suratkeluar.respon')
            ->subject('[DMS] Ada Pesan Surat Keluar dari ' . $this->nama_pengirim)
            ->with([
                'url' => route('suratkeluar.show', $this->uuid),
                'nomor_surat' => $this->nomor_surat,
                'nama_pengirim' => $this->nama_pengirim,
                'status' => $this->status,
                'isi_catatan' => $this->isi_catatan,
            ]);
    }
}
