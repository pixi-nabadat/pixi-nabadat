<?php

namespace App\Services;

use App\Models\Settings;

class SettingService extends BaseService
{
    public function __construct(protected Settings $settings)
    {
    }

    public function getPredefinedPages(): array
    {
        return $this->settings->predefined_pages ;
    }

    public function checkIfPageNameExists($page_name)
    {
        return $this->settings->where('name',$page_name)->exists();
    }
}
