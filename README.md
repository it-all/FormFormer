HTML5 Form Creation Tool in PHP (7+) and Twig

INSTALLATION
composer require it-all/form-former
(you may need to add "minimum-stability": "dev" to composer.json)
copy src/templates/macros/* to your twig environment

FormFormer forms forms. It is decoupled from submission processing and validation. An $errorMessage string can be passed to field constructors for error display. https://github.com/cangelis/simple-validator may be a good option for field validation. The FF examples do show some minimal processing and validation techniques.

The goal was code simplicity and thorough object construction during instantiation, which makes using the API somewhat complex to use, as it requires dependencies to be created and injected to constructors (ie fields to forms, options to select fields) and knowledge of html form and field element attributes.

Please post any questions or feedback. I am particularly interested in whether there are actual use cases for FormFormer. In other words, does it save effort versus simply writing forms in HTML? If so, how? For an initial exploration of these questions, please see the example that forgoes using FF. 



w3.org Documentation on HTML5 forms:
https://www.w3.org/TR/html5/forms.html
https://www.w3.org/TR/html5/forms.html#concept-input-apply
