<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Outgoing;
use App\Models\User;

class newLaravelTips extends Mailable
{

    protected $id_user;
    protected $users = [];

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $outgoings = Outgoing::all()->where('vencimento', '2022-02-10');

        foreach($outgoings as $outgoing) {
            $this->id_user = $outgoing->id_user;
            $this->users = User::all()->where('id', $this->id_user);
        }
        
        return $this->view('mail.new', [
            'users' => $this->users
        ]);
    }
}
