<?php

namespace Agentsquidflaps\Picture;

use function \sprintf;

class MediaQuery
{
	const SIZE_SM = 576;
	const SIZE_ME = 768;
	const SIZE_LG = 992;
	const SIZE_XL = 1200;

	const SIZES = [
		'sm' => self::SIZE_SM,
		'me' => self::SIZE_ME,
		'lg' => self::SIZE_LG,
		'xl' => self::SIZE_XL,
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
	public function __construct(?array $sizes)
	{
		$this->sizes = $sizes ?: self::SIZES;
	}

	/**
	 * @return string|null
	 */
	public function getMinWidth(): ?string
	{
		return $this->minWidth;
	}

	/**
	 * @param string|null $minWidth
	 * @return MediaQuery
	 */
	public function setMinWidth(?string $minWidth): MediaQuery
	{
		$this->minWidth = $minWidth;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMaxWidth(): ?string
	{
		return $this->maxWidth;
	}

	/**
	 * @param string|null $maxWidth
	 * @return MediaQuery
	 */
	public function setMaxWidth(?string $maxWidth): MediaQuery
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
			$markup .= sprintf('min-width: %spx', self::SIZES[$this->getMinWidth()]);
		}

		if ($this->getMaxWidth()) {
			if ($markup) {
				$markup .= ' and ';
			}

			$markup .= sprintf('max-width: %spx', self::SIZES[$this->getMaxWidth()] + 1);
		}

		if ($markup) {
			$markup = '(' . $markup . ')';
		}

		return $markup;
	}

	public function __toString()
	{
		return $this->getMarkup();
	}
}
