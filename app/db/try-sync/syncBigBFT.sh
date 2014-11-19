#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ENDPT="https://www.myvyou.com/csm/xas1n4c5Y0/db.php?table=syncBigAB"

curl -T $DIR/schema -X PUT $ENDPT
curl -T $DIR/manyBFTRows -X POST "$ENDPT&maxPostedRow=-1&postingMachine=11"
curl -X DELETE $ENDPT
