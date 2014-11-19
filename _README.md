csm
===

CeASAR Offline Study Manager

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
	
	#in csm
	npm install
	bower install

	./bin/test-server.sh
	./bin/start-selenium.sh &
	./bin/test-app.sh
	kill %1
	
	./bin/gen-trial-bft.sh
	./bin/try-app.sh &

App
===

e2e    - testing scripts for all of the below

style  - defines the look of the application, scss. see index.scss

media  - fonts, images, etc, used mostly by style

jade   - the core of the app; a series of jade templates that use the abstractions in client to describe the buisness logic at a high level. Start reading from index.jade.

client - abstractions on top of angular that specialize it for our problem

server - node.js backend

Misc
====

tmp/ - temporary files not in git. 

	trial_db.sqlite - sqlite3 database created by try.sh

	test_db.sqlte - sqlite3 database created by test.sh

	test/ - reports created by test.sh

	style - temporary style sheets created before while running locally

doc - additional documenation

LICENSE - project license

csm.sublime-* sublime project files.

TODO
===

JSHINT

multifield valdation? no
review coalesce delay with lon? done
real user management? no
what fields do you want in roster? april


write some automated sanity logging that captures serverside errors as well as data size
angular testing

#TODO:

need from lon:

windows 8 laptop

surveys.csv

surveyName, surveyTitle, css class, quickMode=all questions must be required & radio & no next button & but yes back button

all pages otherwise have next/back button


grey out calendar when it isn't selectable

split up add event dialog

always say tap

autofocus

tap to mark substance use -> done for action, not enabled until calendar clicked

grey entire calendar on select week and highlight on hover instead of highlight week

months should be buttons when selectable

bounce prompt on chance

areyou sure for clear everything

select box for multplier [1,2,3,4,5,6,7,8,9,10] for tap number in use selector