#!/bin/bash

if ! pgrep -x chromedriver &> /dev/null 2>&1; then
    echo '{"ready":"0"}'
else
    echo '{"ready":"1"}'
fi