# Reflection

## 1. Which parts of your design are Model, View, and Controller?
The Model includes Request, RequestRepository, RequestService, and RequestValidator because these classes manage data, validation, and business logic.  
The View includes requests/index.php and requests/show.php because these files display information to users.  
The Controller is RequestController because it receives user actions, calls the model layer, and selects the appropriate view.

## 2. Where should validation happen, and why?
Validation should happen in a dedicated validator class or in the service layer, not inside the view.  
This keeps the system organized and follows the Single Responsibility Principle.

## 3. What would break if you put SQL inside a View file?
If SQL were placed inside a View file, the view would no longer be responsible only for presentation.  
It would mix data access with UI rendering, which makes the system harder to test, maintain, and reuse.

## 4. What code do you expect to write next week to make this real?
Next week, I would expect to write a router, implement controller actions, connect views to real data, and add autoloading for classes.
