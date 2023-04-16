<?php

use Symfony\Component\HttpClient\DecoratorTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class FakeCacheHeaderClient implements HttpClientInterface
{
    use DecoratorTrait;

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $response = $this->client->request($method, $url, $options);
        // Break Async: we don't care here, but we need all headers to be able to update them
        $response->getStatusCode();

        return new class($response) implements ResponseInterface {
            public function __construct(
private ResponseInterface $response,
            ) {
            }

            public function getStatusCode(): int
            {
                return $this->response->getStatusCode();
            }

            public function getHeaders(bool $throw = true): array
            {
                $headers = $this->response->getHeaders($throw);

                // One month
                $headers['cache-control'] = 'public, max-age=2592000, s-maxage=2592000';

                return $headers;
            }

            public function getContent(bool $throw = true): string
            {
                return $this->response->getContent($throw);
            }

            public function toArray(bool $throw = true): array
            {
                return $this->response->toArray($throw);
            }

            public function cancel(): void
            {
                $this->response->cancel();
            }

            public function getInfo(?string $type = null): mixed
            {
                return $this->response->getInfo();
            }
        };
    }
}

