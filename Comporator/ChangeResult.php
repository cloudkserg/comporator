<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 24.10.16
 * Time: 14:43
 */

class ChangeResult
{

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $diff;

    /**
     * @var int
     */
    private $type;


    public function __construct($start, $origin, $diff)
    {
        $this->start = $start;
        $this->origin = $origin;
        $this->diff = $diff;
    }

    public function addSymbol($origin, $diff)
    {
        $this->origin .= $origin;
        $this->diff .= $diff;
    }


}