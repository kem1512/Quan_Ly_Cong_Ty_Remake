<?php

namespace App\Mail;

use App\Models\CurriculumVitae;
use App\Models\interview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PersonnelAcceptMailer extends Mailable
{
    use Queueable, SerializesModels;
    private $id;
    private $id_inter;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $id_inter)
    {
        $this->id = $id;
        $this->id_inter = $id_inter;

        // dd($id);
        // dd($id_inter);
    }

    public function build()
    {
        $cver = CurriculumVitae::find($this->id);
        $inter = interview::find($this->id_inter);
        $user = Auth::user()->fullname;
        return $this->view('mail.PersonnelAccetptMail', compact('cver', 'user', 'inter'))->subject('Thông Báo Trúng Tuyển SCONNECT');
    }
}
