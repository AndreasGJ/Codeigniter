# Session_Handler_plugin
This plugin will help you organize and collect data from users, who are not users. It's like a little CRM system which keep an eye on your users with only 2 cookies.

## How to install it?
As you can see in this folder, are there a few different subfolders. You have to implement every single file and edit the autoload.php file where you should insert the *session_handler* library in autoloaded libraries. See the list below:
* **config/sessions.php**: contains the settings for the plugin, which we will talk about later
* **helpers/session_helper.php**: contains 2 different functions which can *get* and *add* data to the specific user.
* **libraries/Session_handler.php**: contains the library which controls the creation and updating of the different sessions and visitors.
* **models/Session_handler_model.php**: contains the class which actually saves the data.
* **sql/sessions.sql**: contains the SQL query which creates the 2 tables which is needed for the plugin to work.

### Whats the differents between a visitor and a session?
A **visitor** will be the same user every time he/she visits the site with the *visitor_cookie*. But a session will be destroyed after the user closes the browser. 

### Config setup
Here is the list of the different settings for the plugin:

* *tables.visitors*: this value should be the table name of the visitors table (default: **visitors**)
* *tables.visitors_data*: this value should be the table name of the visitors data table (default: **visitors_data**)
* *session_cookie*: should be set to the cookie name of the session cookie (default: **sc_v**)
* *visitor_cookie*: should be set to the cookie name of the visitor cookie (default: **vc_v**)
* *session_cookie_length*: is the length of the cookie value string for sessions (default: **30**)
* *visitor_cookie_length*: is the length of the cookie value string for visitors (default: **20**)
* *visitor_cookie_expire*: is the expiring length in seconds after the user visits (default: **31.536.000**/**1 year**)

### Library setup
If you want this plugin to merge to your other user systems so you can link a visitor or session to a specifc actual user, then you would have to change the *get_current_user_id()* method to return the current user id. If you do this then you would have the link between different visitors and sessions.

#### Cross platform tracking
If the user successfully logs in to your site on his/hers dekstop, and then goes to the site again on his/hers smartphone, then the user dont have the same cookies, which means he/she is another visitor. But as soon as the user logs in again on the smartphone, then the library will merge the 2 visitors together as the first from the first visit.
