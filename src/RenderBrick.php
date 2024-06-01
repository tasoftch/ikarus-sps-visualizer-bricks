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


use Ikarus\SPS\Visualizer\Brick\Render\BrickRenderInterface;
use Ikarus\SPS\Visualizer\Brick\Render\ConfiguredBrickRenderInterface;

class RenderBrick extends AbstractBrick
{
	/** @var BrickRenderInterface|null */
	private $render;

	/**
	 * @return BrickRenderInterface|null
	 */
	public function getRender(): ?BrickRenderInterface
	{
		return $this->render;
	}

	/**
	 * @param BrickRenderInterface $render
	 * @return static
	 */
	public function setRender(BrickRenderInterface $render)
	{
		$this->render = $render;
		return $this;
	}

	public function setClickable(bool $clickable)
	{
		if($this->render instanceof ConfiguredBrickRenderInterface)
			$clickable = $this->render->isClickable() ? $clickable : false;

		parent::setClickable($clickable);
		return $this;
	}

	public function toHTML(int $indent = 0)
	{
		if($this->render instanceof ConfiguredBrickRenderInterface)
			$this->transformation = $this->transformation & $this->render->getAllowedTransformations();
		return parent::toHTML($indent);
	}

	protected function getBoundingBox()
	{
		if(!$this->getRender())
			trigger_error("Can not render brick", E_USER_WARNING);
		else
			return $this->getRender()->getBoundingBox();
		return parent::getBoundingBox();
	}

	protected function getCSSClasses()
    {
        if(method_exists($r = $this->getRender(), 'getCSSClasses'))
            return $r->getCSSClasses();
        return [];
    }

    protected function renderPath()
	{
		if(!$this->getRender())
			trigger_error("Can not render brick", E_USER_WARNING);
		else {
			return $this->getRender()->renderSVG($this);
		}
		return "";
	}
}