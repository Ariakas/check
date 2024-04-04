<?php
    namespace Check;

    use CurlHandle;

    class HTTP {
        private CurlHandle $curl;
        private array $headers;

        public function __construct() {
            $this->curl = curl_init();
            $this->headers = [
                "Content-Type: application/x-www-form-urlencoded",
                "Accept-Encoding: gzip, deflate, br",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 OPR/101.0.0.0"
            ];
            curl_setopt($this->curl, CURLOPT_HEADER, true);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_ENCODING , 'gzip');
        }

        public function set_post(): void {
            curl_setopt($this->curl, CURLOPT_POST, true);
        }

        public function set_header($value): void {
            $header_name = explode(":", $value)[0];
            $this->headers = array_filter($this->headers, function ($header) use ($header_name) {
                return mb_strpos($header, "$header_name:") === false;
            });
            $this->headers[] = $value;
        }

        public function set_url($url): void {
            curl_setopt($this->curl, CURLOPT_URL, $url);
        }

        public function set_payload($data): void {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        public function execute(): array|string {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
            $result = curl_exec($this->curl);
            $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
            $headers = explode("\r\n", mb_substr($result, 0, $header_size));
            $response_headers = [];
            foreach ($headers as $header) {
                $header = explode(":", $header, 2);
                if (count($header) > 1) {
                    $response_headers[] = $header;
                }
            }
            $response_headers = array_map(function ($header) {
                $header[1] = trim($header[1]);
                return $header;
            }, $response_headers);
            $body = mb_substr($result, $header_size);
            if ($result) {
                return [
                    "body" => $body,
                    "headers" => $response_headers
                ];
            }
            else {
                return curl_error($this->curl);
            }
        }

        static function response_error($detail = null): void {
            $response = [
                "status" => "error"
            ];
            if (!is_null($detail)) {
                $response["detail"] = $detail;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        static function response_success($detail = null): void {
            $response = [
                "status" => "success"
            ];
            if (!is_null($detail)) {
                $response["detail"] = $detail;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }