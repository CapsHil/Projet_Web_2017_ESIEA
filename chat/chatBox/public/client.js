/*global io, rivets, utils*/
/*jslint browser: true*/

var socket = io();
var i, j;

//msg list
var messages = [];

// userlist
var users = [];


/*** DataBinding initial ***/

rivets.bind($('#messages'), { messages: messages });
rivets.bind($('#users'), { users: users });


/*** Event management ***/

//user co only if username not empty and not used

$('#login form').submit(function(e) {
    e.preventDefault();
    var user = {
        username: $('#login input').val().trim()
    };
    if (user.username.length > 0) { // Si le champ de connexion n'est pas vide
        socket.emit('user-login', user, function(success) {
            if (success) {
                $('body').removeAttr('id'); // Cache formulaire de connexion
                $('#chat input').focus(); // Focus sur le champ du message
            }
        });
    }
});

//sending message
$('#chat form').submit(function(e) {
    e.preventDefault();
    var message = {
        text: $('#m').val()
    };
    $('#m').val('');
    if (message.text.trim().length !== 0) { // Gestion message vide
        socket.emit('chat-message', message);
    }
    $('#chat input').focus(); // Focus sur le champ du message
});

//msg reception
socket.on('chat-message', function(message) {
    message.label = message.username;
    messages.push(message);
    utils.scrollToBottom();
});

//recep msg service
socket.on('service-message', function(message) {
    message.label = 'information';
    messages.push(message);
    utils.scrollToBottom();
});

//signin
socket.on('user-login', function(user) {
    users.push(user);
    setTimeout(function() {
        $('#users li.new').removeClass('new');
    }, 1000);
});

//signout 
socket.on('user-logout', function(user) {
    var userIndex = users.indexOf(user);
    if (userIndex !== -1) {
        users.splice(userIndex, 1);
    }
});

//user detection
var typingTimer;
var isTyping = false;

$('#m').keypress(function() {
    clearTimeout(typingTimer);
    if (!isTyping) {
        socket.emit('start-typing');
        isTyping = true;
    }
});

$('#m').keyup(function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function() {
        if (isTyping) {
            socket.emit('stop-typing');
            isTyping = false;
        }
    }, 500);
});

//manage typing of other user
socket.on('update-typing', function(typingUsers) {
    for (i = 0; i < users.length; i++) {
        users[i].typing = false;
    }
    for (i = 0; i < typingUsers.length; i++) {
        for (j = 0; j < users.length; j++) {
            if (typingUsers[i].username === users[j].username) {
                users[j].typing = true;
                break;
            }
        }
    }
});