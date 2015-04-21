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

* UPS Freight (done) -  `UPS Freight` `ups.php` - API, SOAP
* Saia (done) - `Saia` `saia.php` - html scrape
* Old Dominion (done) - `Old Dominion` `olddom.php` - SOAP/html scrape
* Yellow Freight (done) - `Yellow Freight` `yrc.php` - html scrape
* ABF (done) - `ABF` `abf.php` - API, XML
* ceva (in review) - `ceva` - http://www.cevalogistics.com/en-US/toolsresources/Pages/CEVATrak.aspx?sv
* Genwest - `Genwest` - http://72.165.143.35:81/cgibin/in1ssi-gen-search.htm
* FedEx - `FedEx` - https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber
* New England MF - `New England MF` - http://nemfweb.nemf.com/shptrack.nsf/request?openagent=1&pro=16033606&submit=Track
* Averitt - `Averitt` - https://www.averittexpress.com/action/trackingDetails?orderId=0742649691&serviceType=LTL
* Conway - `Conway` - https://www.con-way.com/webapp/manifestrpts_p_app/Tracking/TrackingRS.jsp?PRO=
* GLB - `GLB` - http://glbtrucking.com/TrackingCentral.aspx?hawb
* JTS - `JTS` - http://www.jtsexpress.com/cgi-bin/wbprotrk?wbfbnumber=545323&idbutton=Submit
* Wilson Trucking - `Wilson Trucking` - http://www.wilsontrucking.com/WilsonWeb/ED167W/ED167Win.jsp
* Roadrunner
* Use Stock

Time Tracking

Phase 1 - complete
* WEEK 1 TOTAL: 10 hrs on 1/18
 * 2 - 1/17/2015, jewel - initial mtg, mockups and project agreement
 * 2.25 - 1/18/2015, jewel - build on faye's awesome work, making parsing dynamic 
 * 1.75 - onsite, deployment prep & code cleanup, jewel
 * 4 - research, ups & saia starts, testing, faye
* WEEK 2 TOTAL: 4.5 hrs on 1/25
 * 4.5 - 1/25, jewel - SAIA and Old Dominion setup, waiting on SAIA account setup

Phase 2 - in progress
* 4/18 - 1hr initial research on new APIs: ceva, Genwest, FedEx, New England MF, Averitt, Conway, GLB, JTS, Wilson Trucking
* 4/20 - 2hr ceva, 1.25hr genwest, .5hr NEMF + documentation, 
