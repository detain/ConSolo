#!/bin/bash
for i in emuControlCenter emuDownloadCenter ecc-toolsused ecc-updates ecc-datfiles edc-repo0009 edc-repo0008 edc-repo0007 edc-repo0006 edc-repo0005 edc-repo0004 edc-repo0003 edc-repo0002 edc-repo0001; do
	if [ ! -e $i ]; then
		git clone https://github.com/PhoenixInteractiveNL/$i $i
	fi
	cd $i
	git pull --all
	git submodule update --init --recursive
	git submodule sync --recursive
done
