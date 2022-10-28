Evolving Web Interview Module
===========================

This module has these features :
* A new form text field named "Site API Key" is added to the "Site Information"
form with the default value of “No API Key yet”.

* When this form will be submitted, the value that the user entered for this field
will be saved as the system variable named "siteapikey".

* A Drupal message informs the user that the Site API Key has been saved with
that value.

* When this form will be visited after the "Site API Key" is saved, the field
populates with the correct value.

* The text of the "Save configuration" button changes to
"Update Configuration".

* This module also provides a URL that responds with a JSON representation of a
given node with the content type "page" only if the previously submitted API
Key and a node id (nid) of an appropriate node are present, otherwise it will
respond with "access denied".


URL => WEBSITE_URL/page/get-api/{auth}/{nid}
auth -> Site API Key.
nid -> node id.


Installation
============

Once the module has been installed, navigate to /admin/config/system/site-information.
Here, at the bottom a new field will be shown.
