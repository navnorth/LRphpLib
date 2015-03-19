<?PHP

	class LearningRegistryConnect{
	
		function __construct(){
		}
		
		function connect(){
		
			$client = new GuzzleHttp\Client();
			$response = $client->get('http://guzzlephp.org', 
				[
					'config' => [
						'curl' => [
							CURLOPT_SSL_VERIFYHOST => false,
							CURLOPT_SSL_VERIFYPEER => false,
						]
					]
				]
			);			
			$res = $client->get('https://api.github.com/user', 
				[
					'auth' =>  ['pgogy', 'Fearher0!'],
					'config' => [
						'curl' => [
							CURLOPT_SSL_VERIFYHOST => false,
							CURLOPT_SSL_VERIFYPEER => false,
						]
					]
				]
			);
			echo $res->getStatusCode();
			// "200"
			echo $res->getHeader('content-type');
			// 'application/json; charset=utf8'
			echo $res->getBody();
			// {"type":"User"...'
			var_export($res->json());
			// Outputs the JSON decoded data

			// Send an asynchronous request.
			$req = $client->createRequest('GET', 'http://httpbin.org', ['future' => true]);
			$client->send($req)->then(function ($response) {
				echo 'I completed! ' . $response;
			});
		
		}
	
	}