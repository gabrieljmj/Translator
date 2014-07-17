<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/
	
	namespace Translator\Http;

	use \RuntimeException;

	class Request{
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
		public function send( $url, $params = null, $header = null, $ssl = false, $post = false ){
			if( !$post ){
				$url .= ( is_array( $params ) && count( $params ) > 0 ) ? '?' . http_build_query( $params ) : $params;
			}

			$ch = curl_init();
            
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			( is_null( $header ) ) ?: curl_setopt( $ch, CURLOPT_HTTPHEADER, $header ) ;
			curl_setopt( $ch, CURLOPT_POST, $post );
			( !$post ) ?: curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $ssl );
            
			$return = curl_exec( $ch );

			if( !$return ){
				throw new RuntimeException( 'An error occurred with the request: ' . curl_error( $ch ) );
			}

			return $return;
		}
	}