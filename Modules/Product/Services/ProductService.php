<?php

namespace Modules\Product\Services;

use App\Services\BaseService;
use Modules\Product\Repositories\ProductRepository;

class ProductService extends BaseService
{
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(array $data): mixed
    {
        if (!empty($data['image_file'])) {
            $data['image'] = upload_image($data['image_file'], 'products');
            unset($data['image_file']);
        }

        if (!empty($data['image_files'])) {
            $data['images'] = [];
            foreach ($data['image_files'] as $file) {
                $data['images'][] = upload_image($file, 'products');
            }
            unset($data['image_files']);
        }

        return parent::store($data);
    }

    public function update($id, array $data): mixed
    {
        $product = $this->show($id);

        if (!empty($data['image_file'])) {
            delete_image($product->image);
            $data['image'] = upload_image($data['image_file'], 'products');
            unset($data['image_file']);
        }

        return parent::update($id, $data);
    }

    public function destroy($id): mixed
    {
        $product = $this->show($id);
        delete_image($product->image);

        if ($product->images) {
            foreach ($product->images as $img) {
                delete_image($img);
            }
        }

        return parent::destroy($id);
    }
}
