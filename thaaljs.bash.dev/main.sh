#!/bin/bash
#: author: "pranav rana" <pranav@dwellupper.io>
#: version: 1.0
#: date started: Jan 8 2017

printf "%d\n" 200
echo "Content-Type: text/html; charset=utf-8"
printf "%s" $1
printf "%s\n" "ello planet earth!"