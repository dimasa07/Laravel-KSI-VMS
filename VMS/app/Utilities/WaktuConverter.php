<?php

namespace App\Utilities;

use Carbon\Carbon;

class WaktuConverter
{
    public $tahun = '';
    public $bulan = '';
    public $tanggal = '';
    public $hari = '';
    public $jam = '';
    public $menit = '';

    public function __construct($dt)
    {
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $dt);
        $tahun = $datetime->year;
        $bulan = '';
        $tanggal = $datetime->day;
        $hari = '';
        $jam = $datetime->hour < 10 ? '0' . $datetime->hour : $datetime->hour;
        $menit = $datetime->minute < 10 ? '0' . $datetime->minute : $datetime->minute;
        switch ($datetime->dayName) {
            case 'Sunday':
                $hari = 'Minggu';
                break;
            case 'Monday':
                $hari = 'Senin';
                break;
            case 'Tuesday':
                $hari = 'Selasa';
                break;
            case 'Wednesday':
                $hari = 'Rabu';
                break;
            case 'Thursday':
                $hari = 'Kamis';
                break;
            case 'Friday':
                $hari = 'Jumat';
                break;
            case 'Saturday':
                $hari = 'Sabtu';
                break;
        }

        switch ($datetime->monthName) {
            case 'January':
                $bulan = 'Januari';
                break;
            case 'February':
                $bulan = 'Februari';
                break;
            case 'March':
                $bulan = 'Maret';
                break;
            case 'April':
                $bulan = 'April';
                break;
            case 'May':
                $bulan = 'Mei';
                break;
            case 'June':
                $bulan = 'Juni';
                break;
            case 'July':
                $bulan = 'Juli';
                break;
            case 'August':
                $bulan = 'Agustus';
                break;
            case 'September':
                $bulan = 'September';
                break;
            case 'October':
                $bulan = 'Oktober';
                break;
            case 'November':
                $bulan = 'November';
                break;
            case 'December':
                $bulan = 'Desember';
                break;
            default:
                $bulan = $datetime->monthName;
        }
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->hari = $hari;
        $this->tanggal = $tanggal;
        $this->jam = $jam;
        $this->menit = $menit;
    }

    public function getDateTime()
    {
        return $this->tanggal  . ' ' . $this->bulan  . ' ' . $this->tahun . ', Pukul ' . $this->jam . ':' . $this->menit;
    }

    public function getDate()
    {
        return $this->tanggal  . ' ' . $this->bulan  . ' ' . $this->tahun;
    }

    public static function convertToDateTime($dt){
        if($dt == null || $dt == ''){
            return '-';
        }
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $dt);
        $tahun = $datetime->year;
        $bulan = '';
        $tanggal = $datetime->day;
        $hari = '';
        $jam = $datetime->hour < 10 ? '0' . $datetime->hour : $datetime->hour;
        $menit = $datetime->minute < 10 ? '0' . $datetime->minute : $datetime->minute;
        switch ($datetime->dayName) {
            case 'Sunday':
                $hari = 'Minggu';
                break;
            case 'Monday':
                $hari = 'Senin';
                break;
            case 'Tuesday':
                $hari = 'Selasa';
                break;
            case 'Wednesday':
                $hari = 'Rabu';
                break;
            case 'Thursday':
                $hari = 'Kamis';
                break;
            case 'Friday':
                $hari = 'Jumat';
                break;
            case 'Saturday':
                $hari = 'Sabtu';
                break;
        }

        switch ($datetime->monthName) {
            case 'January':
                $bulan = 'Januari';
                break;
            case 'February':
                $bulan = 'Februari';
                break;
            case 'March':
                $bulan = 'Maret';
                break;
            case 'April':
                $bulan = 'April';
                break;
            case 'May':
                $bulan = 'Mei';
                break;
            case 'June':
                $bulan = 'Juni';
                break;
            case 'July':
                $bulan = 'Juli';
                break;
            case 'August':
                $bulan = 'Agustus';
                break;
            case 'September':
                $bulan = 'September';
                break;
            case 'October':
                $bulan = 'Oktober';
                break;
            case 'November':
                $bulan = 'November';
                break;
            case 'December':
                $bulan = 'Desember';
                break;
            default:
                $bulan = $datetime->monthName;
        }

        return $tanggal  . ' ' . $bulan  . ' ' . $tahun . ', Pukul ' . $jam . ':' . $menit;
    }
}
