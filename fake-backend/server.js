var express = require('express');

var app = express();

app.get('/extract', function(req, res) {
	res.setHeader('Content-Type', 'application/json')
	let answer = Math.floor(Math.random() * (4 - 1 + 1)) + 1;
	res.send(JSON.stringify({
	"extractFilename": "sound.mp3",
	"correctAnswer": answer
}));
});

app.listen(8081);
