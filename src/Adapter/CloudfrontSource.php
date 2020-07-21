<?php

namespace Agentsquidflaps\Picture\Adapter;

use Agentsquidflaps\Picture\AbstractSource;

/**
 * Class CloudfrontSource
 * @package Agentsquidflaps\Picture\Adapter
 */
class CloudfrontSource extends AbstractSource {
	/**
	 * @return string
	 */
	public function get(): string
	{
		$params = [
			'quality' => $this->getQuality()
		];

		if ($this->getWidth()) {
			$params['width'] = $this->getWidth();
		}

		if ($this->getHeight()) {
			$params['height'] = $this->getHeight();
		}

		if ($this->getFormat()) {
			$params['format'] = $this->getFormat();
		}

		if ($this->getFit()) {
			$params['fit'] = $this->getFit();
		}

		if ($this->getPosition()) {
			$params['position'] = $this->getPosition();
		}

		$securityToken = $this->createSecurityToken($params);

		return getenv('CLOUDFRONT_URL') . '/' . $securityToken . '/' . $this->parsedPath() . '?' . http_build_query($params);
	}

	private function parsedPath()
	{
		return trim($this->getPath(), '/');
	}

	private function createSecurityToken(array $params)
	{
		$params['token'] = getenv('CLOUDFRONT_SECRET');
		ksort($params);

		$parsedParams = array_map(function ($val) {
			return (string)$val;
		}, $params);

		return md5(json_encode($parsedParams, JSON_UNESCAPED_SLASHES));
	}
}
