<?php
namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UtilCommon
{
    /**
     * uuid
     *
     * @var string
     */
    private string $pid = '';

    /**
     * http request object
     *
     * @var Request
     */
    public Request $httpRequest;

    /**
     * get pid
     *
     * @return string
     */
    public function getPid() : string
    {
        return $this->pid;
    }

    /**
     * set pid
     *
     * @return string|null
     */
    public function setPid(?string $pid) : void
    {
        if (is_null($pid)) {
            $pid = Str::uuid();
        }

        $this->pid = $pid;
    }

    /**
     * get request object
     *
     * @return Request|null
     */
    public function getRequestObj() : ?Request
    {
        if (isset($this->httpRequest)) {
            return $this->httpRequest;
        }
        return null;
    }

    /**
     * get log level
     *
     * @param string $errorCode
     * @return void
     */
    public function getLogLevelFromErrorCode(string $errorCode)
    {
        $logLevel = null;

        $matched = [];
        preg_match('/(^E|I|F|W)L?[0-9]{4}/', $errorCode, $matched);

        if (!empty($matched)) {
            switch ($matched[1]) {
                case 'E':
                    $logLevel = config('constant.LOG_LV_ERROR');
                    break;

                case 'I':
                    $logLevel = config('constant.LOG_LV_INFO');
                    break;

                case 'W':
                    $logLevel = config('constant.LOG_LV_WARN');
                    break;

                case 'F':
                    $logLevel = config('constant.LOG_LV_FATAL');
                    break;

                default:
                    $logLevel = config('constant.LOG_LV_ERROR');
                    break;
            }
        }
        return $logLevel;
    }

    /**
     *  配列のキーをスネークケースに変更(複数階層まで再帰的に処理)
     *
     * example
     *  「input / output」サンプル関しては下記、テストクラスを参照
     *     MaasCommonTest::testConvertToSnakeCase
     *
     * @param array $array
     * @return array
     */
    public function convertToSnakeCaseOrCamelCaseMulti(array $array, bool $isCamelCase): array
    {
        return array_map(
            function ($item) use ($isCamelCase) {
                if (is_array($item) || is_object($item)) {
                    $item = $this->convertToSnakeCaseOrCamelCaseMulti((array)$item, $isCamelCase);
                }
                return $item;
            },
            $isCamelCase ? $this->snakeToCamelCase($array) : $this->toSnakeCase($array)
        );
    }

    /**
     * 配列のキーをスネークケースに変更(１階層のみ)
     *
     * example
     *  input
     *      ["JollyPasta" => "JollyPasta",  "Hoge" => "hoGe"]
     *  output
     *      ["jolly_pasta" => "JollyPasta", "hoge" => "hoGe"]
     *
     * @return array
     */
    protected function toSnakeCase(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $key = strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $key));

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * convert to camelCase
     *
     * @param array $array
     * @return array
     */
    protected function snakeToCamelCase(array $array) : array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $key = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            $result[$key] = $value;
        }

        return $result;
    }
}
