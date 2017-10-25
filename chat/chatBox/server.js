var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var i;

/**
 * Gestion des requêtes HTTP des utilisateurs en leur renvoyant les fichiers du dossier 'public'
 */
app.use('/', express.static(__dirname + '/public'));

//list connected users
var users = [];

//history
var messages = [];

//list user typing smthg
var typingUsers = [];

io.on('connection', function(socket) {

    //user co to socket
    var loggedUser;

    //send msg for each login
    for (i = 0; i < users.length; i++) {
        socket.emit('user-login', users[i]);
    }

    //send msg for all msg in history
    for (i = 0; i < messages.length; i++) {
        if (messages[i].type === 'chat-message') {
            socket.emit('chat-message', messages[i]);
        } else {
            socket.emit('service-message', messages[i]);
        }
    }

    /**
     * Déconnexion d'un utilisateur
     */
    socket.on('disconnect', function() {
        if (loggedUser !== undefined) {
            // Broadcast d'un 'service-message'
            var serviceMessage = {
                text: 'User "' + loggedUser.username + '" disconnected',
                type: 'logout'
            };
            socket.broadcast.emit('service-message', serviceMessage);
            // del from userlist
            var userIndex = users.indexOf(loggedUser);
            if (userIndex !== -1) {
                users.splice(userIndex, 1);
            }
            // add msg to hist
            messages.push(serviceMessage);
            // Emission d'un 'user-logout' contenant le user
            io.emit('user-logout', loggedUser);
            // Si jamais il était en train de saisir un texte, on l'enlève de la liste
            var typingUserIndex = typingUsers.indexOf(loggedUser);
            if (typingUserIndex !== -1) {
                typingUsers.splice(typingUserIndex, 1);
            }
        }
    });

    // co user via from :

    socket.on('user-login', function(user, callback) {
        // check user does not exist
        var userIndex = -1;
        for (i = 0; i < users.length; i++) {
            if (users[i].username === user.username) {
                userIndex = i;
            }
        }
        if (user !== undefined && userIndex === -1) { // S'il est bien nouveau
            // Save user + add t connected users
            loggedUser = user;
            users.push(loggedUser);
            // Envoi et sauvegarde des messages de service
            var userServiceMessage = {
                text: 'You logged in as "' + loggedUser.username + '"',
                type: 'login'
            };
            var broadcastedServiceMessage = {
                text: 'User "' + loggedUser.username + '" logged in',
                type: 'login'
            };
            socket.emit('service-message', userServiceMessage);
            socket.broadcast.emit('service-message', broadcastedServiceMessage);
            messages.push(broadcastedServiceMessage);
            // Emission de 'user-login' et appel du callback
            io.emit('user-login', loggedUser);
            callback(true);
        } else {
            callback(false);
        }
    });

    //reception event + send to all users

    socket.on('chat-message', function(message) {
        // add username + event
        message.username = loggedUser.username;
        // On assigne le type "message" à l'objet
        message.type = 'chat-message';
        io.emit('chat-message', message);
        // Save msg
        messages.push(message);
        if (messages.length > 150) {
            messages.splice(0, 1);
        }
    });

    //user starts typing
    socket.on('start-typing', function() {
        // add user list typing users
        if (typingUsers.indexOf(loggedUser) === -1) {
            typingUsers.push(loggedUser);
        }
        io.emit('update-typing', typingUsers);
    });

    // user stops typing
    socket.on('stop-typing', function() {
        var typingUserIndex = typingUsers.indexOf(loggedUser);
        if (typingUserIndex !== -1) {
            typingUsers.splice(typingUserIndex, 1);
        }
        io.emit('update-typing', typingUsers);
    });
});

//lance server listen port 8080
http.listen(8080, function() {
    console.log('Server is listening on *:8080');
});