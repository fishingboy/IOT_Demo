<?php

use Curl\Curl;

class Github_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model("logs_model");
    }
    
    public function getStar()
    {
        $api_url = "https://api.github.com/users/fishingboy/repos";

        $curl = new Curl();
        $repositories = $curl->get($api_url);

        $total_star = 0;
        $stared_repositories = [];
        foreach ($repositories as $repository) {
            $total_star += $repository->stargazers_count;

            if ($repository->stargazers_count > 0) {
                $stared_repositories[] = [
                    "name" => $repository->name,
                    "star" => $repository->stargazers_count,
                ];
            }
        }

        usort($stared_repositories, function ($a, $b) {
            return $b['star'] <=> $a['star'];
        });

        return [
            "total_star" => $total_star,
            "repositories" => $stared_repositories,
        ];
    }
}