HTML/HTML5 Form Creation Tool in PHP (7.1+)

DISCLAIMER: There may not be any net benefit to using FormFormer (FF) for most applications. It may be better to code HTML forms in HTML :), so as to enhance your HTML forms knowledge. The work saved by using FF is mostly in writing form labels and error messages. Applications that incorporate forms with many fields, or automatically generated fields (such as ORMs) are most likely to benefit.

FormFormer forms HTML/HTML5 forms. It is decoupled from submission processing and validation. An $errorMessage string can be passed to field constructors and/or form constructor for error display. (Some of the included examples do demonstrate minimal processing and validation techniques.)

The goal was simple yet flexible code. Using immutable objects for all classes except FieldBuilder (optionally makes field instantiation less verbose) helps maintain simplicity. Flexibility is provided by incorporating general $attributes array properties into Form and Field classes, requiring the client to have knowledge of HTML attributes and also potentially outputting invalid HTML, as most attributes are not validated. 

There are certainly complexities which FF does not handle, especially related to formatting. It can be extended and/or adapted over time to handle some, and simply not used for others.

INSTALLATION  
-composer require it-all/form-former  
 or add "it-all/form-former": "^2.0" to composer.json and composer update  

SECURITY  
Since FormFormer is limited to forming forms, rather than receiving, filtering, or validating data, there is little to no security implemented in the source code (/src). There is some minimal security in /examples/init.inc in terms of escaping user input data that will potentially be displayed in HTML (in the case of a validation error). Minimal validation is performed in the examples. For a good php validator package, please see https://github.com/vlucas/valitron.  
https://www.martinfowler.com/articles/web-security-basics.html  
https://stackoverflow.com/questions/129677/whats-the-best-method-for-sanitizing-user-input-with-php#130323  
https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#File_uploads

w3.org Documentation on HTML5 forms:  
https://www.w3.org/TR/html5/forms.html