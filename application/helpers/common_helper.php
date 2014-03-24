<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('gender_list')) {
    function gender_list($key = '') {
        $data = array(
            1 => 'Nam',
            2 => 'Ná»¯'
        );
        if ($key) {
            return $data[$key];
        } else {
            return $data;
        }
    }
}

if (!function_exists('format_date')) {

    function format_date($date) {
        return date('F j, Y', $date);
    }

}

if (!function_exists('format_date_2')) {

    function format_date_2($date) {
        return date('F j, Y', $date);
    }

}

if (!function_exists('format_date_3')) {

    function format_date_3($date) {
        return date("m-d-Y H:s", $date);
    }

}

if (!function_exists('human_timing')) {

    function human_timing($time) {
        $time = time() - $time; // to get the time since that moment

        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }

}

if (!function_exists('convert_vndate_to_dbdate')) {

    function convert_vndate_to_dbdate($date) {
        $tmp = explode('/', $date);
        $date = $tmp[2] . '-' . $tmp[1] . '-' . $tmp[0];
        return $date;
    }
}

if (!function_exists('convert_dbdate_to_vndate')) {

    function convert_dbdate_to_vndate($date) {
        return date('d/m/Y', strtotime($date));
    }
}

if (!function_exists('get_full_name')) {

    function get_full_name($user) {
        if (!$user)
            return "";
        return $user->getFirstName() . " " . $user->getLastName();
    }
}

if (!function_exists('get_fullname')) {

    function get_fullname($first, $last) {
        return $first . " " . $last;
    }
}

if (!function_exists('get_username_for_latest_deals')) {

    function get_username_for_latest_deals($first, $last) {
        $fullname = get_fullname($first, $last);
        if (strlen($fullname) <= 15)
            return $fullname;
        return $first . " " . substr($last, 0, 1) . ".";
    }
}

if (!function_exists("get_image_url")) {
    function get_image_url($folder, $image_name) {
        if (substr($image_name, 0, 4) == "http")
            return $image_name;

        $img_folder = $var = config_item('image_folder');
        $img_path = $img_folder . $folder . "/" . $image_name;
        if (file_exists($img_path) && $image_name) {
            return base_url($img_path);
        } else {
            return base_url($img_folder . "no-image.jpg");
        }
    }
}

if (!function_exists("truncate")) {
    function truncate($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

if (!function_exists("truncate1")) {
    function truncate1($string, $your_desired_width) {
        $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
        $parts_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $parts_count; ++$last_part) {
            $length += strlen($parts[$last_part]);
            if ($length > $your_desired_width) {
                break;
            }
        }

        return implode(array_slice($parts, 0, $last_part));
    }
}

if (!function_exists("truncate_words_by_characters")) {
    function truncate_words_by_characters($str, $len = 55, $charset = 'UTF-8') {
        $str = html_entity_decode($str, ENT_QUOTES, $charset);
        if (mb_strlen($str, $charset) > $len) {
            $arr = explode(' ', $str);
            $str = mb_substr($str, 0, $len, $charset);
            $arrRes = explode(' ', $str);
            $last = $arr[count($arrRes) - 1];
            unset($arr);
            if (strcasecmp($arrRes[count($arrRes) - 1], $last))
                unset($arrRes[count($arrRes) - 1]);
            return implode(' ', $arrRes) . '...';
        }
        return $str;
    }
}

if (!function_exists("get_root_domain")) {
    function get_root_domain($url) {
        $replace = array("www.", "www20.", ".edu");
        return str_replace($replace, "", parse_url($url, PHP_URL_HOST));
    }
}

if (!function_exists("replace_bad_words")) {
    function replace_bad_words($badstring) {
        //read file containing bad words and its corresponding replacement line by line like this crap,c***
        $file_array = file(FCPATH . '/application/helpers/bad_words.txt', FILE_IGNORE_NEW_LINES);
        //this will be filled with bad words from file
        $badWordArray = array();
        //this will be filled with bad words replacement from file
        $badWordReplaceArray = array();
        //read the array containing each line from file
        foreach ($file_array as $badReplace) {
            //explode the line and separate bad word and replacement.
            $parts = explode(",", $badReplace);
            //assign each bad word
            $badWordArray[] = $parts[0];
            //assign corresponding replacement
            $badWordReplaceArray[] = $parts[1];
        }
        //str_ireplace do case insensitive replace
        $goodString = str_ireplace($badWordArray, $badWordReplaceArray, $badstring);
        return $goodString;
    }
}
if (!function_exists("get_image_url_data")) {
    function get_image_url_data($folder, $image_name) {
        if (substr($image_name, 0, 4) == "http")
            return $image_name;
        $img_folder = $this->config->item("image_folder");

        $img_path = $img_folder . $folder . "/" . $image_name;
        if ($image_name == "") {
            return base_url($img_folder . "no-image.jpg");
        }
        if (file_exists(FCPATH . $img_path)) {
            return base_url($img_path);
        } else {
            return base_url($img_folder . "no-image.jpg");
        }
    }
}
if (!function_exists("generate_book_alias")) {
    function generate_book_alias($book_arr) {
        $book_title = $book_arr['title'];
        $book_author = $book_arr['author'];
        $book_isbn10 = $book_arr['isbn10'];
        $book_isbn13 = $book_arr['isbn13'];

        if (count($book_isbn13) > 0) {
            $isbn = $book_isbn13[0];
        } else {
            $isbn = $book_isbn10[0];
        }
        $alias = url_title($book_title . ' ' . $isbn . ' ' . $book_author, '-', TRUE);

        return $alias;
    }
}


/* End of file common_helper.php */
/* Location: ./application/frontend/helpers/common_helper.php */