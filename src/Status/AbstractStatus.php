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


abstract class AbstractStatus implements StatusInterface
{
	/** @var int */
	protected $status;

	/**
	 * AbstractStatuc constructor.
	 * @param int $status
	 */
	public function __construct(int $status)
	{
		$this->status = $status;
	}

	/**
	 * @inheritDoc
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 * @inheritDoc
	 */
	public function toJSON(): string
	{
		return json_encode( $this->getJSONFields(), JSON_UNESCAPED_SLASHES );
	}

	/**
	 * Gets a list with the JSON properties to be encoded.
	 *
	 * @return array
	 */
	protected function getJSONFields(): array {
		return [
			'status' => $this->getStatus()
		];
	}
}