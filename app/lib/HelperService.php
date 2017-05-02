<?php

namespace Lib;


use function \succededRegistrationMail;
/**
 *
 * the class provides many usefull helper function
 *
 * Class HelperService
 * @package Lib
 */
class HelperService {


    /**
     * send email
     *
     * @param array $inputs
     * @return bool
     */
    public static function sendMail(array $inputs){

         extract($inputs);
         $time_now = LangService::rus_date("j F Y H:i ", time());
         $to = $email;
         $thema = $time_now. "\n Повидомлення з сайту Имя ".$login;
            $message = succededRegistrationMail($login, $password );


         $header="Content-type: text/html; charset=\"utf-8\"";
         $header.="From: <".ADMINEMAIL.">";
         $header.="Subject: ".$thema;
         $header.="Content-type: text/html; charset=\"utf-8\"";

         return mail($to, $thema, $message, $header);
     }

    /**
     * convert the string with languages LANG into assoc array
     *
     * @return array
     */
    public static function prozessLangArray()
    {

        $langs = [];

        foreach (LANG as $ln) {
            $arr = explode('=>', $ln);
            $key = trim($arr[0], ' ');
            $value = trim($arr[1], ' ');
            $langs[$key] = $value;
        }
        return $langs;
    }


    /**
     *
     * find out the language component in url
     *
     * @return string
     */
    public static function currentLang()
    {
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $url = trim($url);
        foreach ($langs as $key => $value){
            $position = strpos($url, $key);
            if($position === 0) {
                if ($key == DEFAULT_LANG ){ return ''; }
                return '/'.$key;
            }
        }

        return '';
    }

    /**
     * get abbriviatur of current Language
     *
     * @return int|string
     */
    public static function getCurrentLanguageAbbr()
    {
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $url = trim($url);
        foreach ($langs as $key => $value){
            $position = strpos($url, $key);
            if($position === 0) { return $key;}
        }

        return DEFAULT_LANG;
    }

    /**
     * get titles of languages in the header
     *
     * @return mixed|string
     */
     public static function getCurrentLanguageTitle()
    {
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $url = trim($url);
        foreach ($langs as $key => $value){
            $position = strpos($url, $key);
            if($position === 0) { return $value;}
        }
//return українська
        return DEFAULT_LANG_TITLE;

    }


    /**
     *
     * for droplist of the possible language in the header
     * override/rewtite language in url for necessary one
     *
     * @param $lang
     * @return string url
     */
    public static function overrideLangInUrl($lang)
    {
        //get associative array of languages
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');

        $url = trim($url);

      if(strpos($url, '/')) {
       $url = explode('/', $url);
          foreach ($langs as $key=> $value){

              $position = array_search($key, $url);
              if(($position !== false)) { unset($url[$position]);}
          }
      } else {
          foreach($langs as $key=>$value){
              if($key == $url){ unset($url); break;}
          }

      }

        if(@ is_string($url)) {$adress= $url; $url= []; $url[0] = $adress;}
        if(!isset($url)) $url =[];

        if(DEFAULT_LANG != $lang)  array_unshift($url, $lang);

        $url = @ implode($url, '/');
        return $url;

    }



    public static function getRidOfRepeatedItemsInUrl($item = ''){

        $url = $_SERVER['REQUEST_URI'];
        $url= trim($url, '/');
        $url= explode('?', $url);
        $url= $url[0];


        $i=0;
        foreach ($_GET as $key=> $value){
            if($key == $item or $value =='catalog' or $key=='url') continue;
            if($key=='p') {$p=$value; continue;}
            if($i == 0){$url.='?'.$key.'='.$value; } else {$url.='&'.$key.'='.$value; }
            $i++;

        }


        $question_mark= strpos($url, '?');
        if($question_mark){$url = $url.'&';} else {$url = $url.'?';}

        return $url;
    }




}