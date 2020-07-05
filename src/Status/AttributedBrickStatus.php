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

namespace Ikarus\SPS\Visualizer\Brick\Status;


class AttributedBrickStatus extends BrickStatus
{
	/** @var array  */
	protected $attributes = [];

	/**
	 * AttributedBrickStatus constructor.
	 * @param string $id
	 * @param int $status
	 * @param array $attributes
	 */
	public function __construct(string $id, int $status, array $attributes = [])
	{
		parent::__construct($id, $status);
		$this->attributes = $attributes;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize()
	{
		return serialize([
			$this->id,
			$this->status,
			$this->attributes
		]);
	}

	/**
	 * @inheritDoc
	 */
	public function unserialize($serialized)
	{
		list($this->id, $this->status, $this->attributes) = unserialize($serialized);
	}

	/**
	 * @return array
	 */
	public function getAttributes(): array
	{
		return $this->attributes;
	}

	/**
	 * Defines a new attribute
	 *
	 * @param $name
	 * @param $value
	 * @return static
	 */
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * Removes an attribute
	 *
	 * @param $name
	 * @return static
	 */
	public function removeAttribute($name) {
		unset($this->attributes[$name]);
		return $this;
	}

	protected function getJSONFields(): array
	{
		return [
			'id' => $this->getID(),
			"status" => $this->getStatus(),
			"attributes" => $this->getAttributes()
		];
	}
}