var file = require('./data.json');

for(var el in file) {
   console.log("INSERT INTO `music` (`ID`, `genreID`, `filename`, `trackName`, `artistName`) VALUES (NULL, '1', '" + file[el].Filename + "', \"" + file[el].Titre + "\", \"" + file[el].Titre + "\");");
}
