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

    'accepted' => 'El :attribute debe ser aceptado.',
    'accepted_if' => 'El :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => 'El :attribute no es una dirección URL válida.',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute solo puede contener letras.',
    'alpha_dash' => 'El :attribute solo puede contener letras, números, guiones o barra baja.',
    'alpha_num' => 'El :attribute solo puede contener letras y números.',
    'array' => 'El :attribute debe ser una colección de elementos.',
    'before' => 'El :attribute debe ser una fecha previa a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha previa o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file' => 'El :attribute debe pesar entre :min y :max kilobytes.',
        'string' => 'El :attribute debe contener entre :min y :max carácteres.',
        'array' => 'El :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean' => 'El :attribute campo debe ser verdadero o falso.',
    'confirmed' => 'El :attribute de confirmación no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'declined' => 'El :attribute debe ser rechazado.',
    'declined_if' => 'El :attribute debe ser rechazado cuando :other es :value.',
    'different' => 'El :attribute y :other deben ser diferenets.',
    'digits' => 'El :attribute debe ser :digits dígitos.',
    'digits_between' => 'El :attribute debe estar entre los :min y :max dígitos.',
    'dimensions' => 'El :attribute tiene unas dimensiones de imágen inválidas.',
    'distinct' => 'El campo :attribute tiene un valor repetido.',
    'email' => 'El :attribute debe ser una direción de correo electrónico válido.',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes: :values.',
    'enum' => 'El :attribute seleccionado es inválido.',
    'exists' => 'El :attribute seleccionado es válido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe contener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor a :value.',
        'file' => 'El :attribute debe ser mayor que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor que :value carácteres.',
        'array' => 'El :attribute debe contener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser superior o igual a :value.',
        'file' => 'El :attribute debe ser superior o igual a :value kilobytes.',
        'string' => 'El :attribute debe ser superior o igual a :value carácteres.',
        'array' => 'El :attribute debe contener :value elementos o más.',
    ],
    'image' => 'El :attribute debe ser una imágen.',
    'in' => 'El :attribute seleccionado es inválido.',
    'in_array' => 'El campo :attribute no existe en :oElr.',
    'integer' => 'El :attribute debe ser un entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser un formato JSON válido.',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor a :value.',
        'file' => 'El :attribute debe ser menor a :value kilobytes.',
        'string' => 'El :attribute debe ser menor a :value carácteres.',
        'array' => 'El :attribute debe contener menos elementos que :value.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor o igual a :value.',
        'file' => 'El :attribute debe ser menor o igual a :value kilobytes.',
        'string' => 'El :attribute debe ser menor o igual a :value carácteres.',
        'array' => 'El :attribute no debe contener más de :value elementos.',
    ],
    'mac_address' => 'El :attribute debe ser una dirección MAC válida.',
    'max' => [
        'numeric' => 'El :attribute no debe ser mayor a :max.',
        'file' => 'El :attribute no debe ser mayor a :max kilobytes.',
        'string' => 'El :attribute no debe ser mayor a :max carácteres.',
        'array' => 'El :attribute no debe contener más de :max elementos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser por lo menos :min.',
        'file' => 'El :attribute debe ser por lo menos :min kilobytes.',
        'string' => 'El :attribute debe ser por lo menos :min carácteres.',
        'array' => 'El :attribute debe contener por lo menos :min elementos.',
    ],
    'multiple_of' => 'El :attribute debe ser un multiplo de :value.',
    'not_in' => 'El :attribute seleccionado es inválido.',
    'not_regex' => 'El formato :attribute es inválido.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El campo :attribute debe estar presente.',
    'prohibited' => 'El campo :attribute es prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute está prohibido cuando :other esté presente.',
    'regex' => 'El formato :attribute es inválido.',
    'required' => 'El campo :attribute es necesario.',
    'required_array_keys' => 'El campo :attribute debe contener entradas para: :values.',
    'required_if' => 'El campo :attribute es necesario cuando :other es :value.',
    'required_unless' => 'El campo :attribute es necesario a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es necesario cuando :values está presente present.',
    'required_with_all' => 'El campo :attribute es necesario cuando los valores :values están presentes.',
    'required_without' => 'El campo :attribute es necesario cuando los valores :values no están presentes.',
    'required_without_all' => 'El campo :attribute es necesario cuando ninguno de :values está presente.',
    'same' => 'El :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El :attribute debe ser :size.',
        'file' => 'El :attribute debe pesar :size kilobytes.',
        'string' => 'El :attribute debe contener :size carácteres.',
        'array' => 'El :attribute debe contener :size elementos.',
    ],
    'starts_with' => 'El :attribute debe empezar por uno de los siguientes: :values.',
    'string' => 'El :attribute debe ser una oración.',
    'timezone' => 'El :attribute debe ser una zona horaria válida.',
    'unique' => 'El :attribute ya ha sido registrado.',
    'uploaded' => 'El :attribute falló al subirse.',
    'url' => 'La dirección URL :attribute debe ser válida.',
    'uuid' => 'El :attribute debe ser un UUID válido.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña', 
        'password_confirmation' => 'confirmar contraseña',
        'quotas' => 'cupos',
        'quotas_availabe' => 'cupos disponibles',
        'professor' => 'profesor',
        'image' => 'imagen',
        'description' => 'descripción',
        
    ],

];
