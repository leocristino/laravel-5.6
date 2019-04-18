<?php

namespace App\Models;


class Billing
{
    public static function selectTicket()
    {
        $ticket = Ticket::select('*')
            ->where('type' ,'=','R')->get();

        return $ticket;
    }
}
