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

namespace Ikarus\SPS\Visualizer\Brick\Render;


use Ikarus\SPS\Visualizer\Brick\BrickInterface;

class CallbackBrickRender implements BrickRenderInterface
{
	private $w = 0, $h = 0;
	/** @var callable */
	private $callback;

	/**
	 * CallbackBrickRender constructor.
	 * @param callable $callback
	 * @param int $w
	 * @param int $h
	 */
	public function __construct(callable $callback, int $w = 100, int $h = 100)
	{
		$this->w = $w;
		$this->h = $h;
		$this->callback = $callback;
	}


	/**
	 * @inheritDoc
	 */
	public function getBoundingBox(): string
	{
		return "0 0 $this->w $this->h";
	}

	/**
	 * @inheritDoc
	 */
	public function renderSVG(BrickInterface $brick): string
	{
		return call_user_func($this->getCallback(), $brick);
	}

	/**
	 * @return callable
	 */
	public function getCallback(): callable
	{
		return $this->callback;
	}
}