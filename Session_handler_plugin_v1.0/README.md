# Session_Handler_plugin
This plugin will help you organize and collect data from users, who are not users. It's like a little CRM system which keep an eye on your users with only 2 cookies.

## How to install it?
As you can see in this folder, are there a few different subfolders. You have to implement every single file and edit the autoload.php file where you should insert the *session_handler* library in autoloaded libraries. See the list below:
* **config/sessions.php**: contains the settings for the plugin, which we will talk about later
* **helpers/session_helper.php**: contains 2 different functions which can *get* and *add* data to the specific user.
* **libraries/Session_handler.php**: contains the library which controls the creation and updating of the different sessions and visitors.
* **models/Session_handler_model.php**: contains the class which actually saves the data.
* **sql/sessions.sql**: contains the SQL query which creates the 2 tables which is needed for the plugin to work.

### Config setup
Coming soon

### Library setup
Coming soon
