<?php

namespace Modules\Product\Controllers;

use App\Http\Controllers\API\BaseApiController;
use Modules\Product\Requests\ProductRequest;
use Modules\Product\Services\ProductService;

class ProductController extends BaseApiController
{
    public function __construct(private ProductService $service) {}

    public function index()
    {
        return $this->paginated($this->service->list(request()->all()));
    }

    public function show($id)
    {
        return $this->success($this->service->show($id));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image_file')) {
            $data['image_file'] = $request->file('image_file');
        }
        if ($request->hasFile('image_files')) {
            $data['image_files'] = $request->file('image_files');
        }
        return $this->success($this->service->store($data), 'Product created', 201);
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->validated();
        if ($request->hasFile('image_file')) {
            $data['image_file'] = $request->file('image_file');
        }
        return $this->success($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return $this->success([], 'Product deleted');
    }

    public function bulkDelete()
    {
        request()->validate(['ids' => 'required|array', 'ids.*' => 'integer']);
        $this->service->bulkDestroy(request('ids'));
        return $this->success([], 'Products deleted');
    }
}
