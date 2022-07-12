#!/bin/bash
wget2 --trust-server-names --no-compression -c --mirror --convert-links --adjust-extension --page-requisites --no-check-certificate www.emuparadise.me static.emuparadise.me emuparadise.me | tee mirror-emuparadise-output.txt
