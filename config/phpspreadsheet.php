<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for PhpSpreadsheet
    |
    */
    'default_writer' => 'Xlsx',
    'default_reader' => 'Xlsx',

    /*
    |--------------------------------------------------------------------------
    | CSV Settings
    |--------------------------------------------------------------------------
    |
    | Settings specific to CSV file handling
    |
    */
    'csv' => [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape' => '\\',
        'input_encoding' => 'UTF-8',
        'line_ending' => PHP_EOL,
    ],

    /*
    |--------------------------------------------------------------------------
    | Memory Settings
    |--------------------------------------------------------------------------
    |
    | Memory optimization settings
    |
    */
    'memory' => [
        'cache_method' => 'memory', // memory, disk, or none
        'cache_dir' => storage_path('framework/cache/phpspreadsheet'),
        'memory_limit' => '512M',
        'read_chunk_size' => 2000, // rows to read at once for large files
    ],

    /*
    |--------------------------------------------------------------------------
    | Import Settings
    |--------------------------------------------------------------------------
    |
    | Settings for import functionality
    |
    */
    'import' => [
        'max_file_size' => 2048, // KB
        'allowed_extensions' => ['xlsx', 'xls', 'csv'],
        'skip_empty_rows' => true,
        'auto_detect_headers' => true,
        'header_row' => 1, // which row contains headers
        'data_start_row' => 2, // which row data starts
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Settings
    |--------------------------------------------------------------------------
    |
    | Settings for data validation during import
    |
    */
    'validation' => [
        'required_columns' => [
            'nama_barang' => ['namabarangjasa', 'nama_barang_jasa', 'nama_barang', 'barang', 'nama'],
            'quantity' => ['qty', 'jumlah', 'quantity', 'amount'],
            'unit' => ['satuan', 'unit', 'uom'],
            'price' => ['hargarp', 'harga', 'price', 'unitprice', 'harga_rp'],
        ],
        'numeric_columns' => ['quantity', 'price'],
        'text_columns' => ['nama_barang', 'unit'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    |
    | Settings for error handling and logging
    |
    */
    'errors' => [
        'log_errors' => true,
        'log_channel' => 'daily',
        'max_errors_per_import' => 50,
        'stop_on_error' => false,
    ],
];
