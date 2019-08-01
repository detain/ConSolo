#!/bin/bash
for name in "MAME Software" "MAME Machines" TOSEC TOSEC-ISO Redump No-Intro; do
  echo "${name}";
  for status in GOOD BAD PARTIAL; do
    echo "  $(grep "${name}.*${status} SET$" /storage/data/matches.txt|wc -l) ${status}";
  done;
done
