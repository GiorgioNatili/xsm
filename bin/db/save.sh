#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$DIR/../.."

cp tmp/trial-bft.sqlite "tmp/$1.sqlite"
