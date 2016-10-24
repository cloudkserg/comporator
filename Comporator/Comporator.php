<?php
class Comporator
{

	protected $text1;

	protected $text2;

    protected $length1;

    protected $length2;

    /**
     * @var array
     */
    private $fixedPositions = array();

    /**
     * @var bool
     */
    protected $isSwapTexts = false;


    /**
     * @var bool
     */
    private $debug = false;

    /**
     * @var int
     */
    private $countChanges;

    /**
     * @param $inputText1
     * @param $inputText2
     */
	public function __construct($inputText1, $inputText2)
	{
        $this->setBiggerTextAsSecond($inputText1, $inputText2);
        $this->length1 = strlen($this->text1);
        $this->length2 = strlen($this->text2);

        $this->compare();
	}

    /**
     * @param $text1
     * @param $text2
     */
    private function setBiggerTextAsSecond($text1, $text2)
    {
        if (strlen($text1) >= strlen($text2)) {
            $this->isSwapTexts = true;
            list($text1, $text2) = array($text2, $text1);
        }

        $this->text1 = $text1;
        $this->text2 = $text2;
    }

    /**
     * @return int
     */
    public function getCountChanges()
    {
        return $this->countChanges;
    }



    /**
     *
     *  _____a_____|(offset)____b____(delta)|
     *
     * @return int
     */
	protected function compare()
	{
		if ($this->text1 == $this->text2) {
			return 0;
		}

        $offset = $this->length1 + 1;
        $delta = $this->length2 - $this->length1;
        $size = $this->length1 + $this->length2 + 3;

        $this->fixedPositions = array_fill(0, $size + 1, -1);
        $index = -1;

        do {
            $index = $index + 1;

            $this->findStartChanges($index, $delta, $offset);
            $this->findEndChanges($index, $delta, $offset);

            $this->saveDeltaPosition($delta, $offset);
        } while ($this->fixedPositions[$delta+$offset] < $this->length2);

        $this->countChanges = $delta + 2*$index;

        r    = self.path[delta+offset]
      epc  = {}
      while r ~= -1 do
    epc[#epc+1] = self.P.new(self.pathposi[r+1].x, self.pathposi[r+1].y, nil)
            r = self.pathposi[r+1].k
      end
      self.recordseq(epc)
	}




    /**
     * @param int $delta
     * @param int $offset
     */
    private function saveDeltaPosition($delta, $offset)
    {
        $this->saveSnakePosition($offset + $delta, $delta);
    }

    /**
     * @param int $index
     * @param int $delta
     * @param int $offset
     *
     * index = 0 to (while value in fixedPositions[delta+offset] < length)
     *
     * snake from [delta + index] to delta
     *
     */
    private function findEndChanges($index, $delta, $offset)
    {
        for ($shiftDelta = $delta + $index; $shiftDelta >= $delta + 1; $shiftDelta = $shiftDelta -1) {
            $this->saveSnakePosition($offset + $shiftDelta, $shiftDelta);
        }
    }

    /**
     * @param int $index
     * @param int $delta
     * @param int $offset
     *
     * index = 0 to (while value in fixedPositions[delta+offset] < length)
     *
     * snake from [offset - index] to delta
     *
     * @return void
     */
    private function findStartChanges($index, $delta, $offset)
    {
        for ($shift = -$index; $shift <= $delta - 1; $shift = $shift +1) {
            $this->saveSnakePosition($offset + $shift, $shift);
        }
    }

    /**
     * @param int $position
     * @param int $shift
     */
    private function saveSnakePosition($position, $shift)
    {
        $this->fixedPositions[$position] =$this->snake($shift, $this->fixedPositions[$position-1]+1, $this->fixedPositions[$position+1]);
    }



    /**
     *
     * find position, where string changes
     *
     * @param int $shift
     * @param int $position
     * @param int $positionNext
     * @return int
     */
    private function snake($shift, $position, $positionNext)
    {
        $maxPosition = max($position, $positionNext);
        $newPosition = $maxPosition - $shift;

        while ($newPosition < $this->length1 and $maxPosition < $this->length2 and $this->text1[$newPosition] == $this->text2[$maxPosition]) {
            $newPosition = $newPosition + 1;
            $maxPosition = $maxPosition + 1;
        }
        return $maxPosition;

    }
}
