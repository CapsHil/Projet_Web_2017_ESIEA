# ESIEA WEB PROJECT 2017
## AIL5MAJ - INF5041

### How to run in development mode
- `./run-dev.sh`
or
- `docker run --rm -v $(pwd):/src -w /src -p 8080:8080 node:6 bash -c "npm install && npm run dev"` in `webapp/src/` folder

### How to run in production mode
- `./run-prod.sh`
or
- `docker run --rm -v $(pwd):/src -w /src node:6 bash -c "npm install && npm run build"` in `webapp/src/` folder

## Backend architecture

The backend rely on a couple of REST APIs.
It expects format passed either via GET or POST.
It returns a JSON format containing a `status` entry containing either `success` or  `error`.
If `error` was returned, a short message describing the issue is appended in an `error` entry.

### Overview

| Component | API | Arguments | Output on success |
| ---- | ---- | ------------ | --------- |
| **Blindtest** | getTest.php | `nbSuggestions` containing the number of plausible answers to return. This parameter is optionnal, the API will default to 4 suggestions. | `songID` (the ID the real song), `filename` (the name of the file to play), `suggestions` (an array of items containing the `songID` of the suggestion, `trackName` and `artistName` to craft the suggestion). In order to let the frontend format it properly, the trackname and the artist name aren't merged beforehand |
| **Blindtest** | validateTest.php | `userID` of the current user, `songID` of the song playing, `answer` (the ID of the selection) | `correct` containing a boolean |
| **Chatbox** | getMessages.php | `nbMessages` the maximum number of messages to return. This parameter is optional, the API will default to 200 messages. | `lastMessageID` containing the ID of the lastest message returned by the API and `messages`, an array of messages sorted from earliest to lastest composed items containing `messageText`, `user` and `time` |
| **Chatbox** | getNewMessages.php | `lastMessageID` (the last message of the previous request, will only returns messages after this one) and optionnally `nbMessages` (same default as `getMessages.php`). | Same output as `getMessages.php`
| **Chatbox** | sendMessage.php | `userID` of the user posting, `message` to post | None |
| **Music upload** | getGenres.php | None | JSON with a `genres` entry containing an array of couples `name` and `ID`  |
| **Music upload** | registerGenre.php | `name`, the name of the genre to create | `genreID`, containing the newly created ID of a genre with the name provided. If a genre with the same name already existed, its ID is provided. |
| **Music upload** | createSong.php | `trackName`, `artist` and `genre` (the genre must be a valid genre ID). The name of the field passed as the source of the file is expected to be `fileToUpload` | None |
| **Score board** | getTopScores.php | `nbResults`, the maximum number of top results expected. This parameter is optionnal, the API will default to 20 top scores. | `scores`, an array of items containing `rank` (counter starting from 1), `user` (the name of the user), `score` (the number of maximum correct answer for this user) |
| **User Management** | registerUser.php | `name`, `email` and `password` | None |
| **User Management** | loginUser.php | `name` and `password` | `userID` of the logged in user |
| **User Management** | deleteUser.php | `name` and `password` | None |
