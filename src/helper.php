<?php

use Iqbalatma\LaravelServiceRepo\Exceptions\DumpAPIException;

if (!function_exists("viewShare")) {
    /**
     * @param array $data
     * @return void
     */
    function viewShare(array $data): void
    {
        foreach ($data as $key => $value) {
            Illuminate\Support\Facades\View::share($key, $value);
        }
    }
}


if (!function_exists("getDefaultErrorResponse")) {
    /**
     * @param Exception $e
     * @return array
     */
    function getDefaultErrorResponse(Exception $e): array
    {
        return [
            "success" => false,
            "message" => config('app.env') !== 'production' ? $e->getMessage() : 'Something went wrong'
        ];
    }
}

if (!function_exists("formatToRupiah")) {
    /**
     * Description : use to format to rupiah
     *
     * @param float|null $number value for format
     * @param string $fallbackValue
     * @return string
     */
    function formatToRupiah(float|null $number, string $fallbackValue = "-"): string
    {
        if (is_null($number)) {
            return $fallbackValue;
        }
        return "Rp " . number_format($number, 2, ",", ".");
    }
}

if (!function_exists('ddapi')) {

    /**
     * @param mixed ...$data
     * @return mixed
     * @throws DumpAPIException
     */
    function ddapi(mixed ...$data)
    {
        $exceptionData = [];
        foreach ($data as $datum) {
            $exceptionData[] = $datum;
        }
        throw new DumpAPIException($exceptionData);
    }
}

