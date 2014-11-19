# XSM: The eXtensible Study Manager

xsm
===

XSM: The eXtensible Study Manager

Running
===

Requires Node.js 10.25+, OS X 10.9+/windows 8.1, bower [bower.io] 1.2.8, Git 1.8, compass 0.12 & local dependencies in bower/package.json:

bower.json - index of the client's dependencies
bower_components - not in git. Run `bower install` to [re]generate which is required when bower.json/on install changes otherwise you'll get 404s when the client refreshes.

package.json - index of the server's dependencies
node_components - not in git. Run `npm install` to [re]generate which is required when package.json/on install changes otherwise you'll get require errors when the server runs.

bin - management scripts.

	gen-trial-bft.sh  - create a sample base fact table for try-app.sh

	try-app.sh - try the application on localhost. Run command above first.

	start-selenium.sh - run to start the browser server that test.sh talks to.

	test-app.sh - automatically test the application. Run start start-selenium.sh first.

	test-server.sh - automatically test the server side code using mocha.

As such the following should get you gowing on a virgin os x 10.9 with homebrew [http://brew.sh/] installed:

	brew install node
	npm install bower -g

	#in xsm
	npm install
	bower install

	./bin/test-server.sh
	./bin/start-selenium.sh &
	./bin/test-app.sh
	kill %1

	./bin/gen-trial-bft.sh
	./bin/try-app.sh &

Structure
===

e2e    - testing scripts for all of the below

style  - defines the look of the application, scss. see index.scss

media  - fonts, images, etc, used mostly by style

jade   - the core of the app; a series of jade templates that use the abstractions in client to describe the buisness logic at a high level. Start reading from index.jade.

client - abstractions on top of angular that specialize it for our problem

server - node.js backend

## Benefits: Why should I use this

## Usage: How do I use this

1. Click the download zip button on the left of this page and open the zip file.

hen open the Manage.command file. 

on Windows: 

## Development: How do I modify this

## History: How was this created

## Limitations: What can't this do (yet)

## License: What can this be used for?

This program was copyrightighted by Amit D. Bansil and Giorgio Natili me@webplatform.io in 2014. All rights are reserved. Please do not hesitate to contact him at amit@bansil.org to request a licence for your usage.

## Contact: How do I learn more?

Contact Amit D. Bansil at [amit@bansil.org](mailto:amit@bansil.org) or via [LinkedIn](http://lnkd.in/Y6mbje). He would love to hear from you.