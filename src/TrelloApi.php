<?php
namespace cjrasmussen\TrelloApi;

use RuntimeException;

/**
 * Class Trello
 * @package O6
 */
class TrelloApi
{
	private $key;
	private $token;

	public function __construct($key, $token)
	{
		$this->key = $key;
		$this->token = $token;
	}

	/**
	 * Make a request to the Trello API
	 *
	 * @param string $type
	 * @param string $request
	 * @param array|null $args
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function request($type, $request, ?array $args = [])
	{
		if (false !== strpos($request, '?')) {
			$url = 'https://api.trello.com' . $request . '&key=' . $this->key . '&token=' . $this->token;
		} else {
			$url = 'https://api.trello.com' . $request . '?key=' . $this->key . '&token=' . $this->token;
		}

		$c = curl_init();
		curl_setopt($c, CURLOPT_HEADER, 0);
		curl_setopt($c, CURLOPT_VERBOSE, 0);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $url);

		if (count($args)) {
			curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($args));
		}

		switch ($type) {
			case 'POST':
				curl_setopt($c, CURLOPT_POST, 1);
				break;
			case 'GET':
				curl_setopt($c, CURLOPT_HTTPGET, 1);
				break;
			default:
				curl_setopt($c, CURLOPT_CUSTOMREQUEST, $type);
		}

		$response = curl_exec($c);
		curl_close($c);

		// DECODE THE RESPONSE INTO A GENERIC OBJECT
		$data = json_decode($response);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new RuntimeException('API response was not valid JSON');
		}

		return $data;
	}
}
