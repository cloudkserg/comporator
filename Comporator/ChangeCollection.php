<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 14:41
 */

class ChangeCollection
{

    private $changes;

    public function __construct(array $changes, $text1, $text2)
    {
        $this->changes = $this->parseChanges($changes, $text1, $text2);
    }

    private function isEmptyChange($change)
    {
        return $change === -1;
    }


    private function parseChanges(array $changes, $text1, $text2)
    {
        foreach ($changes as $change) {
            if (!$this->isEmptyChange($change)) {
                if not createResult -> create
                    ->
                    add to Result change if
                get next c
            }
        }

    }


    private function createChangeResult($change, $text1, $text2)
    {
        return new ChangeResult($change, $text1[$change], $text2[$change]);
    }


    public function getChanges()
    {
        return $this->changes;
    }

}
