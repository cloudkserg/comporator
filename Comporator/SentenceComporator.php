<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 15:13
 */

class SentenceComporator extends Comporator
{


    /**
     * @param array $originSentences
     * @param array $diffSentences
     */
    public function __construct(array $originSentences, array $diffSentences)
    {
        $this->setBiggerTextAsDiff($originSentences, $diffSentences);
        $this->length1 = count($this->text1);
        $this->length2 = count($this->text2);

        $this->compare();
    }

    /**
     * @param array $originSentences
     * @param array $diffSentences
     */
    private function setBiggerTextAsDiff(array $originSentences, array $diffSentences)
    {
        if (count($originSentences) >= count($diffSentences)) {
            $this->isSwapTexts = true;
            list($originSentences, $diffSentences) = array($diffSentences, $originSentences);
        }

        $this->text1 = $originSentences;
        $this->text2 = $diffSentences;
    }


    public function compare()
    {
        foreach ($originSentences as $originKey => $originSentence) {
            foreach ($diffSentences as $diffKey => $diffSentence) {
                if ($diffSentence !== $originSentence) {
                    //first situation
                    if (isset($originNext) or $diffSentence == $originNext)
                        $originSentence->setType(REMOVE);
                        $this->addSentences();
                    elseif ()



                }
            }
        }



        ks = array();
        for oneK => one sententces
            for twoK => two sentences
                if (oneK == twoK) {
                    ks = oneK
                } else {
                    findSameSentenceRight(oneK, two_sentences)
                }
    }


}