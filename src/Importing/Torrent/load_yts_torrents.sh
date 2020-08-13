#!/bin/bash
export IFS="
"
i="$1"
l="$2"
echo "$i - $l"
y=0
set -x
for t in $(cat $l); do
	y=$(($y + 1))
	b=$(basename $t)
	echo "[$i] $y $t";
	#curl -s --interface $i $t -o $b
	wget -c -q --bind-address=$i $t -O $b || rm -fv $b
done
set +x
