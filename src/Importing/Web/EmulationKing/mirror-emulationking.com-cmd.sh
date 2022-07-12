#!/bin/bash
wget2 -c --mirror --convert-links --adjust-extension --page-requisites --no-check-certificate https://emulationking.com/ https://files.emulationking.com https://cdn.emulationking.com 2>&1 | tee mirror-emulationking.com-output.txt
