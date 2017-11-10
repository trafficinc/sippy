<?php

/**
 * @library view_helper.php
 * @description little View Helper for Sippy
 */

class Html
{
    public function __construct($config) {
        $this->config['charset'] = (isset($config['charset'])) ? $config['charset'] : 'UTF-8';
    }

    /*
     * escape strings to view, use on variables coming from the DB
     * $this->html->esc("your string")
     * */

    function esc($string)
    {
        if (empty($string)) {
            return $string;
        }
        if (is_string($string)) {
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $this->config['charset']);
        } else {
            throw new Exception('Value must be a string');
        }
    }


/*
 * URL encodes (RFC 3986) a string as a path segment or an array as a query string.
 * <pre>
 * echo $this->html->urlencode(["key1" => "action1","key2 => "action2","key3 => "action3"]);
 * <pre>
 * */


    function urlencode($url)
    {
        if (is_array($url)) {
            return http_build_query($url, '', '&', PHP_QUERY_RFC3986);
        }
        return rawurlencode($url);
    }


/*
 * Splits string into array
 *
 * <pre>
 * $this->html->splits("2,34,45,23",",")
 * $this->html->splits("12345","")
 * <pre>
 * */

    function splits($value, $delimiter, $limit = null)
    {
        $charset = $this->config['charset'];
        if (!empty($delimiter)) {
            return null === $limit ? explode($delimiter, $value) : explode($delimiter, $value, $limit);
        }
        if ($limit <= 1) {
            return preg_split('/(?<!^)(?!$)/u', $value);
        }
        $length = mb_strlen($value, $charset);
        if ($length < $limit) {
            return array($value);
        }
        $r = array();
        for ($i = 0; $i < $length; $i += $limit) {
            $r[] = mb_substr($value, $i, $limit, $charset);
        }
        return $r;
    }


/*
 * Title case a string
 * <pre>
 *  echo $this->html->title_case("here comes the sun.");
 * <pre>
 * */

    function title_case($string)
    {
        if (null !== $this->config['charset']) {
            return mb_convert_case($string, MB_CASE_TITLE, $this->config['charset']);
        }
        return ucwords(strtolower($string));
    }


/*
 * Capitalize string
 * <pre>
 *  echo $this->html->cap("purple haze.");
 * <pre>
 * */

    function cap($string)
    {
        $charset = $this->config['charset'];
        return mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset) . mb_strtolower(mb_substr($string, 1, null, $charset), $charset);
    }


/*
 * Lower case string
 * <pre>
 *  echo $this->html->lcase("HELLO WORLD.");
 * <pre>
 * */

    function lcase($string)
    {
        return mb_strtolower($string, $this->config['charset']);
    }


/*
 * Upper case string
 * <pre>
 *   echo $this->html->ucase("hello world.");
 * <pre>
 * */

    function ucase($string)
    {
        return mb_strtoupper($string, $this->config['charset']);
    }


/*
 * Checks if variable is empty
 * <pre>
 *  echo $this->html->is_empty("");
 * <pre>
 * */

    function is_empty($value)
    {
        if ($value instanceof Countable) {
            return 0 == count($value);
        }
        if (is_object($value) && method_exists($value, '__toString')) {
            return '' === (string)$value;
        }
        return '' === $value || false === $value || null === $value || array() === $value;
    }


/*
 * Element Builder: [list] types ol OR ul
 * <pre>
 * echo $this->html->el_list(["John","Jill","Ron"]);
 * echo $this->html->el_list(["John","Jill","Ron"],'ul',["id"=>"styleone","class"=>"mystyle","style"=>"color:blue;font-size:16px"]);
 * <pre>
 * */

    function el_list($values, $type = 'ul', $options = '')
    {
        $ulStartTag = "<" . $type . ">";
        if (count($options) > 0 && is_array($options)) {
            $list = array("<" . $type);
            foreach ($options as $okey => $oval) {
                // check for associative array
                if (is_int($okey)) {
                    throw new Exception("__eb_list element builder options value must be associative array");
                } else {
                    $list[] = $okey . '="' . $oval . '"';
                }
            }
            $list[] = ">";
            $ulStartTag = implode(" ", $list);
        }

        $lines = array($ulStartTag);
        if (count($values) > 0 && is_array($values)) {
            foreach ($values as $val) {
                $lines[] = "<li>" . $val . "</li>";
            }
            $lines[] = "</" . $type . ">";
        }
        return implode("", $lines);
    }

}



