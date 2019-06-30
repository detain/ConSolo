#!/bin/bash
u=https://gamesdb.launchbox-app.com/Metadata.zip
m="$(curl -s -I $u |grep "^Last-Modified:")"
if [ ! -e .last ] || [ "$(grep Last .last)" != "$m" ]; then
	echo -n "Updating...downloading.."
	wget $u -O Metadata.zip
	echo "$m" > .last
	echo -n "unzipping.."
	unzip -o -d xml Metadata.zip
	rm -f Metadata.zip
	echo "done"
else
	echo "Skipping Update"
fi
