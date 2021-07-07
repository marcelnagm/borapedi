<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | O following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :attribute não é um URL válido.',
    'after' => 'O :attribute deve ser uma data depois :date.',
    'after_or_equal' => 'O :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O :attribute só pode conter letras.',
    'alpha_dash' => 'O :attribute só pode conter letras, números, travessões e sublinhados.',
    'alpha_num' => 'O :attribute pode conter apenas letras e números.',
    'array' => 'O :attribute deve ser um array.',
    'before' => 'O :attribute deve ser uma data antes :date.',
    'before_or_equal' => 'O :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => 'O :attribute deve estar entre:min e :max.',
        'file' => 'O :attribute deve estar entre :min e :max Kb.',
        'string' => 'O :attribute deve estar entre :min e :max caracteres.',
        'array' => 'O :attribute deve estar entre :min e :max items.',
    ],
    'boolean' => 'O :attribute campo deve ser verdadeiro ou falso.',
    'confirmed' => 'O :attribute a confirmação não corresponde.',
    'date' => 'O :attribute não é uma data válida.',
    'date_equals' => 'O :attribute deve ser uma data igual a :date.',
    'date_format' => 'O :attribute não corresponde ao formato :format.',
    'different' => 'O :attribute e :other deve ser diferente.',
    'digits' => 'O :attribute deve ser :digits digitos.',
    'digits_between' => 'O :attribute deve estar entre :min e :max digitos.',
    'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O :attribute campo tem um valor duplicado.',
    'email' => 'O :attribute deve ser um endereço de e-mail válido.',
    'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
    'exists' => 'O selecionado :attribute é inválido.',
    'file' => 'O :attribute deve ser um arquivo.',
    'filled' => 'O :attribute campo deve ter um valor.',
    'gt' => [
        'numeric' => 'O :attribute deve ser maior que :value.',
        'file' => 'O :attribute deve ser maior que :value Kb.',
        'string' => 'O :attribute deve ser maior que :value caracteres.',
        'array' => 'O :attribute deve ser maior que :value items.',
    ],
    'gte' => [
        'numeric' => 'O :attribute deve ser maior que or equal :value.',
        'file' => 'O :attribute deve ser maior que or equal :value Kb.',
        'string' => 'O :attribute deve ser maior que or equal :value caracteres.',
        'array' => 'O :attribute must have :value items or more.',
    ],
    'image' => 'O :attribute deve ser uma imagem.',
    'in' => 'O selecionado :attributeé inválido.',
    'in_array' => 'O :attribute campo não existe em:other.',
    'integer' => 'O :attribute deve ser um número inteiro.',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O :attribute must be a valid IPv4 address.',
    'ipv6' => 'O :attribute must be a valid IPv6 address.',
    'json' => 'O :attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'O :attribute deve ser menor que :value.',
        'file' => 'O :attribute deve ser menor que :value Kb.',
        'string' => 'O :attribute deve ser menor que :value caracteres.',
        'array' => 'O :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'O :attribute deve ser menor que or equal :value.',
        'file' => 'O :attribute deve ser menor que or equal :value Kb.',
        'string' => 'O :attribute deve ser menor que or equal :value caracteres.',
        'array' => 'O :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'O :attribute não pode ser maior que :max.',
        'file' => 'O :attribute não pode ser maior que :max Kb.',
        'string' => 'O :attribute não pode ser maior que :max caracteres.',
        'array' => 'O :attribute não pode ter mais do que :max items.',
    ],
    'mimes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O :attribute deve ser pelo menos :min.',
        'file' => 'O :attribute deve ser pelo menos :min Kb.',
        'string' => 'O :attribute deve ser pelo menos :min caracteres.',
        'array' => 'O :attribute deve ser pelo menos :min items.',
    ],
    'multiple_of' => 'O :attribute deve ser um múltiplo de :value',
    'not_in' => 'O selecionado :attribute é inválido.',
    'not_regex' => 'O :attribute formato é inválido.',
    'numeric' => 'O :attribute deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O :attribute campo deve estar presente.',
    'regex' => 'O :attribute formato é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é necessário quando :other é :value.',
    'required_unless' => 'O :attribute field is required unless :other é em :values.',
    'required_with' => 'O :attribute field é necessário quando :values esta presente.',
    'required_with_all' => 'O :attribute field é necessário quando :values estão presente.',
    'required_without' => 'O :attribute field é necessário quando :values não estão presentes.',
    'required_without_all' => 'O campo :attribute é necessário quando nenhum dos :values estão presentes.',
    'same' => 'O :attribute e :other devem ser .',
    'size' => [
        'numeric' => 'O :attribute deve ser :size.',
        'file' => 'O :attribute deve ser :size Kb.',
        'string' => 'O :attribute dever ter :size caracteres.',
        'array' => 'O :attribute deve conter :size items.',
    ],
    'starts_with' => 'O :attribute deve começar com um dos seguintes::values.',
    'string' => 'O :attribute deve ser uma string.',
    'timezone' => 'O :attribute deve ser uma zona válida.',
    'unique' => 'O :attribute já foi tomada.',
    'uploaded' => 'O :attribute falha ao carregar.',
    'url' => 'O :attribute formato é inválido.',
    'uuid' => 'O :attribute deve ser um UUID válido.',

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
        'order_price' => [
            'min' => 'O mínimo de pedido é :min. Por favor, adicione mais alguns itens no carrinho',
        ],
        'address_id' => [
            'required' => 'Por favor selecione o seu endereço',
        ],
        'stripe_payment_error_action'=>[
            'required'=>'O tentativa de pagamento falhou porque uma ação adicional é necessária antes que possa ser concluída'
        ],
        'stripe_payment_failure'=>[
            'required'=>'O tentativa de pagamento falhou por vários outros motivos, como falta de fundos disponíveis. Por favor, verifique os dados fornecidos.'
        ],
        'paypal_payment_error_action'=>[
            'required'=>'O tentativa de pagamento falhou porque uma ação adicional é necessária antes que possa ser concluída'
        ],
        'link_payment_error_action'=>[
            'required'=>'Método de pagamento baseado em link não encontrado'
        ],
        'paypal_payment_approval_missing'=>[
            'required'=>'Nós não conseguimos obter o link de pagamento paypal.'
        ],
        'mollie_error_action'=>[
            'required'=>'Erro ao obter o link de pagamento.'
        ],
        'paystack_error_action'=>[
            'required'=>"Erro na comunicação com PayStack"
        ],
        'dinein_table_id'=>[
            'required'=>'Selecione sua mesa',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | O following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
