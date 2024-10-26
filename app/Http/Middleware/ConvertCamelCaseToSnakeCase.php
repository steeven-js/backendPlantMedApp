<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertCamelCaseToSnakeCase {

  public function handle($request, Closure $next) {
    $input = $request->all();

    $input = $this->convertKeysToSnakeCase($input);

    $request->replace($input);

    return $next($request);
  }


  private function convertKeysToSnakeCase($array) {
    $result = [];

    foreach ($array as $key => $value) {
      $snakeCaseKey = Str::snake($key);

      if (is_array($value)) {
        $value = $this->convertKeysToSnakeCase($value);
      }

      $result[$snakeCaseKey] = $value;
    }

    return $result;
  }
}
