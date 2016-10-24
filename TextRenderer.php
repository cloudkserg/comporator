<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 18:15
 */

class TextRenderer
{

    /**
     * @var Sentence[]
     */
    private $sentences;

    /**
     * @param Sentence[] $sentences
     */
    public function __construct(array $sentences)
    {
        $this->sentences = $sentences;
    }


    public function getText()
    {
        $content = '';
        foreach ($this->sentences as $sentence)
        {
            if ($sentence->getType() == Sentence::COMMON) {
                $content .= $this->text($sentence);
            } else {
                $content .= $this->wrapper($sentence);
            }
        }
        return $content;
    }

    private function text(Sentence $sentence)
    {
        $content = htmlentities($sentence->getText());
        if ($sentence->getEndSign() !== null) {
            $content .= $sentence->getEndSign();
        }
        return $content;
    }

    private function wrapper(Sentence $sentence)
    {
        return '<span
            data-origin="' . $this->getOrigin($sentence) . '"
            class="' . $this->getClass($sentence->getType()) . '">' .
        $this->text($sentence) .
        "</span>";
    }

    private function getOrigin(Sentence $sentence)
    {
        if ($sentence->getOriginText() == null) {
            return '';
        }
        return htmlentities($sentence->getOriginText());
    }

    /**
     * @param $sentenceType
     * @return mixed
     */
    private function getClass($sentenceType)
    {
        $types = [
            Sentence::ADDED => 'add',
            Sentence::EDITED => 'edit',
            Sentence::DELETED => 'delete'
        ];
        if (isset($types[$sentenceType])) {
            return $types[$sentenceType];
        }

        return '';
    }

}