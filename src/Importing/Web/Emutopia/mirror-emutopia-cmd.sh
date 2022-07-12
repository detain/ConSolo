#!/bin/bash
wget2 --trust-server-names --no-compression -c --mirror --convert-links --adjust-extension --page-requisites --no-check-certificate www.emutopia.com emutopia.com | tee mirror-emutopia-output.txt
