<?php

namespace App\Mail;

use App\Models\CurriculumVitae;
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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $cver = CurriculumVitae::find($this->id);
        $user = Auth::user()->fullname;
        return $this->view('mail.PersonnelAccetptMail', compact('cver', 'user'))->subject('Thông Báo Trúng Tuyển SCONNECT');
    }
}
