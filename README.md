# tracking

# Local Development

`cd public_html_fmh`
`php -S localhost:8000`

Then, go to one of the following to browse and test locally:

* http://localhost:8000/localtest-ups.php
 * http://localhost:8000/apis/ups.php?id=576235903
* http://localhost:8000/localtest-saia.php
 * http://localhost:8000/apis/saia.php?id=00821019620
* http://localhost:8000/localtest-olddom.php


# To Publish

Send updates to client, to upload to the server.

* FIRST TIME ONLY: update status.php to pull out embedded JS and instead link to `apis.js` & add `unknown` classes
* update `apis.js`
* new/updated `apis/*` files
* update APIconfig.php.inc with new account credentials

# Options

These are the values we can expect to come in from the `ltl_carrier` field of the File Maker Pro database. The value is written to the `#carrierName` div.

* UPS Freight (done)
* Saia
* Old Dominion
* Yellow Freight
* Roadrunner
* FedEx
* Use Stock
* ABF
* Conway

Time Tracking

* 2 - 1/17/2015, jewel - initial mtg, mockups and project agreement
* 2.25 - 1/18/2015, jewel - build on faye's awesome work, making parsing dynamic 