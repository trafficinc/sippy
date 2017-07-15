<?php


class Validation {

    public  $success = true;
    public  $errors = [];
    private $reasons = [];
    private $data;
    private $rules;

    public function setup($data, $rules) {

        $this->data     = $data;
        $this->rules    = $rules;
        $this->reasons  = [
            'email' =>      'The :attribute format is invalid.',
            'min' =>        'The :attribute must be at least :min characters.',
            'max' =>        'The :attribute may not be greater than :max characters.',
            'required' =>   'The :attribute field is required.',
            'numeric' =>    'The :attribute field must be number.',
            'integer' =>    'The :attribute field must be integer.'
        ];
        return $this->fire();
    }

    public function fire()
    {
        foreach ($this->rules as $attribute => $rule) {
            foreach (explode('|', $rule) as $item) {
                $detail = explode(':', $item);
                if ( count( $detail ) > 1 ) {
                    $reason = call_user_func_array([$this, $detail[0]], [$this->data[$attribute], $detail[1]]);
                } else {
                    $reason = $this->$item($this->data[$attribute]);
                }
                if ( $reason !== true ) {
                    $this->errors[] = str_replace(':attribute', $attribute, $reason);
                }
            }
        }
        if ( count($this->errors) > 0 ) {
            return $this->errors;
        }
    }
    protected function required($value)
    {
        return !$value ? $this->reasons['required'] : true;
    }
    protected function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : $this->reasons['email'];
    }
    protected function min($value, $min)
    {
        return mb_strlen($value, 'UTF-8') >= $min ? true : str_replace(':min', $min, $this->reasons['min']);
    }
    protected function max($value, $max)
    {
        return mb_strlen($value, 'UTF-8') <= $max ? true : str_replace(':max', $max, $this->reasons['max']);
    }
    protected function numeric($value)
    {
        return is_numeric($value) ? true : $this->reasons['numeric'];
    }
    protected function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false ? true : $this->reasons['integer'];
    }
    public function __call($method, $parameters)
    {
        throw new \UnexpectedValueException("Validate rule [$method] does not exist!");
    }

}
