<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => ':attribute debe ser entre :min y :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => ':attribute no es una fecha válida.',
    'date_format'          => ':attribute no corresponde con el formato :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => ':attribute debe ser una dirección de e-mail válida.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => ':attribute no es una imagen.',
    'in'                   => ':attribute seleccionado es inválido.',
    'integer'              => ':attribute debe ser un número, sin puntos ni espacios.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute no puede ser mayor que :max.',
        'file'    => ':attribute no puede ser mayor a :max kilobytes.',
        'string'  => ':attribute no puede tener más de :max caracteres.',
        'array'   => ':attribute no puede contener más que :max elementos.',
    ],
    'mimes'                => ':attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute no puede ser menor que :max.',
        'file'    => ':attribute debe ser de al menos a :max kilobytes.',
        'string'  => ':attribute debe tener al menos :max caracteres.',
        'array'   => ':attribute debe contener al menos :max elementos.',
    ],
    'not_in'               => 'El valor seleccionado de :attribute no es válido.',
    'numeric'              => ':attribute debe ser un número.',
    'regex'                => ':attribute tiene un formato inválido.',
    'required'             => ':attribute es requerido.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => ':attribute debe ser :size.',
        'file'    => ':attribute debe ser de :size kilobytes.',
        'string'  => ':attribute debe tener :size caracteres.',
        'array'   => ':attribute debe contener :size elementos.',
    ],
    'string'               => ':attribute debe ser texto.',
    'timezone'             => ':attribute debe ser una zona válida.',
    'unique'               => ':attribute ya existe.',
    'url'                  => 'El formato de :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
