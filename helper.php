<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class biblePlanHelper {
    static $bible_books = array(
        "1" => "Genesis",
        "2" => "Exodus",
        "3" => "Leviticus",
        "4" => "Numbers",
        "5" => "Deuteronomy",
        "6" => "Joshua",
        "7" => "Judges",
        "8" => "Ruth",
        "9" => "1Samuel",
        "10" => "2Samuel",
        "11" => "1Kings",
        "12" => "2Kings",
        "13" => "1Chronicles",
        "14" => "2Chronicles",
        "15" => "Ezra",
        "16" => "Nehemiah",
        "19" => "Esther",
        "22" => "Job",
        "23" => "Psalm",
        "24" => "Proverbs",
        "25" => "Ecclesiastes",
        "26" => "SongOfSongs",
        "29" => "Isaiah",
        "30" => "Jeremiah",
        "31" => "Lamentations",
        "33" => "Ezekiel",
        "34" => "Daniel",
        "35" => "Hosea",
        "36" => "Joel",
        "37" => "Amos",
        "38" => "Obadiah",
        "39" => "Jonah",
        "40" => "Micah",
        "41" => "Nahum",
        "42" => "Habakkuk",
        "43" => "Zephaniah",
        "44" => "Haggai",
        "45" => "Zechariah",
        "46" => "Malachi",
        "47" => "Matthew",
        "48" => "Mark",
        "49" => "Luke",
        "50" => "John",
        "51" => "Acts",
        "52" => "Romans",
        "53" => "1Corinthians",
        "54" => "2Corinthians",
        "55" => "Galatians",
        "56" => "Ephesians",
        "57" => "Philippians",
        "58" => "Colossians",
        "59" => "1Thessalonians",
        "60" => "2Thessalonians",
        "61" => "1Timothy",
        "62" => "2Timothy",
        "63" => "Titus",
        "64" => "Philemon",
        "65" => "Hebrews",
        "66" => "James",
        "67" => "1Peter",
        "68" => "2Peter",
        "69" => "1John",
        "70" => "2John",
        "71" => "3John",
        "72" => "Jude",
        "73" => "Revelation"
    );

    static function parse_to_bible_link($verses, $version, $debug) {
        $search = urlencode($verses);
        $link = "<a href='http://www.biblegateway.com/passage/index.php?search=$search&amp;version=$version&amp;interface=print'";
        $link.= " target='_blank' onclick=\"window.open(this.href,this.target,'width=800,height=500,scrollbars=1'); return false;\">";
        $link.= "$verses</a>";
        return $link;
    }

    static function add_audio_link($chunk, $audio_bible, $debug) {
        static $book_nums;

        //get book and verses
        $chunks = explode(' ', $chunk);
        $book_name = trim($chunks[0]);

        if (isset($chunks[1])) {
            $verses = trim($chunks[1]);
        } else {
            $verses = "";
            if ($debug) {
                echo "<b>Error parsing the verses</b><br />";
            }
        }

        if ($debug) {
            echo "Parsing $chunk:<br />";
            echo "Book name = $book_name<br />Verses = $verses <br />";
        }

        if (empty($book_nums[$book_name])) {
            $temp = array_keys(biblePlanHelper::$bible_books, $book_name);
            $book_nums[$book_name] = $temp[0];
        }

        //saves a bit of typing
        $num =& $book_nums[$book_name];

        //only allow New Testament for certain version
        $nt_only = array('31', '30', '33', '29', '28');

        if (in_array($audio_bible, $nt_only) && $num < 47 ) {
            return '';
        } else {
            //get the chapters
            $chapters = explode(':', $verses);

            //assume one chapter
            $start = $end = $chapters[0];

            if (count($chapters) > 2) {
                //we have 1:1-2:6
                //first chunk will have our next chapter
                $temp = explode('-', $chapters[1]);
                //should now be [0] => verse of first chapter, [1] => second chapter
                $end = $temp[1];
            } elseif (strpos($verses, "-") !== false) {
                $temp = explode("-", $verses);
                if (strpos($temp[1], ":") !== false) {
                    //we have 1-2:6
                    $temp2 = explode(':', $temp[1]);
                    //show now have [0] => second chapter, [1] => verses of second chapter
                    $start = $temp[0];
                    $end = $temp2[0];
                } elseif (strpos($temp[0], ":") !== false) {
                    //we have 1:2-6
                    $temp2 = explode(":", $temp[0]);
                    $start = $end = $temp2[0];
                } else {
                    //we have more than one chapter with no verses
                    $temp = explode('-', $verses);
                    $start = $temp[0];
                    $end = $temp[1];
                }
            }

            if ($debug) {
                echo "Parsing $verses into chapters:<br />";
                echo "Start = $start<br />";
                echo "End = $end<br /><br />";
            }
            return '<a style="margin-left: 2px;" title="Audio" href="http://www.biblegateway.com/resources/audio/flash_play.php?aid='.$audio_bible.'&amp;book='.$num.'&amp;chapter='.$start.'&amp;end_chapter='.$end.'" target="_blank" onclick="window.open(this.href,this.target,\'width=400,height=200\'); return false;"><img style="width: 16px; height: 9px; border: 0;" alt="sound.gif" src="' . JURI::root() . '/modules/mod_bibleplan/images/sound.gif" /></a>';
        }
    }

    static function translate_bible_book_names(&$text, $use_abbr, $debug) {
        static $replace_books;

        if (empty($replace_books)) {
            $replace_books = array(
                JText::_("Gen") => JText::_("Genesis"),
                JText::_("Exod") => JText::_("Exodus"),
                JText::_("Lev") => JText::_("Leviticus"),
                JText::_("Num") => JText::_("Numbers"),
                JText::_("Deut") => JText::_("Deuteronomy"),
                JText::_("Josh") => JText::_("Joshua"),
                JText::_("Judg") => JText::_("Judges"),
                JText::_("Ruth") => JText::_("Ruth"),
                JText::_("1Sam") => JText::_("1Samuel"),
                JText::_("2Sam") => JText::_("2Samuel"),
                JText::_("1Kgs") => JText::_("1Kings"),
                JText::_("2Kgs") => JText::_("2Kings"),
                JText::_("1Chro") => JText::_("1Chronicles"),
                JText::_("2Chro") => JText::_("2Chronicles"),
                JText::_("Ezra") => JText::_("Ezra"),
                JText::_("Neh") => JText::_("Nehemiah"),
                JText::_("Esth") => JText::_("Esther"),
                JText::_("Job") => JText::_("Job"),
                JText::_("Psa") => JText::_("Psalm"),
                JText::_("Prov") => JText::_("Proverbs"),
                JText::_("Ecc") => JText::_("Ecclesiastes"),
                JText::_("Song") => JText::_("SongOfSongs"),
                JText::_("Isa") => JText::_("Isaiah"),
                JText::_("Jer") => JText::_("Jeremiah"),
                JText::_("Lam") => JText::_("Lamentations"),
                JText::_("Ezek") => JText::_("Ezekiel"),
                JText::_("Dan") => JText::_("Daniel"),
                JText::_("Hosea") => JText::_("Hosea"),
                JText::_("Joel") => JText::_("Joel"),
                JText::_("Amos") => JText::_("Amos"),
                JText::_("Obad") => JText::_("Obadiah"),
                JText::_("Jonah") => JText::_("Jonah"),
                JText::_("Micah") => JText::_("Micah"),
                JText::_("Nahum") => JText::_("Nahum"),
                JText::_("Hab") => JText::_("Habakkuk"),
                JText::_("Zeph") => JText::_("Zephaniah"),
                JText::_("Hag") => JText::_("Haggai"),
                JText::_("Zech") => JText::_("Zechariah"),
                JText::_("Mal") => JText::_("Malachi"),
                JText::_("Matt") => JText::_("Matthew"),
                JText::_("Mark") => JText::_("Mark"),
                JText::_("Luke") => JText::_("Luke"),
                JText::_("John") => JText::_("John"),
                JText::_("Acts") => JText::_("Acts"),
                JText::_("Rom") => JText::_("Romans"),
                JText::_("1Cor") => JText::_("1Corinthians"),
                JText::_("2Cor") => JText::_("2Corinthians"),
                JText::_("Gal") => JText::_("Galatians"),
                JText::_("Eph") => JText::_("Ephesians"),
                JText::_("Phil") => JText::_("Philippians"),
                JText::_("Col") => JText::_("Colossians"),
                JText::_("1Thes") => JText::_("1Thessalonians"),
                JText::_("2Thes") => JText::_("2Thessalonians"),
                JText::_("1Tim") => JText::_("1Timothy"),
                JText::_("2Tim") => JText::_("2Timothy"),
                JText::_("Tit") => JText::_("Titus"),
                JText::_("Phile") => JText::_("Philemon"),
                JText::_("Heb") => JText::_("Hebrews"),
                JText::_("Jas") => JText::_("James"),
                JText::_("1Pet") => JText::_("1Peter"),
                JText::_("2Pet") => JText::_("2Peter"),
                JText::_("1Jn") => JText::_("1John"),
                JText::_("2Jn") => JText::_("2John"),
                JText::_("3Jn") => JText::_("3John"),
                JText::_("Jude") => JText::_("Jude"),
                JText::_("Rev") => JText::_("Revelation")
            );

            if ($use_abbr) {
                $replace_books = array_keys($replace_books);
            }
        }

        $text = str_replace(biblePlanHelper::$bible_books, $replace_books, $text);
    }

    static function load_readingplan($plan) {
        static $readingplans;

        if (empty($readingplans[$plan])) {
            $class = "bibleplan_{$plan}";
            if (!class_exists($class)) {
                include_once $planDir = JPATH_SITE . DS . 'modules' . DS . 'mod_bibleplan' . DS . 'readingplans' . DS . "{$plan}.php";
            }
            $readingplans[$plan] = new $class();
        }

        return $readingplans[$plan];
    }
}