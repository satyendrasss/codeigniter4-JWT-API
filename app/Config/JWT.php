<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig
{
    public string $key = 'pLW9nxdLDyvlwesAeU0q4v3CWHc7SGrh'; 
    public string $algo = 'HS256';
    public int $expiry = 3600;
}
