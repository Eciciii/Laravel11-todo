<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'judul'     => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kategori'  => $this->kategori,
            'prioritas' => $this->prioritas,
            'status'    => $this->status,
            'deadline'  => $this->deadline,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
