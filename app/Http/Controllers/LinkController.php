<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Components\HashGeneratorInterface;
use App\Link;
use App\Repositories\LinkRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LinkController extends Controller
{
    /**
     * @var LinkRepositoryInterface
     */
    private $repository;
    /**
     * @var HashGeneratorInterface
     */
    private $hashGenerator;

    /**
     * @param LinkRepositoryInterface $repository
     * @param HashGeneratorInterface $hashids
     */
    public function __construct(LinkRepositoryInterface $repository, HashGeneratorInterface $hashids)
    {
        $this->repository = $repository;
        $this->hashGenerator = $hashids;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request) : JsonResponse
    {
        $this->validate($request, ['url' => 'required|url']);
        $link = $this->repository->create(
            $this->hashGenerator->generate(),
            $request->post('url')
        );
        return response()->json($this->mapResponse($link))->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param $uri
     * @return JsonResponse
     */
    public function show($uri) : JsonResponse
    {
        return response()->json(
            $this->mapResponse($this->repository->findByShortUri($uri))
        );
    }

    /**
     * @param Link $link
     * @return array
     */
    private function mapResponse(Link $link) : array
    {
        return [
            'short_uri' => $link->short_uri,
            'full_url' => $link->full_url,
            'expires_at' => $link->expires_at,
        ];
    }
}
