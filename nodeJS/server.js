var http = require('http');
var url = require('url');

function start (route, handle) {
	function onRequest (request, response) {
		var pathname = url.parse(request.url).pathname;
		console.log('Petición para ' + pathname + ' recibida.');
		
		response.writeHead(200, {'Content-Type': 'text/plain'});
		var content = route(handle, pathname);
		response.write(content);
		response.end();
	}
	
	http.createServer(onRequest).listen(8888);
	console.log('Servidor Iniciado');
}

exports.start = start;