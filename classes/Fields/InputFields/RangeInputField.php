<?php
declare(strict_types=1);

namespace It_All\FormFormer\Fields\InputFields;

/** Note if invalid characters are entered, and browser validation is turned off, browsers (chrome, ff) clear the input value on submit and either a Required error will catch the field or a blank input may get through. */
class RangeInputField extends NumberRangeInputField {}
