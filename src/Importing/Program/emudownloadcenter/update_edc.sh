#!/bin/bash
base="$(readlink -f "$(dirname "$0")")";
for i in ecc-datfiles ecc-toolsused ecc-updates edc-repo0001 edc-repo0002 edc-repo0003 edc-repo0004 edc-repo0005 edc-repo0006 edc-repo0007 edc-repo0008 edc-repo0009 emuControlCenter emuControlCenter.wiki emuDownloadCenter emuDownloadCenter.wiki; do
	cd "$base"
	if [ ! -e $i ]; then
		git clone --recursive https://github.com/PhoenixInteractiveNL/$i $i
	fi
	cd $i
	git pull --all
	git submodule update --init --recursive
	git submodule sync --recursive
done
