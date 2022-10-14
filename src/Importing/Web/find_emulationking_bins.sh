#!/bin/bash
cd /storage/local/ConSolo/public
for i in $(find emulationking -type f); do 
	d="x${i}"; 
	mkdir -p "$d";  
	patool --non-interactive extract --outdir "$d" "$i" || rm -rvf "$d";
done
find xemulationking/ -mindepth 2 -maxdepth 2|sed s#"^.*\.\(zip\|tar\.bz2\|tar\.xz\|apk\|7z\|deb\|tar\.gz\|dmg\|tar\|ZIP\|rar\|rpm\|ipa\|tgz\)$"#"\1"#g|sort|uniq
for i in xemulationking/*/*; do 
	file $(find "$i" -type f);
done > file.txt
grep -e executable file.txt | \
	grep -e "executable.*Intel 80386" -e "executable.*x86-64" -e "executable.*Aarch64" \
	-e "ELF.*executable.*x86-64" -e "ELF.*executable.*Intel 80386" -e "ELF.*executable.*ARM" \ 
	-e "Mach-O.*x86_64.*executable" -e "Mach-O i386.*executable" -e "Mach-O ppc.*executable" -e "Mach-O universal.*executable" -e "Mach-O.*executable.*arm64" | \
	grep -v -e DLL > bins.txt
file $(for i in emulationking/*/*; do if [ ! -e "x${i}" ]; then echo $i; fi;done) > ibins.txt
