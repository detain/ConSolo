#!/bin/bash
IFS="
"
# grabs all the story archive dates and loads the archive page for each grabbing all the artile titles/urls
for i in $(curl -s https://www.emucr.com/|grep "<a href.*archive.htm"|cut -d\' -f2); do
	echo -e "\n\n--- $i ---\n";
	curl -s "$i"|grep "<a href.*title=" ;
done > emucr.html

