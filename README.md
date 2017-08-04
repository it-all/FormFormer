HTML5 Form Creation Tool in PHP (7+) and Twig

WARNING: There may not be any benefit to using this software. It may be better to code HTML forms in plain HTML. Regardless, I learned much about the value of immutable objects.

FormFormer forms HTML (5) forms. It is decoupled from submission processing and validation. An $errorMessage string can be passed to field constructors for error display. The FormFormer examples demonstrate some minimal processing and validation techniques.

The goal was code simplicity and immutable object construction during instantiation, which makes using the API somewhat complex, as it requires dependencies to be created and injected to constructors (ie Fields to Forms, Options to Select Fields) and knowledge of html form and field element attributes.

Please post any questions or feedback. I am particularly interested in whether there are viable use cases for FormFormer. Does it save effort versus simply writing forms in HTML? Is it worth the trade-off of not writing HTML directly, and perhaps not learning or utilising your HTML form-writing skills? Also, there are certainly complexities which FormFormer does not handle. It can be extended and/or adapted over time to handle some, and simply not used for others. For an initial exploration of these questions, please see the example 'emailWithoutFF.php' and its template 'emailFormWithoutFF.twig'. 

Note that Twig defaults to escaping variables that are output into html:
https://twig.symfony.com/doc/2.x/filters/escape.html

w3.org Documentation on HTML5 forms:  
https://www.w3.org/TR/html5/forms.html

INSTALLATION  
composer require it-all/form-former  
(or add "it-all/form-former": "dev-master" to composer.json and composer update)  
copy src/templates/macros/* to your twig environment
