<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PHP Excel Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Php_html
{

    public function __construct()
    {
        require APPPATH . 'third_party/html_parser/simple_html_dom.php';
    }

    public function load(
        $url,
        $use_include_path = false,
        $context = null,
        $offset = 0,
        $maxLen = -1,
        $lowercase = true,
        $forceTagsClosed = true,
        $target_charset = DEFAULT_TARGET_CHARSET,
        $stripRN = true,
        $defaultBRText = DEFAULT_BR_TEXT,
        $defaultSpanText = DEFAULT_SPAN_TEXT)
    {
        $content = file_get_html($url,
            $use_include_path = false,
            $context = null,
            $offset = 0,
            $maxLen = -1,
            $lowercase = true,
            $forceTagsClosed = true,
            $target_charset = DEFAULT_TARGET_CHARSET,
            $stripRN = true,
            $defaultBRText = DEFAULT_BR_TEXT,
            $defaultSpanText = DEFAULT_SPAN_TEXT);
        return $content;
    }
}