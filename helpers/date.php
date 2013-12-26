<? 
/* http://csl.name/php-secs-to-human-text/ */
/*
 * Convert seconds to human readable text.
 *
 */
function secs_to_h($secs)
{
        $units = array(
                "week"   => 7*24*3600,
                "day"    =>   24*3600,
                "hr"   =>      3600,
                "min" =>        60,
                "sec" =>         1,
        );

    // specifically handle zero
        if ( $secs == 0 ) return "0 seconds";

        $s = "";

        $words = 0;
        foreach ( $units as $name => $divisor ) {
                if (($quot = intval($secs / $divisor)) and $words < 3)  {
                        $s .= "$quot $name";
                        $s .= (abs($quot) > 1 ? "s" : "") . ", ";
                        $secs -= $quot * $divisor;
                    $words++;
                }
        }

        return substr($s, 0, -2);
}

function nocachetag() {
    return time() . rand(1,100);
}

?>
