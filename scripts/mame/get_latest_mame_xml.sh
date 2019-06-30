#!/bin/bash
dest=/storage/json/mame.xml
ver=$(curl -s -L https://github.com/mamedev/mame/releases/latest|grep /mamedev/mame/releases/download/|grep lx.zip|cut -d/ -f6|cut -c5-)
major=$(echo $ver|cut -c1)
minor=$(echo $ver|cut -c2-)
version=${major}.${minor}
if [ ! -e ${dest} ]; then
	wget -q https://github.com/mamedev/mame/releases/download/mame${ver}/mame${ver}lx.zip
	unzip mame${ver}lx.zip
	rm -f mame${ver}lx.zip
	mv -f mame${ver}.xml ${dest}
	echo MAME ${version} XML saved as ${dest}
else
	echo MAME ${version} XML already exists as ${dest}
fi
