# tracking

# Local Development

`cd public_html_fmh`
`php -S localhost:8000`

Then, go to http://localhost:8000/localtest.php

to run a local test.

# To Publish

Send new `apis/*` files and updated `apis.js` to client, who will upload them to the server.
(First time, will need to update status.php to include call to apis.js instead of embedded code.)

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