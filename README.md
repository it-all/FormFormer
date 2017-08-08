HTML/HTML5 Form Creation Tool in PHP (7+) and Twig

WARNING: There may not be any net benefit to using this software. It may be better to code HTML forms in plain HTML, and spend a bit of extra time writing out all form labels and error messages (see examples/templates/emailFormWithoutFF.twig for an example of the code you'll probably be saved from writing for each field when you use FF). Regardless, I learned much about the 'value' of immutable objects.

FormFormer forms HTML/HTML5 forms. It is decoupled from submission processing and validation. An $errorMessage string can be passed to field constructors for error display. Some examples demonstrate minimal processing and validation techniques.

The goal was simple, flexible, and reliable code. Using immutable objects for all classes except the FieldBuilder API (optional) helps maintain simplicity and reliability. The FieldBuilder API makes field creation less verbose. Flexibility is provided by incorporating general $attributes array properties into Form and Field classes, requiring the client to have knowledge of HTML attributes and also potentially outputting HTML errors, as most attributes are not validated. 

Please post any questions or feedback. I am particularly interested in whether there are viable use cases for FormFormer. Does it save effort versus simply writing forms in HTML? Is it worth the trade-off of not writing HTML directly, and perhaps not learning or utilising your HTML form-writing skills? Also, there are certainly complexities which FormFormer does not handle. It can be extended and/or adapted over time to handle some, and simply not used for others. For an initial exploration of these questions, please see the example 'emailWithoutFF.php' and its template 'emailFormWithoutFF.twig'. 

Note that Twig defaults to escaping variables that are output into html:
https://twig.symfony.com/doc/2.x/filters/escape.html

w3.org Documentation on HTML5 forms:  
https://www.w3.org/TR/html5/forms.html

INSTALLATION  
-composer require it-all/form-former  
 or add "it-all/form-former": "^1.0" to composer.json and composer update  
-Add the src/macros/ directory to your twig loader like:  
$templateLoader = new Twig_Loader_Filesystem(['templates', '../src/twigMacros']);  
 (see https://twig.symfony.com/doc/2.x/api.html#built-in-loaders)  
 or copy src/macros/* to your twig environment
