#!/bin/bash
IFS="
"
function nointro() {
cd No-Intro
mkdir keep;
for i in $(ls|sed s#" (20[0-9][0-9][0-9][0-9][0-9][0-9]-.*).json"#""#g|uniq); do
	mv "$(ls -tr "${i}"*|tail -n 1)" keep/ -fv && rm -fv "${i}"*;
done;
mv -fv keep/* .;
rmdir keep;
cd ..
}

function redump() {
cd Redump
mkdir keep;
for i in $(ls|sed s#" ([0-9]*) (20[0-9][0-9]-.*).json"#""#g|uniq); do
	mv "$(ls -tr "${i}"*|tail -n 1)" keep/ -fv && rm -fv "${i}"*;
done;
mv -fv keep/* .;
rmdir keep;
cd ..
}


function tosec() {
for i in TOSEC TOSEC-ISO TOSEC-PIX; do
	cd $i
	mkdir keep;
	for i in $(ls|sed s#" (TOSEC-v20[0-9][0-9]-.*).json"#""#g|uniq); do
		mv "$(ls -tr "${i}"*|tail -n 1)" keep/ -fv && rm -fv "${i}"*;
	done;
	mv -fv keep/* .;
	rmdir keep;
	cd ..
done
}

nointro
redump
tosec
