<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 17:53
 */

class TextParser
{

    /**
     * @param $text
     * @return array
     */
    public function getSentences($text)
    {
        $splits = preg_split('/([.?!])/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $sentences = array();
        for($index = 0; $index <= count($splits); $index = $index + 2) {
            $endSign = null;
            if (isset($splits[$index + 1])) {
                $endSign = $splits[$index+1];
            }
            $sentences[] = new Sentence($splits[$index], $endSign);
        }
        return $sentences;
    }

}