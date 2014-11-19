#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/../.."

compass compile app/

node csm-local/test.js &

./node_modules/.bin/nightwatch -t roster/test.js -c `pwd`/test/settings.json

#TODO: VLAD

#more tests:
#sorting
#search
#logbook
#add participant
#logout/login
#setting machine id initially
#surveys
#sync
#update


kill %1
