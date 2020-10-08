<?php

namespace Mqlo\NameableCast;

use Mqlo\Nameable\Nameable;

//implements Illuminate\Contracts\Database\Eloquent\CastsAttributes
abstract class NameableCast
{
    abstract protected function nameableClass(): string;

    final public function get($model, string $key, $nameable, array $attributes)
    {
        if (! $nameable instanceof Nameable) {
            $nameableClass = $this->nameableClass();
            $nameable = new $nameableClass($nameable);
        }

        return $nameable;
    }

    final public function set($model, string $key, $nameable, array $attributes)
    {
        if (! $nameable instanceof Nameable) {
            $nameableClass = $this->nameableClass();
            $nameable = new $nameableClass($nameable);
        }

        return [
            $key => $nameable->value(),
        ];
    }
}
