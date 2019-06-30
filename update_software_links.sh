#!/bin/bash
d="/storage/vault8/roms/MAME/MAME 0.209 Software List ROMs (split)"
cd "$d"
IFS="
"
rm -rf ../Software;
mkdir ../Software;
for i in $(find  * -maxdepth 0 -type d); do
    n="$(grep "<softwarelist.*\"$i\"" ../software.xml|cut -d\" -f4|tr "/" "-")";
    if [ "$n" != "" ]; then
        ln -sdfv "${d}/$i" "../Software/$n";
    else
        ln -sdfv "${d}/$i" "../Software/$i";
    fi;
done

