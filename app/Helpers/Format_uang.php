<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Format_uang {
    public static function angka($angka) {
        return number_format($angka, 0, ',', '.');
    }
}