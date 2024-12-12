<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'views' => $this->number_of_views,
            'status' => $this->status(),
            'date' => $this->created_at->format('Y-m-d H:i:s A'),
            'publisher' => $this->user_id == null ? AdminResource::make($this->admin) : UserResource::make($this->user),

            'media' => ImageResource::collection($this->images),
        ];

        // Check if the request is for 'api/posts/show' and add additional data
        if ($request->is('api/posts/show/*')) {
            $data['comment_able'] = $this->comment_able == 1 ? 'Active' : 'Not Active';
            $data['small_desc'] = $this->small_desc;
            $data['category'] = CategoryResource::make($this->category);
        }

        return $data;
    }
}
