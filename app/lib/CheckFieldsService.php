<?php

namespace Lib;
/**
 * trait for dealing with fields of a form
 * Class CheckFieldsService
 */
trait CheckFieldsService {

    /**
     * remove malicious tags
     *
     * @param array ...$fields
     * @return array
     */
    public static function escapeInputs(...$fields){

        $inputs = [];

        foreach($fields as $field){
            $inputs[$field] = trim(htmlspecialchars($_POST[$field], ENT_QUOTES));
        }

        return $inputs;
    }

    public static function stripMaliciousTags($content)
    {
        $content = strip_tags($content,'<a><b><blockquote><br><button><cite><code><div><dd><dl><dt><em><fieldset>
        <font><h1><h2><h3><h4><h5><hr><i><it><img><label><li><ol><p><pre><span><strong><table><tbody><tr>
        <td><th><u><ul>');
        return $content;
    }


    /**
     *
     * strip malicious tags except harmless and closes the opened tags
     *
     * @param $income
     * @return string
     */
    public function stripTags($content)
    {
        $content = $this->closeTags($content);

       $content = self::stripMaliciousTags($content);
       return $content;
    }

    /**
     *
     * close opened tags
     *
     * @param $content
     * @return string
     */
    private  function closeTags($content)
    {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }

}