<?php
class M_updates extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function date_range($unix_start = '', $mixed = '', $is_unix = TRUE, $format = 'Y-m-d')
    {
        if ($unix_start == '' or $mixed == '' or $format == '') {
            return FALSE;
        }

        $is_unix = !(!$is_unix or $is_unix === 'days');

        // Validate input and try strtotime() on invalid timestamps/intervals, just in case
        if ((!ctype_digit((string) $unix_start) && ($unix_start = @strtotime($unix_start)) === FALSE)
            or (!ctype_digit((string) $mixed) && ($is_unix === FALSE or ($mixed = @strtotime($mixed)) === FALSE))
            or ($is_unix === TRUE && $mixed < $unix_start)
        ) {
            return FALSE;
        }

        if ($is_unix && ($unix_start == $mixed or date($format, $unix_start) === date($format, $mixed))) {
            return array(date($format, $unix_start));
        }

        $range = array();
        $from = new DateTime();

        if (is_php('5.3')) {
            $from->setTimestamp($unix_start);
            if ($is_unix) {
                $arg = new DateTime();
                $arg->setTimestamp($mixed);
            } else {
                $arg = (int) $mixed;
            }

            $period = new DatePeriod($from, new DateInterval('P1D'), $arg);
            foreach ($period as $date) {
                $range[] = $date->format($format);
            }
            if (!is_int($arg) && $range[count($range) - 1] !== $arg->format($format)) {
                $range[] = $arg->format($format);
            }

            return $range;
        }

        $from->setDate(date('Y', $unix_start), date('n', $unix_start), date('j', $unix_start));
        $from->setTime(date('G', $unix_start), date('i', $unix_start), date('s', $unix_start));
        if ($is_unix) {
            $arg = new DateTime();
            $arg->setDate(date('Y', $mixed), date('n', $mixed), date('j', $mixed));
            $arg->setTime(date('G', $mixed), date('i', $mixed), date('s', $mixed));
        } else {
            $arg = (int) $mixed;
        }
        $range[] = $from->format($format);

        if (is_int($arg)) // Day intervals
        {
            do {
                $from->modify('+1 day');
                $range[] = $from->format($format);
            } while (--$arg > 0);
        } else // end date UNIX timestamp
        {
            for ($from->modify('+1 day'), $end_check = $arg->format('Ymd'); $from->format('Ymd') < $end_check; $from->modify('+1 day')) {
                $range[] = $from->format($format);
            }

            // Our loop only appended dates prior to our end date
            $range[] = $arg->format($format);
        }

        return $range;
    }
}
