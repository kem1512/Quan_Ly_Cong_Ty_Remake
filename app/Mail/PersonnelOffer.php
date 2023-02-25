<?php

namespace App\Mail;

use App\Models\CurriculumVitae;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PersonnelOffer extends Mailable
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
        $cver =
            CurriculumVitae::leftjoin('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
            ->select('curriculum_vitaes.*', 'nominees.nominees')->where('curriculum_vitaes.id', '=', "$this->id")->get();
        $current = Carbon::now();
        $date_contract = $current->addDays(7);

        if ($date_contract->dayOfWeek == Carbon::SUNDAY) {
            $date_contract = $current->addDays(8);
        }
        $user = Auth::user()->fullname;
        return $this->view('mail.Offer', compact('cver', 'user'))->with($date_contract)->subject('Xin chúc mừng! Bạn đã trúng tuyển ' . $cver[0]->nominees . ' tại SCONNECT');
    }
}
