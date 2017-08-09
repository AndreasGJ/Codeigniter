# Event_Handler_plugin
Insert all the files in this folder ( except the .md file of course :).

Go to application/config/autoload.php and change the $autoload['libraries'], so the 'event_handler' is loaded before all other libraries.

## Actions
An action is a function which dont return anything, but execute something.

### Add new action
You can add a new action with the following code:
```php
$this->event_handler->add_action("action-name", function(){
	// Do action here
}, 10);
```

### Do action
You can add a new action with the following code:
```php
$this->event_handler->do_action("action-name");
```

## Filters
A filter is a function which return something, and modifies a value.

### Add new filter
You can add a new filter with the following code:
```php
$this->event_handler->add_filter("filter-name", function($value){
	// Modify $value here
	return $value;
}, 10);
```

### Do filter
You can add a new action with the following code:
```php
$value = "tester";
$new_value = $this->event_handler->do_filter("filter-name", $value);
```
