<?php

namespace sethink\phpLib;

class Validate
{

    /**
     * @必填
     *
     * @param $string
     * @return bool
     */
    public static function required($string)
    {
        return strlen($string) > 0 ? true : false;
    }


    /**
     * @验证有效时间
     *
     * @param $string
     * @return bool
     */
    public static function date($string)
    {
        return strtotime($string) !== false ? true : false;
    }


    /**
     * @只允许字母
     *
     * @param $string
     * @return bool
     */
    public static function alpha($string)
    {
        return preg_match('/^[A-Za-z]+$/', $string) !== 0 ? true : false;
    }


    /**
     * @只允许字母和数字
     *
     * @param $string
     * @return bool
     */
    public function alphaNum($string)
    {
        return preg_match('/^[A-Za-z0-9]+$/', $string) !== 0 ? true : false;
    }


    /**
     * @只允许字母、数字和下划线 破折号
     *
     * @param $string
     * @return bool
     */
    public static function alphaDash($string)
    {
        return preg_match('/^[A-Za-z0-9\-\_]+$/', $string) !== 0 ? true : false;
    }


    /**
     * @只允许汉字
     *
     * @param $string
     * @return bool
     */
    public static function chs($string)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $string) !== 0 ? true : false;
    }


    /**
     * @只允许汉字、字母
     *
     * @param $string
     * @return bool
     */
    public static function chsAlpha($string)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u', $string) !== 0 ? true : false;
    }


    /**
     * @只允许汉字、字母和数字
     *
     * @param $string
     * @return bool
     */
    public static function chsAlphaNum($string)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u', $string) !== 0 ? true : false;
    }


    /**
     * @只允许汉字、字母、数字和下划线_及破折号-
     *
     * @param $string
     * @return bool
     */
    public static function chsDash($string)
    {
        return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-]+$/u', $string) !== 0 ? true : false;
    }


    /**
     * @是否为有效的网址(不带http)
     *
     * @param $string
     * @return bool
     */
    public static function activeUrl($string)
    {
        return checkdnsrr($string);
    }


    /**
     * @是否为IP地址
     *
     * @param $string
     * @return bool
     */
    public static function ip($string)
    {
        return self::filter($string, [FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6]);
    }


    /**
     * @是否为一个URL地址
     *
     * @param $string
     * @return bool
     */
    public static function url($string)
    {
        return self::filter($string, FILTER_VALIDATE_URL);
    }


    /**
     * @是否为float
     *
     * @param $string
     * @return bool
     */
    public static function float($string)
    {
        return self::filter($string, FILTER_VALIDATE_FLOAT);
    }

    /**
     * @是否为数字
     *
     * @param $string
     * @return bool
     */
    public static function number($string)
    {
        return is_numeric($string);
    }


    /**
     * @是否为整型
     *
     * @param $string
     * @return bool
     */
    public static function integer($string)
    {
        return self::filter($string, FILTER_VALIDATE_INT);
    }


    /**
     * @是否为邮箱地址
     *
     * @param $string
     * @return bool
     */
    public static function email($string)
    {
        return self::filter($string, FILTER_VALIDATE_EMAIL);
    }


    /**
     * @是否为布尔值
     *
     * @param $string
     * @return bool
     */
    public static function boolean($string)
    {
        return in_array($string, [true, false, 0, 1, '0', '1'], true);
    }


    /**
     * @是否为数组
     *
     * @param $string
     * @return bool
     */
    public static function isArray($string)
    {
        return is_array($string);
    }


    /**
     * @是否为身份证号码
     *
     * @param $string
     * @return bool
     */
    public static function IDCard($string)
    {
        return preg_match('/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/', $string) !== 0 ? true : false;
    }


    protected static function filter($value, $rule)
    {
        if (is_string($rule) && strpos($rule, ',')) {
            list($rule, $param) = explode(',', $rule);
        } elseif (is_array($rule)) {
            $param = isset($rule[1]) ? $rule[1] : null;
            $rule  = $rule[0];
        } else {
            $param = null;
        }
        return false !== filter_var($value, is_int($rule) ? $rule : filter_id($rule), $param);
    }

}