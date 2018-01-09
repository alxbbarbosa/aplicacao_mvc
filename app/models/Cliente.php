<?php

namespace App\Models;

class Cliente extends Model
{

    protected $logTimestamp = TRUE;

    public function listarRecentes(int $dias = 10)
    {
        return Cliente::all("created_at >= '" . date('Y-m-d h:m:i', strtotime("-{$dias} days")) . "'");
    }

    public function numTotal()
    {
        return Cliente::count();
    }
}
