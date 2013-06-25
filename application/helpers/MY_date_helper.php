<?php
defined('BASEPATH') or exit('No direct script access');

if ( !function_exists('format_date') )
{

    /**
     * Generate Unix time to formated date
     *
     * @param int $time
     * @param bool $hour
     * @return string
     */
    function format_date($time = 0, $hour = false)
    {
        $CI = & get_instance();
        $CI->load->language('calendar');

        // ambil indeks bahasa dari calendar_lang.php
        $months = array(
            '01' => $CI->lang->line('cal_january'),
            '02' => $CI->lang->line('cal_february'),
            '03' => $CI->lang->line('cal_march'),
            '04' => $CI->lang->line('cal_april'),
            '05' => $CI->lang->line('cal_may'),
            '06' => $CI->lang->line('cal_june'),
            '07' => $CI->lang->line('cal_july'),
            '08' => $CI->lang->line('cal_august'),
            '09' => $CI->lang->line('cal_september'),
            '10' => $CI->lang->line('cal_october'),
            '11' => $CI->lang->line('cal_november'),
            '12' => $CI->lang->line('cal_december'),
        );

        $month = $months[date('m', $time)];
        if ( $hour == true )
        {
            // menampilkan tanggal dan jam
            return sprintf('%s %s %s %s', date('d', $time), $month, date('Y', $time), date('H:i', $time));
        }

        // menampilkan tanggal saja
        return sprintf('%s %s %s', date('d', $time), $month, date('Y', $time));
    }

}/* end of file application/helpers/MY_date_helper.php */