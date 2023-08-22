var socket = require('socket.io'),
    express = require('express'),
    https = require('https'),
    http = require('http'),
    logger = require('winston');


logger.add(logger.transports.File, { filename: '/var/log/my-test-logs.log' });

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, {
    colorize: true,
    timestamp: true
});


logger.info('Server Listening on ...');


var app = express();

var http_server = http.createServer(app).listen(3001);

function emitNewOrder(http_server) {

	var	io = socket.listen(http_server,
	{ cors: { origin: "http://162.240.55.1", methods: ["GET", "POST"], transports: ['websocket', 'polling'], credentials: true }, allowEIO3: true }
	);


    io.sockets.on('connection', function(socket) {

		socket.on('join', function(data) {
			var room = data.company_id.toString();
			socket.join(room, function() {
				console.log("Socket now in rooms", socket.rooms);
			});
		});

		socket.on('newOrder', function(data) {
            logger.info('New Order Received: ' + data.alert_id + 'company: ' + data.company_id);
			//io.sockets.emit('newOrder', data);
			//socket.to(data.company_id.toString()).emit('newOrder', data);
			io.in(data.company_id.toString()).emit('newOrder', data);
		});

    });
}

emitNewOrder(http_server);


