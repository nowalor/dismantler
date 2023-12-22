<?php

namespace App\Actions\Ebay;

class EbayAction
{
    private Client $client;
    private string $apiUrl;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $this->apiUrl = config('services.ebay.api_url');
    }

    protected function getApiToken(): string
    {
//        $authorizationHeader = base64_encode(
//            config('services.ebay.app_id') . ':' . config('services.ebay.cert_id')
//        );
//
//        $scope = 'https://api.ebay.com/oauth/api_scope';
//
//        $payload = [
//          'grant_type' => 'client_credentials',
//          'scope' => $scope,
//        ];
//
//        // Add a Basic Authorization header
//        $response = $this->client->post($this->apiUrl . '/identity/v1/oauth2/token', [
//            'form_params' => $payload,
//            'headers' => [
//                'Authorization' => 'Basic ' . $authorizationHeader,
//            ],
//        ]);
//
//        $data = json_decode(
//            $response->getBody()->getContents(),
//            true, 512, JSON_THROW_ON_ERROR
//        );
//
//        return $data['access_token'];

        return 'v^1.1#i^1#f^0#I^3#r^0#p^3#t^H4sIAAAAAAAAAOVZf2wb1R2PkzRtBi2iY23HKJgbiDE4+374151wVCdxGq9xnNiBthmd9e7uXfzw+e56710Sdz8UZVJRiaYBhT/Q+KPTfrGmQqqQKroJ9geVxhhj07Sp1UBlGhpD67QNoTIEk7Z3dpo6QTSxr+oszf9Y9+776/P99e77HjfX0/vFw8OH/7U5sLHz2Bw31xkI8NdxvT0b7tnS1Xnzhg6ugSBwbO6Oue75rnfuw6Bi2HIeYtsyMQzOVgwTy7XFJOM6pmwBjLBsggrEMlHlQio7IgshTrYdi1iqZTDBzGCSkQRJgAoPREmBMUGM0lXzkswJK8moGicByCeAHo/wiqjQ9xi7MGNiAkySZAROEFleYLnYBJ+QuagclUKRSHSSCT4AHYwsk5KEOKavZq5c43UabL2yqQBj6BAqhOnLpIYKuVRmMD06cV+4QVbfkh8KBBAXr3wasDQYfAAYLryyGlyjlguuqkKMmXBfXcNKoXLqkjEtmF9ztSIKUIoBISLEdU3ltaviyiHLqQByZTu8FaSxeo1UhiZBpLqWR6k3lIegSpaeRqmIzGDQ+xt3gYF0BJ0kk+5P7b+/kM4zwcLYmGNNIw1qHlJejIgSH43yTB+BmLoQOkUTlV0DYAuXgYOxZS7prAte8vgqpQOWqSHPfzg4apF+SAHAlW6Ky9EGN1GinJlzUjrxjGugE7hld3KTXnzrAXVJyfRCDCvUJ8Ha49rBuJQdl/PhauVHTJT0GCcARRDFuCrw9fzwat1fjvR5YUqNjYU9W6ACqmwFOGVIbAOokFWpe90KdJAmi1FdEBM6ZLWYpLMRSddZJarFWF6HkINQUVQp8X+aKoQ4SHEJXE6X1S9qeJNMQbVsOGYZSK0yq0lqnWgpOWZxkikRYsvh8MzMTGhGDFnOVFjgOD68LztSUEuwAphlWrQ2MYtqKaJCyoWRTKo2tWaWZiFVbk4xfaKjjQGHVPvdKn0uQMOgf5cyeYWFfatXPwHqgIGoHyaoovZCOmxhAjVf0DQ4jVRYRNo1RubV+hroWN4XMsOaQmYWkpJ1rbGtgSudTWVGfEGjnRSQ9gLV2H+4pf4jxiWWi8sc5wtsyrYzlYpLgGLATJuFMsILkWjEFzzbda958a2BalaxCJ+IVh1Q9gXN24BlBHSv1mVilaHZfi00nx7KpwvDxYncnvSoL7R5qDsQlyY8nO2Wp6nxVDpFf9lcNquM551JrXzIjPHA2ntwj5HW7IoCRDzkwL3h4Uwhv0/KR6AgunFd0vjIVFaJhpUBZUSy4MB4MunLSQWoOrDNWtfBLCw8tFudMoF2SBmcKVe+ND4kDfKHSrvHXXUc9xNTDOf2zKal3Rl/4CfaswSceuIWaxVapE9+QHq1zqSn2q6niRAm6H5Ex3uVAwCqqqApOqfq9CdBQYr53qLaDO+oN1hgXGazoOw6cCzHFvr3sXE9AiK6BAQ2okBvSE/43LvaLcxXa+vC3nDTXtA8fkwFABuFvJ01pFqVsAXoKO8tFWsWB9dDFFbcKtWvQSfkQKBZplFdP9+US0fXOnfQq/V1MWI6g4XqkziF0qTWlcxN8CBzmk5tllNtReEycxM8QFUt1yStqFtibYJDdw0dGYY3oLeisIG9GTNNYFQJUnHrMawdxVD3YjRVIs3KoWsV6FB+FRBAB7wWEhiXLNv2slAFzjqh1+pF12m9AFetHXs1ZyzS6geRrYJd5qddAhm+pdgly4TNSvFq/WOSgKbRL4eWg7gsxzsv9C2kfrTdUi0g0+u7uJn2QGAlpDlAb6Z6bFCtlauGsO1tNc2pa4LcgVQ+WH+mrmJqNRSmRZCO1LoM7CpYdZDdQr18opxlw/ydnkANOVAlRddB7bXF1z7airi4dBrMrvqIY6ul6sys4Qu85/O1DsW65zsX/xfwx1KFwt5cftAXwEE43W7f4nT2iMKIwrMJnQNshE/EWImLa6zCS1KCTiE64OO+MLfdaSAf5/hEIipF1z1XrVpouHz42BVUeOV1cF9H7cfPB17g5gOnOwMBLs6x/D3c3T1d93d3Xc9g2j1DGJiaYs2GENBD9NPDpHuFA0NlWLUBcjp7AugPv1M/aLiIPnaA27F8Fd3bxV/XcC/N3XL5zQb+hu2bBZEXuBif4KJRaZL7/OW33fy27pteXci/9egX/nJqYduNr05/a+Lun9988hy3eZkoENjQ0T0f6CjtOvPj8QfvfXyh5/QP3z17dvLFZ3e9Yfz2w58+9vTcb46e3JSo3PrOOeOfJ350vPLazpmujQev33p4Rnz/ye++++3fHx82fzn92qPfX/jb+a2PndG/ceSZ6snCjXP2RfMn8r9797/y9wvbbn1FPLH9Owff3Nrz2eyW/RdjP/vmyJ8WLnZe+GDHgWfPTA1uCsSSO3PSJvVI9nM/uHPL23fmv3z+QsfbB45u7EWLI+fee/7X/HNP3TH55/fnZl//+pPfW9wVe/nhjjdP7+zqX3xxe/DTf9Q+FT119uHFIyefV1/4zMvPfAVVP7rrF7fNDl14+qZf/fXEG7fd8vrRnEM+vPfBl3bY7iPHh/9x+1dPyGK869QTX3vro/P/ee/2/pfqYfwvcLVsyiIgAAA=';
    }
}
