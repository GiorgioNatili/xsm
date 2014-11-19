#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/.."

java -jar test/selenium-2.39.0.jar -port 5555 "-Dwebdriver.chrome.driver=`pwd`/test/chromedriver"
