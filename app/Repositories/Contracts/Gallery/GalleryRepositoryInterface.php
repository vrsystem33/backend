<?php

namespace App\Repositories\Contracts\Gallery;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface GalleryRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($uuid);

    public function create(Request $request);

    public function updateGallery(Request $request, $uuid);

    public function deleteGallery($uuid);
}