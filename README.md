# ESIEA WEB PROJECT 2017
## AIL5MAJ - INF5041

### How to run all services

Assume that you have docker-compose version 1.16.1 or later installed
- `docker-compose up`

### Run fake backend
- In `fake-backend`
- `npm install`
- `npm start`

## Backend architecture

The backend rely on a couple of REST APIs.
It expects format passed either via GET or POST.
It returns a JSON format containing a `status` entry containing either `success` or  `error`.
If `error` was returned, a short message describing the issue is appended in an `error` entry.

### Overview

| Component | Method | Description | Arguments | Output on success |
| ---- | ---- | ------------ | ------------ | --------- |
| **test.php** | GET | Provide test data | `nbSuggestions` containing the number of plausible answers to return. This parameter is optionnal, the API will default to 4 suggestions. | `songID` (the ID the real song), `filename` (the name of the file to play), `suggestions` (an array of items containing the `songID` of the suggestion, `trackName` and `artistName` to craft the suggestion). In order to let the frontend format it properly, the trackname and the artist name aren't merged beforehand |
| **messages.php** | GET | Return recent messages | `nbMessages` the maximum number of messages to return. This parameter is optional, the API will default to 200 messages. | Return messages sent since a givent `lastMessageID` | `lastMessageID` containing the ID of the lastest message returned by the API and `messages`, an array of messages sorted from earliest to lastest composed items containing `messageText`, `user` and `time` |
| **messages.php** | GET | Return messages sent since `lastMessageID` | `lastMessageID` (the last message of the previous request, will only returns messages after this one) and optionnally `nbMessages` (same default as `getMessages.php`). | Same output as `getMessages.php`
| **messages.php** | POST | Post a message to the chatbox | `userName` of the user posting, `message` to post | None |
| **genres.php** | GET | Get available genres | None | JSON with a `genres` entry containing an array of couples `name` and `ID`  |
| **genres.php** | POST | Create a new genre | `name`, the name of the genre to create | `genreID`, containing the newly created ID of a genre with the name provided. If a genre with the same name already existed, its ID is provided. |
| **song.php** | POST | Create a new song | `trackName`, `artist` and `genre` (the genre must be a valid genre ID). The name of the field passed as the source of the file is expected to be `fileToUpload` | None |
| **topScores.php** | GET | Get highest ranking users with their high scores | `nbResults`, the maximum number of top results expected. This parameter is optionnal, the API will default to 20 top scores. | `scores`, an array of items containing `rank` (counter starting from 1), `user` (the name of the user), `score` (the number of maximum correct answer for this user) |
| **topScores.php** | POST | Commit top score to database | `name` of the current user, `strike` containing the score | None |
