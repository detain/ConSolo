#!/bin/bash
set -x
IFS="
"
rm -rf /storage/roms
mkdir -p /storage/roms
cd /storage/roms
for i in $(find ../vault*/roms/* ../vault*/roms/No-Intro/No-Intro\ 2018/* ../vault*/roms/TOSEC/TOSEC\ Main\ Branch\ \(2018-12-27\)/* -maxdepth 0 -type d |sed s#"^.*/"#""#g|sort|uniq -c|sort -n|grep "^ *1 "|sed s#"^ *1 "#""#g); do
	ln -s ../vault*"/roms/$i/" "$i"
done
for d in $(find ../vault*/roms/* ../vault*/roms/No-Intro/No-Intro\ 2018/* ../vault*/roms/TOSEC/TOSEC\ Main\ Branch\ \(2018-12-27\)/* -maxdepth 0 -type d |sed s#"^.*/"#""#g|sort|uniq -c|sort -n|grep -v "^ *1 "|sed s#"^ *[0-9]* "#""#g); do
	mkdir -p "$d"
	cd "$d"
	for v in $(find ../../vault*"/roms/${d}" -maxdepth 0 -type d 2>/dev/null); do
		if [ -e "${v}" ]; then
			for i in $(find "${v}/"* -maxdepth 0 -type d); do
				ln -s "$i" "$(basename "$i")"
			done
		fi
	done
	if [ -e "../../vault6/roms/No-Intro/No-Intro 2018/roms/${d}/" ]; then
		for i in $(find "../../vault6/roms/No-Intro/No-Intro 2018/roms/${d}/"* -maxdepth 0 -type d); do
			ln -s "$i" "$(basename "$i") (No-Intro)"
		done
	fi
	if [ -e "../../vault6/roms/TOSEC/TOSEC Main Branch (2018-12-27)/roms/${d}/" ]; then
		for i in $(find "../../vault6/roms/TOSEC/TOSEC Main Branch (2018-12-27)/roms/${d}/"* -maxdepth 0 -type d); do
			ln -s "$i" "$(basename "$i") (TOSEC)"
		done
	fi
	cd ..
done
find /storage/vault*/roms > /storage/roms.txt
set +x
