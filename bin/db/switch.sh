#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$DIR/../.."

if [ -z "$1" ]
then
   1 = ""
fi

mv --force "tmp/$1.sqlite" "tmp/trial-bft.sqlite"
