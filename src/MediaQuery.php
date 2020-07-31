<?php

namespace Agentsquidflaps\Picture;

use function \sprintf;

class MediaQuery
{
	const SIZE_SM = 'sm';
	const SIZE_ME = 'me';
	const SIZE_LG = 'lg';
	const SIZE_XL = 'xl';

	const SIZES = [
		self::SIZE_SM => 576,
		self::SIZE_ME => 768,
		self::SIZE_LG => 992,
		self::SIZE_XL => 1200,
	];

	/** @var string | null */
	private $minWidth;

	/** @var string | null */
	private $maxWidth;

	/** @var array */
	private $sizes;

	/**
	 * MediaQuery constructor.
	 * @param array $sizes
	 */
	public function __construct(array $sizes = [])
	{
		$this->sizes = count($sizes) ? $sizes : self::SIZES;
	}

	/**
	 * @return string|null
	 */
	public function getMinWidth()
	{
		return $this->minWidth;
	}

	/**
	 * @param string|null $minWidth
	 * @return MediaQuery
	 */
	public function setMinWidth(string $minWidth = ''): MediaQuery
	{
		$this->minWidth = $minWidth;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMaxWidth()
	{
		return $this->maxWidth;
	}

	/**
	 * @param string|null $maxWidth
	 * @return MediaQuery
	 */
	public function setMaxWidth(string $maxWidth = ''): MediaQuery
	{
		$this->maxWidth = $maxWidth;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMarkup()
	{
		$markup = '';

		if ($this->getMinWidth()) {
			$markup .= sprintf('(min-width: %spx)', $this->sizes[$this->getMinWidth()]);
		}

		if ($this->getMaxWidth()) {
			if ($markup) {
				$markup .= ' and ';
			}

			$markup .= sprintf('(max-width: %spx)', $this->sizes[$this->getMaxWidth()] - 1);
		}

		return $markup;
	}

	public function __toString()
	{
		return $this->getMarkup();
	}
}
