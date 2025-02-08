<?php

namespace App\Repositories\Eloquent\Companies;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Gallery\GalleryRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Companies\Gallery;
use App\Services\FileStorageService;

class GalleryRepository extends AbstractRepository implements GalleryRepositoryInterface
{
    /**
     * @var Gallery
     */
    protected $model = Gallery::class;

    /**
     * @var FileStorageService
     */
    protected $fileStorageService;

    public function __construct(
        Gallery $model,
        FileStorageService $fileStorageService
    )
    {
        $this->model = $model;
        $this->fileStorageService = $fileStorageService;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model->orderBy('name', 'asc');

        if ($role != 'super') {
            $query->where('company_id', $request->user()->company_id);
        }

        if (isset($params['term']) && !empty($params['term'])) {
            $query->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['term'] . '%');
                $query->orWhere('extension', 'like', '%' . $params['term'] . '%');
            });
        }

        if (isset($params['company_id']) && !empty($params['company_id'])) {
            $query->where('company_id', $params['company_id']);
        }

        if (isset($params['per_page'])) {
            $result = $query->paginate($params['per_page']);
        } else {
            $result = $query->get();
        }

        return $result;
    }

    public function getById($id)
    {
        $data = $this->show($id);

        $check = $this->checkData($data, 'Registro de imagem não encontrada na Galeria!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        return $data;
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['uuid'] = Str::uuid();
        $data['company_id'] = $request->user()->company_id;

        if ($request->hasFile('photo_full') && $request->file('photo_full')->isValid()) {
            // Obtém o arquivo da requisição
            $file = $request->file('photo_full');

            // Obter a extensão do arquivo
            $data['extension'] = $file->getClientOriginalExtension();

            // Salvar o arquivo com um nome único
            $filePath = $this->fileStorageService->saveFile($file, 'gallery/' . $data['company_id']);

            // Salvar o caminho completo do arquivo
            $data['photo_full'] = $filePath;

            // Salvar o nome do arquivo
            $data['name'] = $file->getClientOriginalName(); // ou pode usar o nome gerado
        } elseif ($this->fileStorageService->isBase64($data['photo_full'])) {
            // Se for Base64
            $data['photo_full'] = $this->fileStorageService->saveBase64File(
                $data['photo_full'],
                'gallery/' . $data['company_id']
            );
        } else {
            // Caso nenhum dos dois tipos seja válido
            return [
                'message' => 'Formato inválido',
                'code' => 400,
                'error' => true
            ];
        }

        $gallery = $this->store($data);

        if (!$gallery) {
            return [
                'message' => 'Falha ao criar dados!',
                'code' => 500,
                'error' => true
            ];
        }

        return $gallery;
    }

    public function updateGallery(Request $request, $uuid)
    {
        $data = $request->all();

        $gallery = $this->show($uuid);

        $check = $this->checkData($gallery, 'Registro de imagem não encontrada na Galeria!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        if (isset($data['photo_full']) && !empty($data['photo_full'])) {
            // Delete the old file if exists
            if (!empty($gallery->photo_full)) {
                $this->fileStorageService->deleteFile($gallery->photo_full);
            }

            // Save the new file
            $data['photo_full'] = $this->fileStorageService->saveBase64File(
                $data['photo_full'],
                'gallery/' . $gallery->company_id
            );
        }

        $gallery->fill($data);

        if (!$gallery->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500,
                'error' => true
            ];
        }

        return $gallery;
    }

    public function deleteGallery($uuid)
    {
        $gallery = $this->show($uuid);

        $check = $this->checkData($gallery, 'Registro de imagem não encontrada na Galeria!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        // Delete the file if exists
        if (!empty($gallery->photo_full)) {
            $this->fileStorageService->deleteFile($gallery->photo_full);
        }

        $gallery->delete();

        return [
            'message' => 'Deletado com sucesso!',
            'code' => 200,
            'error' => true
        ];
    }
}
