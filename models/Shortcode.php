<?php

namespace app\models;

use Yii;

class Shortcode extends \yii\base\BaseObject
{
    public $callbacks = [
        'data' => [
            'order_id' => 'order_id',
            'lastname' => 'lastname',
            'name' => 'name',
            'surname' => 'surname',
            'phone' => 'phone',
            'email' => 'email',
            'postcode' => 'postcode',
            'country' => 'country',
            'city' => 'city',
            'area' => 'area',
            'home' => 'home',
            'street' => 'street',
            'comment' => 'comment',
            'viewData' => 'viewData',
            'delivery' => 'delivery',
            'payment' => 'payment',
            'del-track' => 'del-track',
            'flat' => 'flat',
            'paymnet-link' => 'paymnet-link',
            'username' => 'username',
            'password' => 'password',
            'infoproduct-name' => 'infoproduct-name',
            'infoproduct-link'=>'infoproduct-link',
            'text' => 'text',
            'task-name' => 'task-name',
            'task-link' => 'task-link',
            'partner-link' => 'partner-link'

        ]
        //'order_id' => ['app\widgets\OrderId', 'widget'],
    ];
    public $attr = null;

    public function __construct($attr)
    {
        $this->attr = $attr;
    }

    public function parse($content)
    {
        $result = $content;

        $shortcodes = $this->getShortcodeList($content);
        foreach ($shortcodes as $shortcode) {
            if (in_array($shortcode, array_keys($this->callbacks))) {
                $regexp = $this->getShortcodeRegexp($shortcode);
                $result = preg_replace_callback("/$regexp/s", array($this, 'parseSingle'), $result);
            } else {
                foreach ($this->attr as $key => $item) {
                    if (in_array($key, array_keys($this->callbacks['data'])) && $key == $shortcode) {
                        $regexp = $this->getShortcodeRegexp($shortcode);
                        $result = preg_replace_callback("/$regexp/s", array($this, 'parseData'), $result);
                    }
                }
            }
        }
        return $result;
    }


    public function parseData($m)
    {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }
        $tag = $m[2];
        $attr = $this->shortcodeParseAtts($m[3]);
        if ($attr === '') {
            $attr = null;
        }
        if (isset($m[5])) {
            return $this->attr[$tag];
        } else {
            return $m[1] . call_user_func($this->callbacks[$tag], $attr, null, $tag) . $m[6];
        }
    }

    public function parseSingle($m)
    {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }
        $tag = $m[2];
        $attr = $this->shortcodeParseAtts($m[3]);
        if ($attr === '') {
            $attr = null;
        }
        if (isset($m[5])) {
            // enclosing tag - extra parameter
            return $m[1] . call_user_func($this->callbacks[$tag], $attr, $m[5], $tag) . $m[6];
        } else {
            // self-closing tag
            return $m[1] . call_user_func($this->callbacks[$tag], $attr, null, $tag) . $m[6];
        }
    }



    public function getShortcodeList($content)
    {
        $result = array();
        preg_match_all("/\[([A-Za-z_]+[^\ \]]+)/", $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $result[$match] = $match;
            }
        }
        return $result;
    }

    public function shortcodeParseAtts($text)
    {
        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1]))
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                elseif (!empty($m[3]))
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                elseif (!empty($m[5]))
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                elseif (isset($m[7]) and strlen($m[7]))
                    $atts[] = stripcslashes($m[7]);
                elseif (isset($m[8]))
                    $atts[] = stripcslashes($m[8]);
            }
        } else {
            $atts = ltrim($text);
        }
        return $atts;
    }

    public function getShortcodeRegexp($tagregexp)
    {
        return
            '\\['                              // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }
}
