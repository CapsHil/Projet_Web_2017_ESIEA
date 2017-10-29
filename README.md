# ESIEA WEB PROJECT 2017
## AIL5MAJ - INF5041

This project was made by FALEMPIN Charlotte, GILLES Vincent, MARIAUX Corentin, RABY Pierre and SPIR Émile-Hugo

This web application based on Vuejs 2.4, is a musical quizz game.

### Blind-test rules

  You have 3 game modes :
  - Classic with 4 propositions
  - Classic without propositions
  - Ranked with 4 propositions : number of extracts are fixed, and you will be able to record your score at the end of the game
  
  In classic mode, you can choose your number of extracts.
  You also could choose your category (like series, films, 80s, classic...).
  
  You will have 10 seconds unless you click on button, and then 3 seconds to see the answer.
  If you play without propositions, you can skip the extract when you found it.
  
  Dont't forget to turn on the speaker ;-)
  
  *Enjoy !*
  
  Note : Due to the fact that the project is not deployed in production, you only have few extracts in `Serie/Film` and `Musique`, but you can easily add many extracts and categories by addind them to the database.

### How to run all services

Assume that you have Docker (https://docs.docker.com/engine/installation/) and docker-compose version 1.16.1 or later installed (https://docs.docker.com/compose/install/), and enought disk space to pull images
- `docker-compose up`

When all's up, you can access to :
- `localhost:8080` -> Web app
- `localhost:8081` -> PhpMyAdmin interface (user:password)
- `localhost:8082/api` -> Php API

Note: don't forget to change credentials when you deploy it in production !

## Backend architecture

The backend rely on a couple of REST APIs.
It expects format passed either via GET or POST.
It returns a JSON format containing a `status` entry containing either `success` or  `error`.
If `error` was returned, a short message describing the issue is appended in an `error` entry.

### Overview

| Component | Method | Description | Arguments | Output on success |
| ---- | ---- | ------------ | ------------ | --------- |
| **test.php** | POST | Provide test data | `nbSuggestions` containing the number of plausible answers to return. This parameter is optionnal, the API will default to 4 suggestions. `genre` contains the array of requested genres. This parameter is optionnal and will items will be ignored if invalid (invalid genre ID, no song with give ID...) | `songID` (the ID the real song), `filename` (the name of the file to play), `suggestions` (an array of items containing the `songID` of the suggestion, `trackName` and `artistName` to craft the suggestion). In order to let the frontend format it properly, the trackname and the artist name aren't merged beforehand |
| **genres.php** | GET | Get available genres | None | JSON with a `genres` entry containing an array of couples `name` and `ID`  |
| **genres.php** | POST | Create a new genre | `name`, the name of the genre to create | `genreID`, containing the newly created ID of a genre with the name provided. If a genre with the same name already existed, its ID is provided. |
| **topScores.php** | GET | Get highest ranking users with their high scores | `nbResults`, the maximum number of top results expected. This parameter is optionnal, the API will default to 20 top scores. | `scores`, an array of items containing `rank` (counter starting from 1), `user` (the name of the user), `score` (the number of maximum correct answer for this user) |
| **topScores.php** | POST | Commit top score to database | `username` of the current user, `strike` containing the score | None |
