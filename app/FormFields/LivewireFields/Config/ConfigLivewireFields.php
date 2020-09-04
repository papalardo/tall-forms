<?php

namespace App\FormFields\LivewireFields\Config;

class ConfigLivewireFields
{
    public $input_width_size;

    public $input_height_size;

    public static function make()
    {
        return app(ConfigLivewireFields::class);
    }

    public function widthSize(int $input_width_size) : ConfigLivewireFields
    {
        $this->input_width_size = $input_width_size;
        return $this;
    }

    public function heightSize($input_height_size) : ConfigLivewireFields
    {
        $this->input_height_size = $input_height_size;
        return $this;
    }
}
