<?php

namespace App\Exceptions;

use Exception;

class ExcelImportException extends Exception
{
    protected $errors = [];

    public function __construct($message = "", $errors = [], $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($row, $column, $message)
    {
        $this->errors[] = [
            'row' => $row,
            'column' => $column,
            'message' => $message
        ];
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getFormattedErrors()
    {
        $formatted = [];
        foreach ($this->errors as $error) {
            $formatted[] = "Baris {$error['row']}, Kolom {$error['column']}: {$error['message']}";
        }
        return implode("\n", $formatted);
    }
}
