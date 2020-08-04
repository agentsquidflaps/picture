<?php

use Agentsquidflaps\Picture\MediaQuery;
use Agentsquidflaps\Picture\Picture;
use Agentsquidflaps\Picture\Source;

if (function_exists('app')) {
	if (!function_exists('picture')) {
		/**
		 * @param Source[] | array $sources
		 * @return Picture
		 */
		function picture($sources = []) {
			return app(Picture::class)->setSources($sources);
		}
	}

	if (!function_exists('source')) {
		/**
		 * @return Source
		 */
		function source() {
			return app(Source::class);
		}
	}

	if (!function_exists('mediaQuery')) {
		/**
		 * @return MediaQuery
		 */
		function mediaQuery() {
			return app(MediaQuery::class);
		}
	}
}