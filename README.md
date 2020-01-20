HTML/HTML5 Form Creation & Validation Tool in PHP (7.1+)  
  
FormFormer forms HTML/HTML5 forms, and, optionally, validates their submitted field values using [Valitron Validator](https://github.com/vlucas/valitron). In case of validation error(s), forms are redisplayed with populated field values and error messages. FormFormer is decoupled from processing form submission after validation.  
  
Please see examples/valitron.php for a minimal form with validation.  
  
The goal was simple yet flexible code. Using immutable objects for all classes, except FieldBuilder (which optionally makes field instantiation less verbose), helps maintain simplicity. Flexibility is provided by incorporating general $attributes array properties into Form and Field classes, requiring the client programmer to have knowledge of HTML attributes and also potentially outputting invalid HTML, as most attributes are not validated.  
  
There are certainly complexities which FF does not handle, especially related to formatting. It can be extended and/or adapted over time to handle some, and simply not used for others.  
  
INSTALLATION  
composer require it-all/form-former  
  
USAGE  
Please see examples.  
  
SECURITY  
In order to prevent XSS, the [htmlentities function](https://www.php.net/htmlentities) is used when outputting html element attribute values (which may contain user input if client code validates input and repopulates for failures) and html element content values (for example &lt;textarea&gt;escaped content&lt;/textarea&gt;).  
  
Further reference:  
https://www.martinfowler.com/articles/web-security-basics.html  
https://stackoverflow.com/questions/129677/whats-the-best-method-for-sanitizing-user-input-with-php#130323  
https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#File_uploads  
  
w3.org Documentation on HTML5 forms:  
https://www.w3.org/TR/html5/forms.html