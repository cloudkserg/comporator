<?php

/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 15:01
 */

class Sentence
{
    const COMMON = 'common';
    const DELETED = 'delete';
    const EDITED = 'edit';
    const ADDED = 'add';

    private $originIndex;

    private $type;

    private $text;

    private $diffIndex;

    private $originText;

    private $endSign = '.';

    public static function createCompared(Sentence $sentence, $originIndex, $diffIndex, $type, Sentence $originText = null)
    {
        $endSign = $sentence->getEndSign();
        if (isset($originText) and !isset($endSign)) {
            $endSign = $originText->getEndSign();
        }
        $item = new self($sentence->getText(), $endSign);
        $item->setType($type);
        $item->setOriginIndex($originIndex);
        $item->setDiffIndex($diffIndex);


        $item->setOriginText(isset($originText) ? $originText->getText() . $endSign : '');
        return $item;
    }

    public function __construct($text, $endSign)
    {
        $this->text = $text;
        $this->endSign = $endSign;
    }

    /**
     * @return mixed
     */
    public function getOriginIndex()
    {
        return $this->originIndex;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getDiffIndex()
    {
        return $this->diffIndex;
    }

    /**
     * @return null
     */
    public function getOriginText()
    {
        return $this->originText;
    }

    /**
     * @param string $endSign
     */
    public function setEndSign($endSign)
    {
        $this->endSign = $endSign;
    }

    /**
     * @param mixed $originText
     */
    public function setOriginText($originText)
    {
        $this->originText = $originText;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $originIndex
     */
    public function setOriginIndex($originIndex)
    {
        $this->originIndex = $originIndex;
    }

    /**
     * @param mixed $diffIndex
     */
    public function setDiffIndex($diffIndex)
    {
        $this->diffIndex = $diffIndex;
    }

    /**
     * @return string
     */
    public function getEndSign()
    {
        return $this->endSign;
    }


}