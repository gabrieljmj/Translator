<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator\Http;

	interface RequestInterface
	{
		/**
		 * Send a HTTP request
		 *
		 * @param string            $url
		 * @param array|string|null $params
		 * @param string|null       $header
		 * @param boolean           $ssl
		 * @param boolean           $post
		 * @return string
		*/
		public function send($url, $params = null, $header = null, $ssl = false, $post = false);
	}