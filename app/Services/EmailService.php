<?php

namespace App\Services;

use Mail;
use View;

class EmailService
{
	public function enviar($email, $data)
	{
		Mail::send(array(), array(), function ($message) use ($email, $data) {
			$message->to($email)
				->subject(@$data['titulo'])
				->setBody($data['content'], 'text/html');
		});
    }
}
