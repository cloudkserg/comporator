<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 15:03
 */

class TextComporator
{

    private $diffSentences;

    public function __construct($originText, $diffText)
    {
        $originSentences = SentenceFactory::createSentences($originText);
        $this->diffSentences = SentenceFactory::createSentences($diffText);

        $this->setTypeAndOriginForDiffSentences($originSentences);
    }

    private function setTypeAndOriginForDiffSentences($originSentences)
    {
        foreach ($this->diffSentences as $diffSentence) {
            $origin
        }

    }



    public function getDiffSentences()
    {
        return $this->diffSentences;
    }

}