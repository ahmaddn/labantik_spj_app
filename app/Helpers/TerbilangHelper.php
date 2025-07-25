<?php

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = [
            '', ' satu', ' dua', ' tiga', ' empat', ' lima', ' enam',
            ' tujuh', ' delapan', ' sembilan', ' sepuluh', ' sebelas'
        ];
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = terbilang($angka - 10) . ' belas ';
        } elseif ($angka < 100) {
            $terbilang = terbilang($angka / 10) . ' puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = terbilang($angka / 100) . ' ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' seribu' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = terbilang($angka / 1000) . ' ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = terbilang($angka / 1000000) . ' juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $miliar = floor($angka / 1000000000); // jumlah miliar
            $sisa = $angka % 1000000000;

            if ($sisa == 0) {
                $terbilang = terbilang($miliar) . ' miliar';
            } else {
                $terbilang = terbilang($miliar) . ' miliar ' . terbilang($sisa);
            }
        }




        return trim($terbilang);
    }
}
