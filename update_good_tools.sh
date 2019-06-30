#!/bin/bash
b=https://www.emuparadise.me/extras/GoodTools/;
mkdir -p /storage/bin/good_tools
cd /storage/bin/good_tools
for i in $(curl -s $b|grep "<td><a href"|cut -d\" -f2); do
	d="$(basename "$i" .zip)";
	rm -rf "$i" "$d" 2>/dev/null;
	wget $b$i && \
	mkdir "$d" && \
	cd "$d" && \
	7z x ../"$i" && \
	rm -f ../"$i" && \
	cd ..;
done
