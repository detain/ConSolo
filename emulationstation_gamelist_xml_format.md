#### `<game>`

* `name` - string, the displayed name for the game.
* `desc` - string, a description of the game.  Longer descriptions will automatically scroll, so don't worry about size.
* `image` - image_path, the path to an image to display for the game (like box art or a screenshot).
* `thumbnail` - image_path, the path to a smaller image, displayed in image lists like the grid view.  Should be small to ensure quick loading.  *Currently not used.*
* `rating` - float, the rating for the game, expressed as a floating point number between 0 and 1.  Arbitrary values are fine (ES can display half-stars, quarter-stars, etc).
* `releasedate` - datetime, the date the game was released.  Displayed as date only, time is ignored.
* `developer` - string, the developer for the game.
* `publisher` - string, the publisher for the game.
* `genre` - string, the (primary) genre for the game.
* `players` - integer, the number of players the game supports.
* `playcount` - statistic, integer, the number of times this game has been played
* `lastplayed` - statistic, datetime, the last date and time this game was played.

