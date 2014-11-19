#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ENDPT="https://www.myvyou.com/csm/xas1n4c5Y0/db.php?table=syncSmallAB"

echo ""
echo "posting schema"
curl -T $DIR/schema -X PUT $ENDPT
echo ""
echo ""
echo "posting row"
curl -T $DIR/1BFTRow -X POST "$ENDPT&maxPostedRow=-1&postingMachine=11"
echo ""
echo ""
echo "should get nothing"
curl -d '[]' -X POST "$ENDPT&maxPostedRow=-1&postingMachine=11"
echo ""
echo ""
echo "cleaning up"
curl -X DELETE $ENDPT