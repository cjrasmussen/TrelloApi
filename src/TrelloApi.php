<?php

namespace cjrasmussen\TrelloApi;

use JsonException;

/**
 * Class Trello
 */
class TrelloApi
{
	private string $key;
	private string $token;

	public function __construct(string $key, string $token)
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
	 * @throws JsonException
	 */
	public function request(string $type, string $request, ?array $args = [])
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

		if (count($args)) {
			curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($args));
		} elseif ($type === 'POST') {
			curl_setopt($c, CURLOPT_POSTFIELDS, null);
		}

		$response = curl_exec($c);
		curl_close($c);

		return json_decode($response, false, 512, JSON_THROW_ON_ERROR);
	}
}
