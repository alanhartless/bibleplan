<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

include_once JPATH_SITE . DS . "modules" . DS . "mod_bibleplan" . DS . "helper.php";
include_once JPATH_SITE . DS . "modules" . DS . "mod_bibleplan" . DS . "includes" . DS . "abstract.readingplan.php";

$doc = JFactory::getDocument();
$doc->addStylesheet(JUri::base(true) . "/modules/mod_bibleplan/assets/bibleplan.css");

$language = JFactory::getLanguage();
$language->load('mod_bibleplan');

$db = JFactory::getDBO();

$debug = $params->get('debug', 0);
//$todays_date = '2012-07-03';
$todays_date = date('Y-m-d');
$todays_timestamp = strtotime($todays_date);
$this_year = date('Y', $todays_timestamp);
$is_leap_year = (int) date("L", $todays_timestamp);
$leapday_timestamp = ($is_leap_year) ? strtotime("$this_year-02-29") : false;
$start_date = $params->get('start_date', date('Y-m-d'));
$start_timestamp = strtotime($start_date);
$daysofweek = array(
    1 => JText::_('Monday'),
    2 => JText::_('Tuesday'),
    3 => JText::_('Wednesday'),
    4 => JText::_('Thursday'),
    5 => JText::_('Friday'),
    6 => JText::_('Saturday'),
    7 => JText::_('Sunday')
);


if ($start_timestamp <= $todays_timestamp) {
    //determine the number of days between start date and today
    $from = explode('-', $start_date);
    $till = explode('-', $todays_date);
    $start = gregoriantojd($from[1], $from[2], $from[0]);
    $today = gregoriantojd($till[1], $till[2], $till[0]);
    $date_diff = ($today - $start);

    if ($debug) {
        echo "Plan Start Date: " . date('Y-m-d', strtotime($start_date)) . "<br /><br />";
        echo "Today's Date: " . date('D, Y-m-d', strtotime($todays_date)) . "<br /><br />";
    }

    //get the day of year
    $current_day = date('z', $todays_timestamp) + 1;  // z starts with 0 to 365 so add one for current day
    $start_day = date('z', $start_timestamp) + 1;  // z starts with 0 to 365
    if ($debug) {
        echo "Current day of year: $current_day<br />";
        echo "Plan start day of year: $start_day <br /><br />";
    }

    //get the day of year for start date
    if ($current_day == $start_day) {
        $current_plan_day = 1;
        if ($debug) {
            echo "<em>Today is the reading plan's start date...</em><br /><br />";
        }
    } elseif ($date_diff > 365) {
        //let's get the number of leap years in between the two dates
        $test_year = date('Y', $start_timestamp);
        $leap_years = 0;
        while ($test_year <= $this_year) {
            if ((int) date('L', strtotime($test_year . '-12-31'))) {
                if ($test_year != $this_year) {
                    $leap_years++;
                } else {
                    if ($todays_timestamp >= strtotime($this_year . '-02-29')) {
                        //only count the leap year if today is after 2/29
                        $leap_years++;
                    }
                }
            }
            $test_year++;
        }

        //number of days between now and the start of plan
        $floor = floor($date_diff / 365);
        $current_plan_day =  (($date_diff - (365 * $floor)) + 1) - $leap_years; //don't count leap days

        if (empty($current_plan_day)) {
            $current_plan_day = 365;
        }
        if ($debug) {
            echo "<em>It has been $date_diff days from start date (including $leap_years leap days)...</em><br /><br />";
        }
    } elseif ($date_diff == 365) {
        $current_plan_day = 1;
        if ($debug) {
            echo "<em>It has been 365 days from start date...</em><br /><br />";
        }
    } elseif ($current_day < $start_day) {
        //we have moved into the new year

        //was last year a leap year?
        $num_days = (date('L', $start_timestamp)) ? 366 : 365;

        //add remaining days of last year plus current day
        $current_plan_day = ($num_days - $start_day) + $current_day + 1;  //account for the z = 0 thing

        if ($debug) {
            echo "<em>It has been $current_plan_day days from start date...</em><br /><br />";
        }
    } else {
        $current_plan_day = ($current_day - $start_day) + 1;

        if ($is_leap_year && $todays_timestamp > $leapday_timestamp) {
            $current_plan_day--;
            if ($debug) {
                echo "<em>Adjusted today's reading plan day to account for this year's skipped leap day...</em><br /><br />";
            }
        }

        if ($debug) {
            echo "<em>It has been " . ($current_day - $start_day) . " days from start date...</em><br /><br />";
        }
    }

    if ($debug) {
        echo "Today's reading plan day: $current_plan_day<br /><br />";
    }

    //day of the week
    $day_of_week = date('w', $todays_timestamp); //0 = Sunday; 6 = Saturday
    //convert to ISO-8601 numeric rep where Sunday = 7
    if (empty($day_of_week)) {
        $day_of_week = 7;
    }

    $start_dow = $params->get("start_dow", 1);

    if ((int)$day_of_week === (int)$start_dow) {
        //its the start day of the week
        if ($debug) {
            echo "<em>Today is the set start day of the week so starting with today's reading plan day...</em><br /><br />";
        }
        $start_plan_day = $current_plan_day;
    } else {
        if ($debug) {
            echo "<em>Moving plan start day back to the start day of the week...</em><br />";
            echo "Today is {$daysofweek[$day_of_week]} ($day_of_week) but start dow is {$daysofweek[$start_dow]} ($start_dow).<br />";
            echo "Current plan day = $current_plan_day.<br/>";
        }
        if ($day_of_week > $start_dow) {
            $start_plan_day = $current_plan_day - ($day_of_week - $start_dow);
        } else {
            $diff     = 0;
            $temp_dow = $day_of_week;
            while ($temp_dow != $start_dow) {
                $diff++;
                $temp_dow--;

                if (empty($temp_dow)) {
                    //go back to Sunday
                    $temp_dow = 7;
                }

                if ($debug) {
                    echo "Diff count = $diff<br />";
                    echo "Now at {$daysofweek[$temp_dow]} ($temp_dow).<br />";
                }
            }

            $start_plan_day = $current_plan_day - $diff; //number of days from start day of the week
        }

        if ($debug) {
            echo "Start plan day is now $start_plan_day. <br /><br />";
        }
    }

    //roll back to previous year's (in days) plans if need be
    if ($start_plan_day < 0) {
        $start_of_year_diff = (0 - $start_plan_day);
        $start_plan_day = 365 - $start_of_year_diff;
    }

    //get set number of days worth unless it is leap week
    $num_display_days = $params->get('number_per_week', 6);
    $end_plan_day = $start_plan_day + $num_display_days;

    //find out if this week contains leap day
    $account_for_leapday = false;
    if ($is_leap_year) {
        $mondays_timestamp = ($day_of_week == 1) ? $todays_timestamp : strtotime("-" . ($day_of_week - 1) . " days", $todays_timestamp);
        $days_till_sunday = 7 - $day_of_week;
        $sundays_timestamp = strtotime("+" . $days_till_sunday . " days", $todays_timestamp);
        if ($leapday_timestamp >= $mondays_timestamp && $leapday_timestamp <= $sundays_timestamp) {
            //only get 6 days worth for this week to account for leap day
            $end_plan_day--;

            //what day of week is leap day
            $leap_day_of_week = date('w', $leapday_timestamp); //0 = Sunday; 6 = Saturday
            //convert to ISO-8601 numeric rep where Sunday = 7
            if (empty($leap_day_of_week)) {
                $leap_day_of_week = 7;
            }
            //make it match $daysofweek array
            $leap_day_of_week--; //0 = Monday; 6 = Sunday
            $account_for_leapday = true;
            if ($debug) {
                echo "<em>Determined that leap day is this week...</em><br /><br />";
            }
        }
    }

    //roll to next year if over 365 days
    if ($end_plan_day > 365) {
        $end_of_year_diff = $end_plan_day - 365;
        $end_plan_day = $end_plan_day - $end_of_year_diff;
    }

    if ($debug) {
        echo "Pulling plan days $start_plan_day to $end_plan_day...<br /><br />";
    }

    //what plan should be used
    $bibleplan = $params->get('bibleplan', 'oneyearchronological');

    if ($debug) {
        echo "Plan used: $bibleplan<br /><br />";
    }

    //get the readings
    $query = "SELECT verses FROM #__bible_data WHERE bibleplan = " . $db->Quote($bibleplan) . " AND day >= $start_plan_day AND day <= $end_plan_day ORDER BY day";
    $db->setQuery($query);
    $verses = $db->loadObjectList();

    //is this week flowing over into the following year (in days)
    if (isset($end_of_year_diff)) {
        if ($debug) {
            echo "<em>Restarting plan...</em><br /><br />";
            echo "Pulling plan days 1 to " . ($end_of_year_diff) . "...<br /><br />";
        }
        //get the remaining readings
        $query = "SELECT verses FROM #__bible_data WHERE bibleplan = " . $db->Quote($bibleplan) . " AND day >= 1 AND day <= $end_of_year_diff ORDER BY day";
        $db->setQuery($query);
        $remaining_verses = $db->loadObjectList();
        $verses = array_merge($verses, $remaining_verses);
    }

    $readings = array();

    $dow = $start_dow;

    jimport('joomla.plugin.helper');

    $use_abbr = $params->get('use_abbr', 0);
    $parse_links = $params->get('parse_links', 1);
    $bible_version = $params->get('bible_version', 'ESV');
    $audio_links = $params->get('audio_link', 0);
    $audio_bible = $params->get('audio_bible', '21');

    if ($debug) {
        if ($parse_links) {
            echo "Reading Bible: $bible_version<br/>";
        }

        if ($audio_links) {
            echo "Audio bible: $audio_bible<br /><br />";
        }
    }


    foreach ($verses as $v) {
        if ($dow > 7) {
            //change back to Monday if we are beyond Sunday
            $dow = 1;
        }

        if ($account_for_leapday && $dow == $leap_day_of_week) {
            $readings[$dow][] = JText::_('MOD_BIBLEPLAN_DAY_OFF');
            $dow++;
        }

        //bust up into individual readings
        $chunks = explode(';', $v->verses);
        foreach ($chunks as $k => $chunk) {
            //clean it up
            $chunk = trim($chunk);
            $output = "";
            if ($parse_links) {
                $output = biblePlanHelper::parse_to_bible_link($chunk, $bible_version, $debug);
            } else {
                $output = $chunk;
            }

            if ($audio_links) {
                $output .= biblePlanHelper::add_audio_link($chunk, $audio_bible, $debug);
            }

            biblePlanHelper::translate_bible_book_names($output, $use_abbr, $debug);

            $readings[$dow][] = $output;
        }

        $dow++;
    }

    //account for any empty days
    $reading_count = count($readings);
    if ($reading_count < 7) {
        while ($reading_count < 7) {
            if ($dow > 7) {
                //change back to Monday if we are beyond Sunday
                $dow = 1;
            }

            $readings[$dow][] = JText::_('MOD_BIBLEPLAN_DAY_OFF');
            $dow++;

            $reading_count++;
        }

    }

    $rp =& biblePlanHelper::load_readingplan($bibleplan);
    $plan_information = $rp->getInfo();

    require(JModuleHelper::getLayoutPath('mod_bibleplan'));
}
