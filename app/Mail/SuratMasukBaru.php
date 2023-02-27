<?php

namespace App\Mail;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Auth;

class SuratMasukBaru extends Mailable
{
    use Queueable, SerializesModels;

    public $isi_ringkas, $tanggal_surat, $nama_pengirim, $uuid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($isi_ringkas, $tanggal_surat, $nama_pengirim, $uuid)
    {
        $this->isi_ringkas = $isi_ringkas;
        $this->tanggal_surat = $tanggal_surat;
        $this->nama_pengirim = $nama_pengirim;
        $this->uuid = $uuid;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.suratmasuk.terkirim')
            ->subject('[DMS] Surat Masuk dari ' . $this->nama_pengirim)    
            ->with([
                'url' => route('suratmasuk.show', $this->uuid),
                'isi_ringkas' => $this->isi_ringkas,
                'nama_pengirim' => $this->nama_pengirim,
                'tanggal_surat' => $this->tanggal_surat
            ]);
            
    }
}
