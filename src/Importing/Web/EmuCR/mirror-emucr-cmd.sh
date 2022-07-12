#!/bin/bash
wget2 --cut-dirs=6 --max-threads=1 --no-compression -c --mirror --convert-links --adjust-extension --page-requisites --no-check-certificate www.emucr.com emucr.com down.emucr.com files.emucr.com | tee mirror-emucr-output.txt
