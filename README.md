HTML/HTML5 Form Creation Tool in PHP (7+) and Twig

DISCLAIMER: There may not be any net benefit to using FormFormer (FF) for most applications. It may be better to code HTML forms in HTML :), so as to enhance your HTML forms knowledge. The work saved by using FF is mostly in writing form labels and error messages (see the comments in examples/templates/emailFormWithoutFF.twig and its template 'emailFormWithoutFF.twig' for a demonstration). Applications that incorporate forms with many fields, or automatically generated fields (such as ORMs) are most likely to benefit.

FormFormer forms HTML/HTML5 forms. It is decoupled from submission processing and validation. An $errorMessage string can be passed to field constructors and/or form constructor for error display. Some of the examples do demonstrate minimal processing and validation techniques.

The goal was simple yet flexible code. Using immutable objects for all classes except FieldBuilder (optionally makes field instantiation less verbose) helps maintain simplicity. Flexibility is provided by incorporating general $attributes array properties into Form and Field classes, requiring the client to have knowledge of HTML attributes and also potentially outputting invalid HTML, as most attributes are not validated. 

There are certainly complexities which FF does not handle, especially related to formatting. It can be extended and/or adapted over time to handle some, and simply not used for others.

Note that Twig defaults to escaping variables that are output into html:
https://twig.symfony.com/doc/2.x/filters/escape.html

w3.org Documentation on HTML5 forms:  
https://www.w3.org/TR/html5/forms.html

INSTALLATION  
-composer require it-all/form-former  
 or add "it-all/form-former": "^1.1" to composer.json and composer update  
-Add the src/macros/ directory to your twig loader like:  
$templateLoader = new Twig_Loader_Filesystem(['templates', '../src/twigMacros']);  
 or more likely:  
$templateLoader = new Twig_Loader_Filesystem(['templates', '../vendor/it-all/src/twigMacros']);  
 (see https://twig.symfony.com/doc/2.x/api.html#built-in-loaders)  
 or copy src/macros/* to your twig environment
