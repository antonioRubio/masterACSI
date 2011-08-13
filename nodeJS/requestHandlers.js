var exec = require("child_process").exec;

function start() {
	console.log("Manejador 'start' llamado.");
	/*
	function sleep(milliSeconds) {
		var startTime = new Date().getTime();
		while (new Date().getTime() < startTime + milliSeconds);
	}
	sleep(10000);
	*/
	var content = "empty";
	
	exec("ls -lah", function (error, stdout, stderr) {
	  content = stdout;
	});
	return content;
}

function upload() {
	console.log("Manejador 'upload' llamado.");
	return "Hola upload";
}

exports.start = start;
exports.upload = upload;