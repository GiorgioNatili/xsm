# Tech Facts
The application is based upon _nodejs_, _sqlite_, _angular_, _jade_ and _sass_.
In the app folder you find the client and the server side code, the server side code is stored in the `app` folder and is the one responsible to initialize the server and the paths (the naming is unfortunate because it's `app/app` but it doesn't prevent so far the app to work properly).

Following you can find some information related to the folders contained in the `app` directory.

### Db
The `db` folder contains a wrapper able to use _sqlite_ easily in javascript, in the `endpoints.js` file you can find the URLs used in order to create records, the philosophy behind the model is the [Database journalism](http://en.wikipedia.org/wiki/Database_journalism). The `try-sync` folder nested in this folder contains several tools used in order to sync the database, it should be appropriate to do a detailed test to check if `curl` will work correctly without the `sudo` privileges.
There are in this folder two files used to generate fake and trial data, in this folder there are also the _tests_ that should be run every time a change to this folder is performed.

### Page
This is the entry point of the front-end, it's here that all the dependencies are defined and where the first `controller` (i.e. `LoadingCrt`) is loaded. This controller is kinda the same but it's defined in different folders (actually `roster`, `survey` and `tfb`) and is the responsible of the _model_ initialization of every component and of the [`FastClick`](https://github.com/ftlabs/fastclick) library.

### Roster, Survey and TFB
In the `roster` folder there are all the templates and controllers related to this component, all the dependencies are in the `index.jade` template. Server side code is mixed with client side also if in separate files.
Tis pattern is the same into the `survey` and `tfb` directories. 

### Widgets
Imagine this folder as a container of components, so far there are only the `loading` one and a `radio` button, more will be added during the next development round.

## Miscellaneous
The file `contents.js` is the place where you can find the paths to the project root, to the sqlite files, etc. It is included in most of the server side code.
Another important file is the `app/config.rb`, is here that you specify the folders to be included in the build process.
What's important to know is that there are no HTML files around but only `jade` templates, this cannot be practical in this stage but can be useful for the internationalization (aka i18n) process.