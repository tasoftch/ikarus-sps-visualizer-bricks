<?php
/**
 * Copyright (c) 2020 TASoft Applications, Th. Abplanalp <info@tasoft.ch>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Ikarus\SPS\Visualizer\Brick;


abstract class AbstractBrick implements BrickInterface
{
	private $clickable = false;

	public static $scaleFactor = 1;


	/** @var int */
	public $x, $y, $width, $height;
	/**
	 * Use bitwise combinations of the TRANSFORMATION_* constants
	 *
	 * @var int
	 */
	public $transformation = 0;


	/**
	 * AbstractBrick constructor.
	 * @param int|AbstractBrick $x
	 * @param $y
	 * @param $width
	 * @param $height
	 * @param bool $clickable
	 */
	public function __construct($x = 0, $y = 0, $width = 1, $height = 1, bool $clickable = false)
	{
		if($x instanceof AbstractBrick) {
			$this->x = $x->x;
			$this->y = $x->y;
			$this->width = $x->width;
			$this->height = $x->height;
			$this->transformation = $x->transformation;
		} else {
			$this->x = $x * static::$scaleFactor;
			$this->y = $y * static::$scaleFactor;
			$this->width = $width * static::$scaleFactor;
			$this->height = $height * static::$scaleFactor;
		}
		$this->clickable = $clickable;
	}



	/**
	 * @inheritDoc
	 */
	public function toHTML(int $indent = 0)
	{
		$cl = $this->isClickable() ? ' clickable' : '';
		$vb = $this->getBoundingBox();

		$t = "";
		if($this->transformation & static::TRANSFORMATION_ROTATE_90)
			$t = ' r-90';
		elseif($this->transformation & static::TRANSFORMATION_ROTATE_180)
			$t = ' r-180';
		elseif($this->transformation & static::TRANSFORMATION_ROTATE_270)
			$t = ' r-270';
		if($this->transformation & static::TRANSFORMATION_FLIP_HORIZONTAL)
			$t .= ' flip-h';
		elseif($this->transformation & static::TRANSFORMATION_FLIP_VERTICAL)
			$t .= ' flip-v';

		$str = "<svg version='1.1' class='brick$cl$t x-$this->x y-$this->y w-$this->width h-$this->height' viewBox='$vb'>";
		$str .= $this->renderPath();
		$str .= "</svg>";
		return $str;
	}

	protected function getBoundingBox() {
		return "0 0 100 100";
	}

	/**
	 * @return bool
	 */
	public function isClickable(): bool
	{
		return $this->clickable;
	}

	/**
	 * @param bool $clickable
	 * @return static
	 */
	public function setClickable(bool $clickable)
	{
		$this->clickable = $clickable;
		return $this;
	}

	public function __toString()
	{
		return $this->toHTML();
	}

	/**
	 * @param int $transformation
	 * @return static
	 */
	public function transform(int $transformation) {
		$this->transformation = $transformation;
		return $this;
	}

	/**
	 * @param int $delta
	 * @return static
	 */
	public function shiftX(int $delta = 1) {
		$this->x += $delta * $this->width;
		return $this;
	}

	/**
	 * @param int $delta
	 * @return static
	 */
	public function shiftY(int $delta = 1) {
		$this->y += $delta * $this->height;
		return $this;
	}

	/**
	 * @param int $times
	 * @return static
	 */
	public function printX(int $times) {
		for($e=0;$e < abs($times);$e++) {
			echo $this->toHTML();
			$this->shiftX( $times < 0 ? -1 : 1 );
		}
		return $this;
	}

	/**
	 * @param int $times
	 * @return static
	 */
	public function printY(int $times) {
		for($e=0;$e < abs($times);$e++) {
			echo $this->toHTML();
			$this->shiftY( $times < 0 ? -1 : 1 );
		}
		return $this;
	}

	/**
	 * @param AbstractBrick $brick
	 * @param int $deltaX
	 * @param int $deltaY
	 * @param int|null $transformation
	 * @return AbstractBrick
	 */
	public function copyPosition(AbstractBrick $brick, int $deltaX = 0, int $deltaY = 0, int $transformation = NULL) {
		$brick->x = $this->x + $deltaX;
		$brick->y = $this->y + $deltaY;
		if(NULL !== $transformation)
			$brick->transformation = $transformation;
		return $brick;
	}

	abstract protected function renderPath();
}