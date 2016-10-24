<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 16:15
 */

class DiffComporator
{
    /**
     * @var Sentence[]
     */
    private $originText;

    /**
     * @var Sentence[]
     */
    private $diffText;

    private $originLength;

    private $diffLength;

    private $originIndex;

    private $diffIndex;

    private $sentences= array();

    public function __construct(array $originText, array $diffText)
    {
        $this->originText = $originText;
        $this->diffText = $diffText;
        $this->originLength = count($originText);
        $this->diffLength = count($diffText);
        $this->diffIndex = 0;
        $this->originIndex = 0;

        $this->compare();
    }

    /**
     * @return bool
     */
    private function isEnd()
    {
        return ($this->originIndex >= $this->originLength or $this->diffIndex >= $this->diffLength);
    }

    public function getSentences()
    {
        return $this->sentences;
    }

    /**
     *
     */
    private function compare()
    {
        while (!$this->isEnd()) {
            if ($this->isSameSentences()) {
                $this->sentences[] = $this->createCommonSentence();
                $this->originIndex++;
                $this->diffIndex++;
            } else {
                $dirtyDiffIndex = $this->diffIndex;
                $dirtyOriginIndex = $this->originIndex;
                $this->shiftToMinSameSentence();
                $this->saveDirtySentences($dirtyDiffIndex, $dirtyOriginIndex);
            }
        }

        $this->createEndedSentences();
    }

    private function createEndedSentences()
    {
        if ($this->originIndex < $this->originLength) {
            $this->saveDeletedSentences($this->originIndex);
        } else if ($this->diffIndex < $this->diffLength) {
            $this->saveAddedSentences($this->diffIndex);
        }
    }

    private function saveDirtySentences($dirtyDiffIndex, $dirtyOriginIndex)
    {
        $diffLength = $this->diffIndex - $dirtyDiffIndex;
        $originLength = $this->originIndex - $dirtyOriginIndex;
        $length = max($diffLength, $originLength);

        for ($shift = 0; $shift < $length; $shift++) {
            $this->sentences[] = $this->createChangeSentence($dirtyDiffIndex, $dirtyOriginIndex);
            $dirtyDiffIndex++;
            $dirtyOriginIndex++;
        }
    }

    /**
     * @param $startDiffIndex
     */
    private function saveAddedSentences($startDiffIndex)
    {
        for ($diffIndex = $startDiffIndex; $diffIndex < $this->diffLength; $diffIndex++) {
            $diffText = $this->diffText[$diffIndex];
            $this->sentences[] = Sentence::createCompared($diffText, $this->originIndex, $diffIndex, Sentence::ADDED);
        }
    }

    /**
     * @param $startOriginIndex
     */
    private function saveDeletedSentences($startOriginIndex)
    {
        for ($originIndex = $startOriginIndex; $originIndex < $this->originLength; $originIndex++) {
            $originText = $this->originText[$originIndex];
            $this->sentences[] = Sentence::createCompared($originText, $originIndex, $this->diffIndex, Sentence::DELETED);
        }
    }

    /**
     * @return bool
     */
    private function isSameSentences()
    {
        return ($this->getDiffSentence()->getText() == $this->getOriginSentence()->getText());
    }

    /**
     * @return mixed
     */
    private function getOriginSentence()
    {
        return $this->originText[$this->originIndex];
    }

    /**
     * @return mixed
     */
    private function getDiffSentence()
    {
        return $this->diffText[$this->diffIndex];
    }


    /**
     * @return Sentence
     */
    private function createCommonSentence()
    {
        return Sentence::createCompared(
            $this->getDiffSentence(), $this->originIndex, $this->diffIndex,
            Sentence::COMMON, $this->getOriginSentence()
        );
    }

    /**
     * @param $dirtyOriginIndex
     * @param $dirtyDiffIndex
     * @return Sentence
     */
    private function createChangeSentence($dirtyOriginIndex , $dirtyDiffIndex)
    {
        if ($dirtyOriginIndex >= $this->originIndex) {
            $diffText = $this->diffText[$dirtyDiffIndex];
            return Sentence::createCompared($diffText, $this->originIndex, $dirtyDiffIndex, Sentence::ADDED);
        } elseif ($dirtyDiffIndex >= $this->diffIndex) {
            $originText = $this->originText[$dirtyOriginIndex];
            return Sentence::createCompared($originText, $dirtyOriginIndex, $this->diffIndex, Sentence::DELETED);
        }

        $diffText = $this->diffText[$dirtyDiffIndex];
        $originText = $this->originText[$dirtyOriginIndex];
        return Sentence::createCompared($diffText, $dirtyOriginIndex, $dirtyDiffIndex, Sentence::EDITED, $originText);
    }


    /**
     *
     */
    private function shiftToMinSameSentence()
    {
        $sameOriginIndexes = [];
        for($diffIndex = $this->diffIndex; $diffIndex < $this->diffLength; $diffIndex++) {
            $sameOriginIndexes[$diffIndex] = $this->findSameOriginIndexForDiff($diffIndex, $this->originIndex);
        }


        $this->originIndex = min($sameOriginIndexes);
        if ($this->originIndex == $this->originLength) {
            $this->diffIndex = $this->diffLength;
        } else {
            $this->diffIndex = min(array_keys(
                array_filter(
                    $sameOriginIndexes,
                    function ($originIndex) {
                        return $originIndex == $this->originIndex;
                    }
                )
            ));
        }
    }


    /**
     * @param $diffIndex
     * @param $originStart
     * @return int
     */
    private function findSameOriginIndexForDiff($diffIndex, $originStart)
    {
        for($originIndex = $originStart; $originIndex < $this->originLength; $originIndex++) {
            if ($this->diffText[$diffIndex]->getText() == $this->originText[$originIndex]->getText()) {
                return $originIndex;
            }
        }
        return $this->originLength;
    }




}