<?php
declare(strict_types=1);

namespace It_All\FormFormer;

use Valitron\Validator as VV;

class Validator extends VV
{
    function isValid(): bool 
    {
        return $this->validate();
    }

    function getErrors(): array
    {
        return $this->getFirstErrors();
    }

    /**
     * @param string $field
     * @param string $msg
     * @param array $params
     * Override parent fn in order to fix field names that end in '.*'
     */
    public function error($field, $msg, array $params = array())
    {
        if (substr($field, mb_strlen($field) - 2, 2) == '.*') {
            $field = substr($field, 0, mb_strlen($field) - 2);
        }

        parent::error($field, $msg, $params);
    }

    public function getFirstErrors():array
    {
        $firstErrors = [];
        foreach (parent::errors() as $fieldName => $fieldErrors)
        {
            $firstErrors[$fieldName] = $this->fixErrorMessage($fieldName, $fieldErrors[0]);
        }

        return $firstErrors;
    }

    private function fixErrorMessage(string $fieldName, string $errorMessage): string
    {
        // ie username -> Username, password_hash -> Password Hash to match incoming $errorMessage
        $messageFieldName = ucwords(str_replace('_', ' ', $fieldName));

        switch ($errorMessage) {
            case $messageFieldName . ' is required':
                $newMessage = 'required';
                break;

            default:
                $newMessage = str_replace($messageFieldName . ' ', '', $errorMessage);
        }

        return $newMessage;
    }

    protected function addUniqueRule() 
    {
        self::addRule('unique', function($field, $value, array $params = [], array $fields = []) {
            if (!$params[1]->errors($field)) {
                return !$params[0]->recordExistsForValue($value);
            }
            return true; // skip validation if there is already an error for the field
        }, 'Already exists');
    }
}
