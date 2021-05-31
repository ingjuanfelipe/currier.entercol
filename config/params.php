<?php
return [
	'currier' => [ // Credenciales de acceso al WS del Currier
		//'url' => 'http://cargopostal.uy:8080/axis2/services/WSPostalNet?wsdl',
		'url' => 'http://cargopostal.uy:8081/axis2/services/WSPostalNet/WSDespachar',
		'user' => '1489',
		'pass' => 'loliweb',
		'agenciaOrigen' => '001',
		'claveExterna' => 'AAAAAAAAAAAAA',
	],
	'adminEmail' => 'admin@example.com',
	'senderEmail' => 'noreply@example.com',
	'senderName' => 'Example.com mailer',
];
